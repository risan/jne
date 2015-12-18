<?php

use Jne\Collections\Collection;
use Jne\Contracts\Mapper as MapperInterface;

class CollectionTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function collection_can_instantiate_from_raw()
    {
        $fooRaw = [1, 2, 3];

        $collection = Collection::fromRaw($fooRaw, new FooMapper);

        $this->assertInstanceOf(Collection::class, $collection);

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
