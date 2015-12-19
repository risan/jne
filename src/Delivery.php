<?php

namespace Jne;

use Jne\Contracts\Foundation\Delivery as DeliveryInterface;

class Delivery implements DeliveryInterface {
    /**
     * Delivery's packet.
     *
     * @var Jne\Contracts\Foundation\Packet
     */
    protected $packet;

    /**
     * Delivery's service type.
     *
     * @var string
     */
    protected $service;

    /**
     * Delivery's type.
     *
     * @var string
     */
    protected $type;

    /**
     * Delivery's tariff.
     *
     * @var float
     */
    protected $tariff;

    /**
     * Delivery's estimated days.
     *
     * @var string|null
     */
    protected $estimatedDays;

    /**
     * Create a new instance of delivery.
     *
     * @param Jne\Contracts\Foundation\Packet $packet
     * @param string $service
     * @param string $type
     * @param string $tariff
     * @param string|null $estimatedDays
     */
    public function __construct(Packet $packet, $service, $type, $tariff, $estimatedDays = null)
    {
        $this->packet = $packet;
        $this->service = $service;
        $this->type = $type;
        $this->tariff = $tariff;
        $this->estimatedDays = $estimatedDays;
    }

    /**
     * Get delivery's packet.
     *
     * @return Jne\Contracts\Foundation\Packet
     */
    public function packet()
    {
        return $this->packet;
    }

    /**
     * Get delivery's service.
     *
     * @return string
     */
    public function service()
    {
        return $this->service;
    }

    /**
     * Get delivery's type.
     *
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Get delivery's tariff.
     *
     * @return float
     */
    public function tariff()
    {
        return $this->tariff;
    }

    /**
     * Get delivery's estimated days.
     *
     * @return string|null
     */
    public function estimatedDays()
    {
        return $this->estimatedDays;
    }
}
