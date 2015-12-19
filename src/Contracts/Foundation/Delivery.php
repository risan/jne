<?php

namespace Jne\Contracts\Foundation;

interface Delivery {
    /**
     * Get delivery's packet.
     *
     * @return Jne\Contracts\Foundation\Packet
     */
    public function packet();

    /**
     * Get delivery's service.
     *
     * @return string
     */
    public function service();

    /**
     * Get delivery's type.
     *
     * @return string
     */
    public function type();

    /**
     * Get delivery's tariff.
     *
     * @return float
     */
    public function tariff();

    /**
     * Get delivery's estimated days.
     *
     * @return string|null
     */
    public function estimatedDays();
}
