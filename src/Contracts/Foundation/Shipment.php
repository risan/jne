<?php

namespace Jne\Contracts\Foundation;

interface Shipment {
    /**
     * Get shipment's origin.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function origin();

    /**
     * Get shipment's destination.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function destination();

    /**
     * Get shipment's weight.
     *
     * @return Jne\Contracts\Foundation\Weight
     */
    public function weight();
}
