<?php

namespace Jne\Contracts\Foundation;

interface Packet {
    /**
     * Get packet's origin.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function origin();

    /**
     * Get packet's destination.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function destination();

    /**
     * Get packet's weight.
     *
     * @return Jne\Contracts\Foundation\Weight
     */
    public function weight();
}
