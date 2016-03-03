<?php

namespace Jne\Contracts\Collections;

use Jne\Contracts\Mapper;
use Jne\Contracts\HtmlMapper;
use Symfony\Component\DomCrawler\Crawler;

interface Collection
{
    /**
     * Create collection instance from raw array.
     *
     * @param array                 $data
     * @param \Jne\Contracts\Mapper $mapper
     *
     * @return \Jne\Contracts\Collections
     */
    public static function fromArray(array $data, Mapper $mapper);

    /**
     * Create collection instance from HTML node.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $node
     * @param \Jne\Contracts\HtmlMapper             $htmlMapper
     *
     * @return \Jne\Contracts\Collections
     */
    public static function fromHtml(Crawler $node, HtmlMapper $htmlMapper);
}
