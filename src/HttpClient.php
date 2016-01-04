<?php

namespace Jne;

use GuzzleHttp\Client as Guzzle;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;
use Jne\Contracts\HttpClient as HttpClientInterface;

class HttpClient extends Guzzle implements HttpClientInterface
{
    /**
     * Http base uri.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Create a new instance of HttpClient.
     *
     * @param string $baseUri
     */
    public function __construct($baseUri)
    {
        $this->baseUri = $baseUri;

        parent::__construct([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Accept' => 'text/plain',
                'Accept-Encoding' => 'gzip, deflate, sdch',
                'Accept-Language' => 'en-US',
                'Host' => 'www.jne.co.id',
                'Referer' => 'http://www.jne.co.id/home.php',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36',
            ],
        ]);
    }

    /**
     * Get base uri.
     *
     * @return string
     */
    public function baseUri()
    {
        return $this->baseUri;
    }

    /**
     * Send HTTP GET request.
     *
     * @param string $uri
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    public function get($uri)
    {
        return $this->request('GET', $uri);
    }

    /**
     * Send HTTP POST request.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $data = [])
    {
        return $this->request('POST', $uri, [
            'form_params' => $data,
        ]);
    }

    /**
     * Parse JSON response.
     *
     * @param Psr\Http\Message\ResponseInterface $response
     *
     * @return array
     */
    public function parseJsonResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody(), 1);
    }

    /**
     * Parse HTML response.
     *
     * @param Psr\Http\Message\ResponseInterface $response
     *
     * @return Symfony\Component\DomCrawler\Crawler
     */
    public function parseHtmlResponse(ResponseInterface $response)
    {
        $html = $response->getBody()->getContents();

        return new Crawler($html);
    }

    /**
     * Send HTTP GET request and JSON response.
     *
     * @param string $uri
     *
     * @return array
     */
    public function getAndParseJson($uri)
    {
        $response = $this->get($uri);

        return $this->parseJsonResponse($response);
    }

    /**
     * Send HTTP POST request.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return Symfony\Component\DomCrawler\Crawler
     */
    public function postAndParseHtml($uri, array $data = [])
    {
        $response = $this->post($uri, $data);

        return $this->parseHtmlResponse($response);
    }
}
