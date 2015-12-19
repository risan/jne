<?php

namespace Jne;

use Jne\Mappers\LocationMapper;
use Jne\Contracts\CourierSystem;
use Jne\Collections\TariffCollection;
use Jne\Contracts\Foundation\Shipment;
use Jne\Collections\LocationCollection;

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
     * Get shipment's tariff.
     *
     * @param Jne\Contracts\Foundation\Shipment $shipment
     * @return Jne\Contracts\Collections\TariffCollection
     */
    public function tariff(Shipment $shipment)
    {
        return new TariffCollection();
    }
}
