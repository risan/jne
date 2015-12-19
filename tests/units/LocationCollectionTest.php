<?php

use Jne\Mappers\LocationMapper;
use Jne\Collections\LocationCollection;
use Jne\Contracts\Foundation\Location as LocationInterface;

class LocationCollectionTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function location_collection_can_instantiate_from_raw()
    {
        $rawLocations = [
            [
                'label' => 'BANDUNG',
                'code'  => 'QkRPMTAwMDA='
            ]
        ];

        $collection = LocationCollection::fromRaw($rawLocations, new LocationMapper);

        $this->assertInstanceOf(LocationCollection::class, $collection);

        $collection->each(function($location) {
            $this->assertInstanceOf(LocationInterface::class, $location);
        });
    }
}
