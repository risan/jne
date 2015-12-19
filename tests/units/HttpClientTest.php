<?php

use Jne\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

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

    /** @test */
    function http_client_can_parse_json_response()
    {
        $httpClient = new HttpClient('http://mockbin.org/bin/');

        $response = $httpClient->get('3e5a46be-5d70-41c1-8d99-9effb755bbe2');

        $this->assertEquals(['foo' => 'bar', 'baz' => 123], $httpClient->parseJsonResponse($response));
    }

    /** @test */
    function http_client_can_parse_html_response()
    {
        $httpClient = new HttpClient('http://mockbin.org/bin/');

        $response = $httpClient->get('4a76d7e2-5c72-49c5-b6ea-388de8ca5041');

        $this->assertInstanceOf(Crawler::class, $httpClient->parseHtmlResponse($response));
    }

    /** @test */
    function http_client_can_send_get_request_and_parse_json_response()
    {
        $httpClient = new HttpClient('http://mockbin.org/bin/');

        $data = $httpClient->getAndParseJson('3e5a46be-5d70-41c1-8d99-9effb755bbe2');

        $this->assertEquals(['foo' => 'bar', 'baz' => 123], $data);
    }

    /** @test */
    function http_client_can_send_post_request_and_parse_html_response()
    {
        $httpClient = new HttpClient('http://mockbin.org/bin/');

        $data = $httpClient->postAndParseHtml('4a76d7e2-5c72-49c5-b6ea-388de8ca5041');

        $this->assertInstanceOf(Crawler::class, $data);
    }
}
