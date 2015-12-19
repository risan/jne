<?php

use Jne\Packet;
use Jne\Weight;
use Jne\Delivery;
use Jne\Location;

class DeliveryTest extends PHPUnit_Framework_TestCase {
    protected $packet;

    protected $delivery;

    function setUp()
    {
        $origin = new Location('BANDUNG', 'QkRPMTAwMDA=');

        $destination = new Location('DEPOK', 'RFBLMTAwMDA=');

        $weight = Weight::fromKilograms(10);

        $this->packet = new Packet($origin, $destination, $weight);

        $this->delivery = new Delivery($this->packet, 'OKE', 'Dokumen / Paket', 10000, '2-3 Days');
    }

    /** @test */
    function delivery_has_packet()
    {
        $this->assertInstanceOf(Packet::class, $this->delivery->packet());
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
