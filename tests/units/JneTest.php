<?php

use Jne\Jne;
use Jne\Weight;
use Jne\Package;
use Jne\Location;
use Jne\Contracts\HttpClient as HttpClientInterface;
use Jne\Contracts\Foundation\Location as LocationInterface;
use Jne\Contracts\Collections\LocationCollection as LocationCollectionInterface;
use Jne\Contracts\Collections\DeliveryOptionCollection as DeliveryOptionCollectionInterface;

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
    function jne_can_retrieve_delivery_options()
    {
        $jne = new Jne();

        $origin = new Location('BANDUNG', 'QkRPMTAwMDA=');

        $destination = new Location('DEPOK', 'RFBLMTAwMDA=');

        $weight = Weight::fromKilograms(10);

        $package = new Package($origin, $destination, $weight);

        $this->assertInstanceOf(DeliveryOptionCollectionInterface::class, $jne->deliveryOptions($package));
    }
}
