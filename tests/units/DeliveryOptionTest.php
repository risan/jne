<?php

use Jne\Weight;
use Jne\Location;
use Jne\DeliveryOption;

class DeliveryOptionTest extends PHPUnit_Framework_TestCase {
    protected $delivery;

    function setUp()
    {
        $this->delivery = new DeliveryOption('OKE', 'Dokumen / Paket', 10000, '2-3 Days');
    }

    /** @test */
    function delivery_has_service()
    {
        $this->assertEquals('OKE', $this->delivery->service());
    }

    /** @test */
    function delivery_has_type()
    {
        $this->assertEquals('Dokumen / Paket', $this->delivery->type());
    }

    /** @test */
    function delivery_has_tariff()
    {
        $this->assertEquals(10000, $this->delivery->tariff());
    }

    /** @test */
    function delivery_has_estimated_days()
    {
        $this->assertEquals('2-3 Days', $this->delivery->estimatedDays());
    }
}
