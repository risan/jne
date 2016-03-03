<?php

namespace Jne\Contracts;

use Jne\Contracts\Foundation\Package;

interface CourierSystem
{
    /**
     * Search for available origin location.
     *
     * @param string $query
     *
     * @return \Jne\Contracts\Collections\LocationCollection
     */
    public function searchOrigin($query);

    /**
     * Search for available destination location.
     *
     * @param string $query
     *
     * @return \Jne\Contracts\Collections\LocationCollection
     */
    public function searchDestination($query);

    /**
     * Get delivery options.
     *
     * @param \Jne\Contracts\Foundation\Package $package
     *
     * @return \Jne\Contracts\Collections\DeliveryOptionCollection
     */
    public function deliveryOptions(Package $package);
}
