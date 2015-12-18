<?php

namespace Jne\Contracts;

interface HttpClient {
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
     * @return Psr\Http\Message\ResponseInterface
     */
    public function get($uri);

    /**
     * Send HTTP POST request.
     *
     * @param string $uri
     * @param array  $data
     * @return Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $data = []);
}
