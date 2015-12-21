<?php

use Jne\Weight;
use Jne\Package;
use Jne\Location;

class PackageTest extends PHPUnit_Framework_TestCase {
    protected $origin;

    protected $destination;

    protected $weight;

    protected $package;

    function setUp()
    {
        $this->origin = new Location('BANDUNG', 'QkRPMTAwMDA=');

        $this->destination = new Location('DEPOK', 'RFBLMTAwMDA=');

        $this->weight = Weight::fromKilograms(10);

        $this->package = new Package($this->origin, $this->destination, $this->weight);
    }

    /** @test */
    function package_has_origin()
    {
        $this->assertEquals($this->origin, $this->package->origin());
    }

    /** @test */
    function package_has_destination()
    {
        $this->assertEquals($this->destination, $this->package->destination());
    }

    /** @test */
    function package_has_weight()
    {
        $this->assertEquals($this->weight, $this->package->weight());
    }
}
