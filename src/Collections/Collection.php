<?php

namespace Jne\Collections;

use Jne\Contracts\Mapper;
use Jne\Contracts\HtmlMapper;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Collection as BaseCollection;
use Jne\Contracts\Collections\Collection as CollectionInterface;

class Collection extends BaseCollection implements CollectionInterface
{
    /**
     * Create collection instance from raw array.
     *
     * @param array                $data
     * @param Jne\Contracts\Mapper $mapper
     *
     * @return Jne\Contracts\Collections
     */
    public static function fromArray(array $data, Mapper $mapper)
    {
        return new static($mapper->map($data));
    }

    /**
     * Create collection instance from HTML node.
     *
     * @param Symfony\Component\DomCrawler\Crawler $node
     * @param Jne\Contracts\HtmlMapper             $htmlMapper
     *
     * @return Jne\Contracts\Collections
     */
    public static function fromHtml(Crawler $node, HtmlMapper $htmlMapper)
    {
        return new static($htmlMapper->map($node));
    }
}
