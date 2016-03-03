<?php

namespace Jne\Contracts;

use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    /**
     * Get base uri.
     *
     * @return string
     */
    public function baseUri();

    /**
     * Send HTTP GET request.
     *
     * @param string $uri
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri);

    /**
     * Send HTTP POST request.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $data = []);

    /**
     * Parse JSON response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return array
     */
    public function parseJsonResponse(ResponseInterface $response);

    /**
     * Parse HTML response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function parseHtmlResponse(ResponseInterface $response);

    /**
     * Send HTTP GET request and JSON response.
     *
     * @param string $uri
     *
     * @return array
     */
    public function getAndParseJson($uri);
}
