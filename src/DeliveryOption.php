<?php

namespace Jne;

use Jne\Contracts\Foundation\DeliveryOptionInterface;

class DeliveryOption implements DeliveryOptionInterface
{
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
     * @var int|float
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
     * @param string      $service
     * @param string      $type
     * @param int|float   $tariff
     * @param string|null $estimatedDays
     */
    public function __construct($service, $type, $tariff, $estimatedDays = null)
    {
        $this->service = $service;
        $this->type = $type;
        $this->tariff = $tariff;
        $this->estimatedDays = $estimatedDays;
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
     * @return int|float
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
