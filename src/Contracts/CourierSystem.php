<?php

namespace Jne\Contracts;

use Jne\Contracts\Foundation\Packet;

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
     * Deliver packet.
     *
     * @param Jne\Contracts\Foundation\Packet $packet
     * @return Jne\Contracts\Collections\DeliveryCollection
     */
    public function deliver(Packet $packet);
}
