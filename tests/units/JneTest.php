<?php

use Jne\Jne;
use Jne\Contracts\HttpClient;
use Jne\Contracts\Foundation\Location;
use Jne\Contracts\Collections\TariffCollection;
use Jne\Contracts\Collections\LocationCollection;

class JneTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function jne_has_http_client()
    {
        $jne = new Jne();

        $this->assertInstanceOf(HttpClient::class, $jne->httpClient());
    }

    /** @test */
    function jne_can_search_for_origin()
    {
        $jne = new Jne();

        $origins = $jne->searchOrigin('Bandung');

        $this->assertInstanceOf(LocationCollection::class, $origins);

        $origins->each(function($origin) {
            $this->assertInstanceOf(Location::class, $origin);
        });
    }

    /** @test */
    function jne_can_search_for_destination()
    {
        $jne = new Jne();

        $destinations = $jne->searchDestination('Depok');

        $this->assertInstanceOf(LocationCollection::class, $destinations);

        $destinations->each(function($destination) {
            $this->assertInstanceOf(Location::class, $destination);
        });
    }
}
