<?php
class JNE
{
    // Base URL of JNE website
    const BASE_URL = 'http://www.jne.co.id';
    // CAPTCHA URL
    const CAPTCHA_URL = 'captcha.php';
    // LOCATIONS URL
    const LOCATIONS_URL = 'tariff_away.php';
    // TARIFF ENDPOINT URL
    const TARIFF_URL = 'index.php?mib=tariff&lang=IN';


    /**
     * Method for retrieving session ID given by the JNE homepage
     * 
     * @return  string  PHPSESSID cookie set by JNE homepage
     * @access  public
     */
    public function getSessionID()
    {
        $headers = get_headers(self::BASE_URL);
        return $this->extractSessionID($headers);
    }


    /**
     * Method for retrieving CAPTCHA image and its session ID
     * 
     * @return  array   An associative array that hold base64 encoded CAPTCHA
     *                  image and its session ID for validation
     * @access  public
     */
    public function getCAPTCHA()
    {
        // Construct CAPTCHA image URL
        $imgUrl = sprintf('%s/%s?%d', 
            self::BASE_URL, self::CAPTCHA_URL, rand());
        // Get CAPTCHA image
        $img = file_get_contents($imgUrl);
        // Return back base64 encoded data and its session ID
        return array(
            'base64_img'    => base64_encode($img),
            'session_id'    => $this->extractSessionID($http_response_header)
        );
    }


    /**
     * Method for retrieving locations suggestions list
     * 
     * @return  string  List of locations suggestions in JSON formated data
     * @access  public
     */
    public function getLocations()
    {
        // Get homepage session ID & location query
        $sessionID = (string) $_GET['session_id'];
        $query = (string) $_GET['query'];

        // Setup HTTP header with PHPSESSID injected
        $options = array(
            'http'  => array(
                'header'    => "Cookie: PHPSESSID={$sessionID}\r\n",
                'method'    => "GET",
            )
        );
        // Create stream context resource
        $context = stream_context_create($options);

        // Finaly send request
        $url = sprintf('%s/%s?qwaway=%s', 
            self::BASE_URL, self::LOCATIONS_URL, $query);
        $list = file_get_contents($url, false, $context);

        // Re-format returend response
        $list = $this->formatSuggestions($list);
        return json_encode($list);
    }


    /**
     * Method for getting the result of tariff checker
     * 
     * @return  void
     * @access  public
     */
    public function getResult()
    {
        // Get all required input
        $data = $this->getAllInput();
        // Send POST request
        $response = $this->sendPOSTRequest($data);

        echo $response;
    }


    /**
     * Method for extracting PHPSESSID cookie
     * 
     * @param   array   $headers    An array that hold HTTP header data
     * @return  string  The value of the current session ID from JNE website
     * @access  private
     */
    private function extractSessionID($headers)
    {
        // Loop through each header items
        foreach ($headers as $header) {
            // If header item contains "PHPSESSID" cookie, retirieve it!!
            if (strpos($header, 'PHPSESSID')) {
                $start = strlen('Set-Cookie: PHPSESSID=');
                $end = strpos($header, ';');
                return substr($header, $start, $end - $start);
            }
        }
    }


    /**
     * Method for formating locations list returned by JNE
     * 
     * @param   string  $list   Location list returned by JNE
     * @return  array   A well formatted array to be used by autocomplete
     * @access  private
     */
    private function formatSuggestions($list)
    {
        // Explode each line!
        $list = explode("\n", $list);
        // New suggestions format
        $suggestions = array();

        // Loop through each list
        foreach ($list as $data) {
            // If has no "|" skip it!
            $data = trim($data);
            if (strpos($data, '|') === false) continue;

            // Get both location text and it's ID
            $data = explode('|', $data);
            array_push($suggestions, array(
                'value' => $data[0],
                'data'  => $data[1]
            ));
        }

        return $suggestions;
    }


    /**
     * Method for retrieving all required input from the submitted form
     * 
     * @return  array   An associative array that hold POST data
     * @access  private
     */
    private function getAllInput()
    {
        // If on eof the required data is not exist, redirect back!
        if (!isset($_POST['origin_code'])           || 
            !isset($_POST['destination_code'])      ||
            !isset($_POST['captcha_session_id'])    ||
            !isset($_POST['from'])                  ||
            !isset($_POST['to'])                    ||
            !isset($_POST['weight'])                ||
            !isset($_POST['captcha'])) {

            header('location: index.php');
            die();
        } 

        return array(
            'origin_code'           => htmlentities(trim($_POST['origin_code'])),
            'destination_code'      => htmlentities(trim($_POST['destination_code'])),
            'captcha_session_id'    => htmlentities(trim($_POST['captcha_session_id'])),
            'from'                  => htmlentities(trim($_POST['from'])),
            'to'                    => htmlentities(trim($_POST['to'])),
            'weight'                => (float) trim($_POST['weight']),
            'captcha'               => htmlentities(trim($_POST['captcha']))
        );
    }


    /**
     * Method for sending POST request to tariff checker endpoint
     * 
     * @param   array   $data       An array that hold POST data
     * @return  string  HTML string of response page
     * @access  private
     */
    private function sendPOSTRequest($data)
    {

        // Prepare HTTP header
        $options = array(
            'http'  => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                            "Cookie: PHPSESSID={$data['captcha_session_id']}\r\n",
                'method' => "POST",
                'content'=> http_build_query($data)
            )
        );

        // Create stream context resource
        $context = stream_context_create($options);

        // Finaly send request
        $url = sprintf('%s/%s', self::BASE_URL, self::TARIFF_URL);
        return file_get_contents($url, false, $context);
    }
}