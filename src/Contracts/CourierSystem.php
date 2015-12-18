<?php

namespace Jne\Contracts;

use Jne\Contracts\Foundation\Shipment;

interface CourierSystem {
    /**
     * Search for city.
     *
     * @param  string $query
     * @return Jne\Contracts\Collections\CityCollection
     */
    public function searchCity($query);

    /**
     * Get shipment's tariff.
     *
     * @param Jne\Contracts\Foundation\Shipment $shipment
     * @return Jne\Contracts\Collections\TariffCollection
     */
    public function tariff(Shipment $shipment);
}
