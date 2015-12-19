<?php

use Jne\Jne;
use Jne\Packet;
use Jne\Weight;
use Jne\Location;
use Jne\Contracts\HttpClient as HttpClientInterface;
use Jne\Contracts\Foundation\Location as LocationInterface;
use Jne\Contracts\Collections\DeliveryCollection as DeliveryCollectionInterface;
use Jne\Contracts\Collections\LocationCollection as LocationCollectionInterface;

class JneTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function jne_has_http_client()
    {
        $jne = new Jne();

        $this->assertInstanceOf(HttpClientInterface::class, $jne->httpClient());
    }

    /** @test */
    function jne_can_search_for_origin()
    {
        $jne = new Jne();

        $origins = $jne->searchOrigin('Bandung');

        $this->assertInstanceOf(LocationCollectionInterface::class, $origins);

        $origins->each(function($origin) {
            $this->assertInstanceOf(LocationInterface::class, $origin);
        });
    }

    /** @test */
    function jne_can_search_for_destination()
    {
        $jne = new Jne();

        $destinations = $jne->searchDestination('Depok');

        $this->assertInstanceOf(LocationCollectionInterface::class, $destinations);

        $destinations->each(function($destination) {
            $this->assertInstanceOf(LocationInterface::class, $destination);
        });
    }

    /** @test */
    function jne_can_deliver()
    {
        $jne = new Jne();

        $origin = new Location('BANDUNG', 'QkRPMTAwMDA=');

        $destination = new Location('DEPOK', 'RFBLMTAwMDA=');

        $weight = Weight::fromKilograms(10);

        $packet = new Packet($origin, $destination, $weight);

        $this->assertInstanceOf(DeliveryCollectionInterface::class, $jne->deliver($packet));
    }
}
