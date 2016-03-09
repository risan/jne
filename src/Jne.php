<?php

namespace Jne;

use Jne\Contracts\CourierSystemInterface;
use Jne\Collections\LocationCollection;
use Jne\Mappers\ArrayMappers\LocationMapper;
use Jne\Collections\DeliveryOptionCollection;
use Jne\Mappers\HtmlMappers\DeliveryOptionHtmlMapper;
use Jne\Contracts\Foundation\PackageInterface;

class Jne implements CourierSystemInterface
{
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
     * @var \Jne\Contracts\HttpClient
     */
    protected $httpClient;

    /**
     * Get http client instance.
     *
     * @return \Jne\Contracts\HttpClientInterface
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
     * @param string $query
     *
     * @return \Jne\Contracts\Collections\LocationCollectionInterface
     */
    public function searchOrigin($query)
    {
        return $this->searchLocation(self::SEARCH_ORIGIN_URI, $query);
    }

    /**
     * Search for available destination location.
     *
     * @param string $query
     *
     * @return \Jne\Contracts\Collections\LocationCollectionInterface
     */
    public function searchDestination($query)
    {
        return $this->searchLocation(self::SEARCH_DESTINATION_URI, $query);
    }

    /**
     * Search for available location.
     *
     * @param string $uri
     * @param string $query
     *
     * @return \Jne\Contracts\Collections\LocationCollectionInterface
     */
    protected function searchLocation($uri, $query)
    {
        $uri .= '?'.http_build_query(['term' => $query]);

        $locations = $this->httpClient()->getAndParseJson($uri);

        return LocationCollection::fromArray($locations, new LocationMapper());
    }

    /**
     * Get delivery options.
     *
     * @param \Jne\Contracts\Foundation\PackageInterface $package
     *
     * @return \Jne\Contracts\Collections\DeliveryOptionCollectionInterface
     */
    public function deliveryOptions(PackageInterface $package)
    {
        $deliveryOptions = $this->httpClient()->postAndParseHtml(self::DELIVER_URI, $this->deliveryOptionsParams($package));

        return DeliveryOptionCollection::fromHtml($deliveryOptions, new DeliveryOptionHtmlMapper());
    }

    /**
     * Get delivery options parameters.
     *
     * @param \Jne\Contracts\Foundation\PackageInterface $package
     *
     * @return array
     */
    protected function deliveryOptionsParams(PackageInterface $package)
    {
        return [
            'origin' => $package->origin()->code(),
            'originlabel' => $package->origin()->name(),
            'dest' => $package->destination()->code(),
            'destlabel' => $package->destination()->name(),
            'weight' => $package->weight()->kilograms(),
        ];
    }
}
