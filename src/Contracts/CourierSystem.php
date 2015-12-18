<?php

namespace Jne\Contracts;

use Jne\Contracts\Foundation\Shipment;

interface CourierSystem {
    /**
     * Search for available origin location.
     *
     * @param  string $query
     * @return Jne\Contracts\Collections\LocationCollection
     */
    public function searchOrigin($query);

    /**
     * Search for available destination location.
     *
     * @param  string $query
     * @return Jne\Contracts\Collections\LocationCollection
     */
    public function searchDestination($query);

    /**
     * Get shipment's tariff.
     *
     * @param Jne\Contracts\Foundation\Shipment $shipment
     * @return Jne\Contracts\Collections\TariffCollection
     */
    public function tariff(Shipment $shipment);
}
