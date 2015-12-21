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
        $httpClient = new HttpClient('http://www.mocky.io/v2/');

        $response = $httpClient->get('5678638b0f00006a2a500861');

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /** @test */
    function http_client_has_post_request()
    {
        $httpClient = new HttpClient('http://www.mocky.io/v2/');

        $response = $httpClient->post('5678638b0f00006a2a500861', []);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /** @test */
    function http_client_can_parse_json_response()
    {
        $httpClient = new HttpClient('http://www.mocky.io/v2/');

        $response = $httpClient->get('5678638b0f00006a2a500861');

        $this->assertEquals(['foo' => 'bar', 'baz' => 123], $httpClient->parseJsonResponse($response));
    }

    /** @test */
    function http_client_can_parse_html_response()
    {
        $httpClient = new HttpClient('http://www.mocky.io/v2/');

        $response = $httpClient->get('567864160f0000332a500862');

        $this->assertInstanceOf(Crawler::class, $httpClient->parseHtmlResponse($response));
    }

    /** @test */
    function http_client_can_send_get_request_and_parse_json_response()
    {
        $httpClient = new HttpClient('http://www.mocky.io/v2/');

        $data = $httpClient->getAndParseJson('5678638b0f00006a2a500861');

        $this->assertEquals(['foo' => 'bar', 'baz' => 123], $data);
    }

    /** @test */
    function http_client_can_send_post_request_and_parse_html_response()
    {
        $httpClient = new HttpClient('http://www.mocky.io/v2/');

        $data = $httpClient->postAndParseHtml('567864160f0000332a500862');

        $this->assertInstanceOf(Crawler::class, $data);
    }
}
