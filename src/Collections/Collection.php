<?php

namespace Jne\Collections;

use Jne\Contracts\MapperInterface;
use Jne\Contracts\HtmlMapperInterface;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Collection as BaseCollection;
use Jne\Contracts\Collections\CollectionInterface;

class Collection extends BaseCollection implements CollectionInterface
{
    /**
     * Create collection instance from raw array.
     *
     * @param array                          $data
     * @param \Jne\Contracts\MapperInterface $mapper
     *
     * @return \Jne\Contracts\CollectionsInterface
     */
    public static function fromArray(array $data, MapperInterface $mapper)
    {
        return new static($mapper->map($data));
    }

    /**
     * Create collection instance from HTML node.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $node
     * @param \Jne\Contracts\HtmlMapperInterface    $htmlMapper
     *
     * @return \Jne\Contracts\CollectionsInterface
     */
    public static function fromHtml(Crawler $node, HtmlMapperInterface $htmlMapper)
    {
        return new static($htmlMapper->map($node));
    }
}
