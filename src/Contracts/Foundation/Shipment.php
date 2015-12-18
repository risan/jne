<?php

namespace Jne\Contracts\Foundation;

interface Shipment {
    /**
     * Get shipment's origin.
     *
     * @return Jne\Contracts\Foundation\City
     */
    public function from();

    /**
     * Get shipment's destination.
     *
     * @return Jne\Contracts\Foundation\City
     */
    public function to();

    /**
     * Get shipment's weight.
     *
     * @return float
     */
    public function weight();
}
