<?php

namespace Jne\Contracts;

use Jne\Contracts\Foundation\PackageInterface;

interface CourierSystemInterface
{
    /**
     * Search for available origin location.
     *
     * @param string $query
     *
     * @return \Jne\Contracts\Collections\LocationCollectionInterface
     */
    public function searchOrigin($query);

    /**
     * Search for available destination location.
     *
     * @param string $query
     *
     * @return \Jne\Contracts\Collections\LocationCollectionInterface
     */
    public function searchDestination($query);

    /**
     * Get delivery options.
     *
     * @param \Jne\Contracts\Foundation\PackageInterface $package
     *
     * @return \Jne\Contracts\Collections\DeliveryOptionCollectionInterface
     */
    public function deliveryOptions(PackageInterface $package);
}
