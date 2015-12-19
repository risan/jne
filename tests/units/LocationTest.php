<?php

use Jne\Location;

class LocationTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function location_has_name()
    {
        $location = new Location('BANDUNG', 'QkRPMTAwMDA=');

        $this->assertEquals('BANDUNG', $location->name());
    }

    /** @test */
    function location_has_code()
    {
        $location = new Location('BANDUNG', 'QkRPMTAwMDA=');

        $this->assertEquals('QkRPMTAwMDA=', $location->code());
    }
}
