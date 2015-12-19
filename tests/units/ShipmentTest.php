<?php

use Jne\Weight;
use Jne\Location;
use Jne\Shipment;

class ShipmentTest extends PHPUnit_Framework_TestCase {
    protected $origin;

    protected $destination;

    protected $weight;

    protected $shipment;

    function setUp()
    {
        $this->origin = new Location('Bandung', 'BDO10000');

        $this->destination = new Location('Depok', 'DPK10000');

        $this->weight = Weight::fromKilograms(10);

        $this->shipment = new Shipment($this->origin, $this->destination, $this->weight);
    }

    /** @test */
    function shipment_has_origin()
    {
        $this->assertEquals($this->origin, $this->shipment->origin());
    }

    /** @test */
    function shipment_has_destination()
    {
        $this->assertEquals($this->destination, $this->shipment->destination());
    }

    /** @test */
    function shipment_has_weight()
    {
        $this->assertEquals($this->weight, $this->shipment->weight());
    }
}
