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
     * @return  string  The HTML page response
     * @access  public
     */
    public function getResponse()
    {
        // Get all required input
        $data = $this->getAllInput();
        // Send POST request
        $response = $this->sendPOSTRequest($data);

        // If CAPTCHA is invalid, redirect back!
        if (!$this->validateCAPTCHA($response)) {
            $this->flash('old', $data);
            header('Location: index.php');
            die();
        }

        return $response;
    }


    /**
     * Method for parsing response data
     * 
     * @param   string  $response HTML response page returned by JNE
     * @return  array   An associative array that hold tariff data
     * @access  public
     */
    public function parseResponse($response)
    {
        // Create DOM document and DOM XPath object
        $dom = new DomDocument();
        @$dom->loadHTML($response);
        $xpath = new DomXPath($dom);

        // Get header data
        $header = $this->getTariffHeader($xpath);
        // Get tariff content table
        $content = $this->getTariffContent($xpath);

        return array(
            'header'    => $header,
            'content'   => $content
        );
    }


    /**
     * Method for retrieving flashed old input
     * 
     * @param   string  $input  Input field to retrieve
     * @return  mixed   An old input value
     * @access  public
     */
    public function old($input)
    {
        // If there is no flashed old data, return an empty string
        if (!isset($_SESSION['old'])) return '';

        // If session old is not an array, return an empty string
        if (!is_array($_SESSION['old'])) {
            unset($_SESSION['old']);
            return '';
        }

        // If the requested key is not exits, return an empty string
        if (!isset($_SESSION['old'][$input])) return '';

        // Get the old input and unset it!
        $old = $_SESSION['old'][$input];
        unset($_SESSION['old'][$input]);
        return $old;
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


    /**
     * Method for checking whether the CAPTCHA is valid or note
     * 
     * @param   string  $html   The HTML response page
     * @return  bool    Return TRUE if the CAPTCHA is correct, FALSE otherwise
     * @access  private
     */
    private function validateCAPTCHA($html)
    {
        if (strpos($html, 'Wrong Captcha') !== false) return false;
        return true;
    }


    /**
     * Method for flashing data to session
     * 
     * @param   string  $key    Key name for the flashed data
     * @param   mixed   $value  Data to be flashed to session
     * @return  void
     * @access  private
     */
    private function flash($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    /**
     * Method for parsing tariff content table header and meta
     * 
     * @param   object  $xpath  An instance of XPath class
     * @return  array   An array that hole tariff content header
     * @access  private
     */
    private function getTariffHeader($xpath)
    {
        // Get all rows header, based on 'trfH' class
        $rows = $this->getNodesByTagClass($xpath, 'tr', 'trfH');

        // Retrieve "from", "to", and "weight"
        $from = $rows->item(0)->childNodes->item(2)->textContent;
        $to = $rows->item(1)->childNodes->item(2)->textContent;
        $weight = $rows->item(2)->childNodes->item(2)->textContent;

        // Retrieve content table header
        $contentHeader = array();
        if ($rows->length >= 4) {
            $cols = $rows->item(3)->childNodes;
            for ($i = 0; $i < $cols->length; $i++) {
                $data = trim($cols->item($i)->textContent);
                if (strlen($data)) array_push($contentHeader, $data);
            }
        }

        return array(
            'from'      => $from,
            'to'        => $to,
            'weight'    => $weight,
            'header'    => $contentHeader
        );
    }


    /**
     * Method for parsing tariff content table
     * 
     * @param   object  $xpath  An instance of XPath class
     * @return  array   An array that hole tariff content data
     * @access  private
     */
    private function getTariffContent($xpath)
    {
        // An array that would hold content
        $content = array();

        // Get all rows content, based on 'trfC' class
        $rows = $this->getNodesByTagClass($xpath, 'tr', 'trfC');

        // Loop through each content rows
        for ($i = 0; $i < $rows->length; $i++) {
            $content[$i] = array();                 // Create new array item
            $cols = $rows->item($i)->childNodes;    // Get all columns
            // Loop through each columns
            for ($j = 0; $j < $cols->length; $j++) {
                $data = trim($cols->item($j)->textContent);
                if (strlen($data)) $content[$i][$j] = $data;
            }
        }

        return $content;
    }


    /**
     * Function to get nodes object by tag and class name
     * 
     * @param   object  $xpath      PHP XPath class instance
     * @param   string  $tag        The HTML tag to look for
     * @param   string  $className  The requested class name to search for
     * @param   int     $index      An optional parameter which indicate an 
     *                              index of node to return
     * @return  mixed   Would return FALSE if there is no matched nodes or the
     *                  requested nodes at specified index is not available.
     *                  Would return a nodeList object if there is no index 
     *                  specified. Would return a single node object at 
     *                  specified index.
     * @access  private
     */
    private function getNodesByTagClass($xpath, $tag, $className, $index = null)
    {
        // Use xPath to query nodes by tag and class name
        $nodeList = $xpath->query("//{$tag}[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]");

        // If there is no nodes match, return false
        if ($nodeList->length <= 0) return false;

        // If $index is not specified, return all matched nodes
        if (is_null($index)) return $nodeList;

        // If requested $index is not available, return false
        if ($index >= $nodeList->length) return false;

        // Return nodes at requested $index
        return $nodeList->item($index);
    }
}