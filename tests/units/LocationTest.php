<?php

use Jne\Location;

class LocationTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function location_has_name()
    {
        $location = new Location('Bandung', 'BDO10000');

        $this->assertEquals('Bandung', $location->name());
    }

    /** @test */
    function location_has_code()
    {
        $location = new Location('Bandung', 'BDO10000');

        $this->assertEquals('BDO10000', $location->code());
    }
}
