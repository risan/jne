<?php

namespace Jne;

use Jne\Delivery;
use Jne\Mappers\LocationMapper;
use Jne\Contracts\CourierSystem;
use Jne\Collections\DeliveryCollection;
use Jne\Collections\LocationCollection;
use Symfony\Component\DomCrawler\Crawler;
use Jne\Contracts\Foundation\Packet as PacketInterface;

class Jne implements CourierSystem {
    /**
     * JNE base URI.
     */
    const BASE_URI = 'http://www.jne.co.id/';

    /**
     * Search origin URI.
     */
    const SEARCH_ORIGIN_URI = 'server/server_city_from.php';

    /**
     * Search destination URI.
     */
    const SEARCH_DESTINATION_URI = 'server/server_city.php';

    /**
     * Deliver URI.
     */
    const DELIVER_URI = 'getDetailFare.php';

    /**
     * Http client instance.
     *
     * @var Jne\Contracts\HttpClient
     */
    protected $httpClient;

    /**
     * Get http client instance.
     *
     * @return Jne\Contracts\HttpClient
     */
    public function httpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new HttpClient(self::BASE_URI);
        }

        return $this->httpClient;
    }

    /**
     * Search for available origin location.
     *
     * @param  string $query
     * @return Jne\Contracts\Collections\LocationCollection
     */
    public function searchOrigin($query)
    {
        $uri = self::SEARCH_ORIGIN_URI . '?' . http_build_query(['term' => $query]);

        $origins = $this->httpClient()->getAndParseJson($uri);

        return LocationCollection::fromRaw($origins, new LocationMapper);
    }

    /**
     * Search for available destination location.
     *
     * @param  string $query
     * @return Jne\Contracts\Collections\LocationCollection
     */
    public function searchDestination($query)
    {
        $uri = self::SEARCH_DESTINATION_URI . '?' . http_build_query(['term' => $query]);

        $destinations = $this->httpClient()->getAndParseJson($uri);

        return LocationCollection::fromRaw($destinations, new LocationMapper);
    }

    /**
     * Deliver packet.
     *
     * @param Jne\Contracts\Foundation\Packet $packet
     * @return Jne\Contracts\Collections\DeliveryCollection
     */
    public function deliver(PacketInterface $packet)
    {
        $crawler = $this->httpClient()->postAndParseHtml(self::DELIVER_URI, $this->deliverParams($packet));

        $table = $crawler->filter('table')->eq(1);

        $deliveries = $table->filter('tbody > tr')->each(function(Crawler $row) use($packet) {
            $cols = $row->children();

            return new Delivery(
                $packet,
                $cols->eq(0)->text(),
                $cols->eq(1)->text(),
                $cols->eq(2)->text(),
                $cols->eq(3)->text()
            );
        });

        return new DeliveryCollection($deliveries);
    }

    /**
     * Get deliver parameters.
     *
     * @param  Jne\Contracts\Foundation\Packet $packet
     * @return array
     */
    protected function deliverParams(PacketInterface $packet)
    {
        return [
            'origin' => $packet->origin()->code(),
            'originlabel' => $packet->origin()->name(),
            'dest' => $packet->destination()->code(),
            'destlabel' => $packet->destination()->name(),
            'weight' => $packet->weight()->kilograms()
        ];
    }
}
