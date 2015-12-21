<?php

namespace Jne\Mappers\HtmlMappers;

use Jne\DeliveryOption;
use Jne\Contracts\HtmlMapper;
use Symfony\Component\DomCrawler\Crawler;

class DeliveryOptionHtmlMapper implements HtmlMapper {
    /**
     * Map HTML DOM data to instance of object.
     *
     * @param  Symfony\Component\DomCrawler\Crawler $node
     * @return mixed
     */
    public function map(Crawler $node)
    {
        $table = $node->filter('table')->eq(1);

        return $table->filter('tbody > tr')->each(function(Crawler $row) {
            $cols = $row->children();

            return new DeliveryOption(
                $cols->eq(0)->text(),
                $cols->eq(1)->text(),
                $this->parseFloat($cols->eq(2)->text()),
                $cols->eq(3)->text()
            );
        });
    }

    /**
     * Parse to float.
     *
     * @param  string $number
     * @return float
     */
    protected function parseFloat($number)
    {
        return (float) preg_replace("/[^0-9]/", '', $number);
    }
}
