<?php

use Jne\Packet;
use Jne\Weight;
use Jne\Location;

class PacketTest extends PHPUnit_Framework_TestCase {
    protected $origin;

    protected $destination;

    protected $weight;

    protected $packet;

    function setUp()
    {
        $this->origin = new Location('BANDUNG', 'QkRPMTAwMDA=');

        $this->destination = new Location('DEPOK', 'RFBLMTAwMDA=');

        $this->weight = Weight::fromKilograms(10);

        $this->packet = new Packet($this->origin, $this->destination, $this->weight);
    }

    /** @test */
    function packet_has_origin()
    {
        $this->assertEquals($this->origin, $this->packet->origin());
    }

    /** @test */
    function packet_has_destination()
    {
        $this->assertEquals($this->destination, $this->packet->destination());
    }

    /** @test */
    function packet_has_weight()
    {
        $this->assertEquals($this->weight, $this->packet->weight());
    }
}
