<?php

use Jne\Collections\LocationCollection;
use Jne\Mappers\ArrayMappers\LocationMapper;
use Jne\Contracts\Foundation\LocationInterface;

class LocationCollectionTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function location_collection_can_instantiate_from_array()
    {
        $rawLocations = [
            [
                'label' => 'BANDUNG',
                'code'  => 'QkRPMTAwMDA='
            ]
        ];

        $collection = LocationCollection::fromArray($rawLocations, new LocationMapper);

        $this->assertInstanceOf(LocationCollection::class, $collection);

        $collection->each(function($location) {
            $this->assertInstanceOf(LocationInterface::class, $location);
        });
    }
}
