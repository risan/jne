<?php

use Jne\Mappers\ArrayMappers\LocationMapper;
use Jne\Contracts\Collections\LocationCollection;
use Jne\Contracts\Foundation\Location as LocationInterface;

class LocationMapperTest extends PHPUnit_Framework_TestCase {
    protected $arrayLocations;

    function setUp()
    {
        $this->arrayLocations = [
            [
                'label' => 'BANDUNG',
                'code'  => 'QkRPMTAwMDA='
            ],
            [
                'label' => 'BANDAACEH',
                'code'  => 'QlRKMTAwMDA='
            ]
        ];
    }

    /** @test */
    function location_mapper_can_map_array_of_location()
    {
        $locationMapper = new LocationMapper();

        $locations = $locationMapper->map($this->arrayLocations);

        $this->assertCount(2, $locations);

        foreach ($locations as $location) {
            $this->assertInstanceOf(LocationInterface::class, $location);
        }

        $this->assertEquals('BANDAACEH', $locations[1]->name());
        $this->assertEquals('QlRKMTAwMDA=', $locations[1]->code());
    }
}
