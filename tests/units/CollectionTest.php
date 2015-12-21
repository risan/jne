<?php

use Jne\Collections\Collection;
use Symfony\Component\DomCrawler\Crawler;
use Jne\Contracts\Mapper as MapperInterface;
use Jne\Contracts\HtmlMapper as HtmlMapperInterface;

class CollectionTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function collection_can_instantiate_from_array()
    {
        $fooArray = [1, 2, 3];

        $collection = Collection::fromArray($fooArray, new FooMapper);

        $this->assertInstanceOf(Collection::class, $collection);

        $collection->each(function($foo) {
            $this->assertInstanceOf(Foo::class, $foo);
        });
    }

    /** @test */
    function collection_can_instantiate_from_html()
    {
        $fooHtml = new Crawler('<ul><li>1</li><li>2</li><li>3</li></ul>');

        $collection = Collection::fromHtml($fooHtml, new FooHtmlMapper);

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

class FooHtmlMapper implements HtmlMapperInterface {
    public function map(Crawler $node) {
        return $node->filter('li')->each(function($item) {
            return new Foo((int) $item->text());
        });
    }
}
