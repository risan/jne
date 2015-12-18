<?php

use Jne\Collections\LocationCollection;
use Jne\Contracts\Mapper as MapperInterface;

class LocationCollectionTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function location_collection_can_instantiate_from_raw()
    {
        $fooRaw = [1, 2, 3];

        $collection = LocationCollection::fromRaw($fooRaw, new FooMapper);

        $this->assertInstanceOf(LocationCollection::class, $collection);

        $collection->each(function($foo) {
            $this->assertInstanceOf(Foo::class, $foo);
        });
    }
}

class Foo {
    public $bar;

    public function __construct($bar)
    {
        $this->bar = $bar;
    }
}

class FooMapper implements MapperInterface {
    public function map(array $data) {
        return array_map(function($foo) {
            return new Foo($foo);
        }, $data);
    }
}
