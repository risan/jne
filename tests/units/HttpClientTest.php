<?php

use Jne\HttpClient;
use Psr\Http\Message\ResponseInterface;

class HttpClientTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function http_client_has_base_uri()
    {
        $httpClient = new HttpClient('http://foo.bar');

        $this->assertEquals('http://foo.bar', $httpClient->baseUri());
    }

    /** @test */
    function http_client_has_get_request()
    {
        $httpClient = new HttpClient('http://mockbin.org/bin/');

        $response = $httpClient->get('4a76d7e2-5c72-49c5-b6ea-388de8ca5041');

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /** @test */
    function http_client_has_post_request()
    {
        $httpClient = new HttpClient('http://mockbin.org/bin/');

        $response = $httpClient->post('4a76d7e2-5c72-49c5-b6ea-388de8ca5041', []);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
