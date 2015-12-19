<?php

namespace Jne;

use Jne\Contracts\Foundation\Weight as WeightInterface;
use Jne\Contracts\Foundation\Location as LocationInterface;
use Jne\Contracts\Foundation\Shipment as ShipmentInterface;

class Shipment implements ShipmentInterface {
    /**
     * Shipment's origin.
     *
     * @var Jne\Contracts\Foundation\Location
     */
    protected $origin;

    /**
     * Shipment's destination.
     *
     * @var Jne\Contracts\Foundation\Location
     */
    protected $destination;

    /**
     * Shipment's weight.
     *
     * @var Jne\Contracts\Foundation\Weight
     */
    protected $weight;

    /**
     * Create a new instance of Shipment.
     *
     * @param Jne\Contracts\Foundation\Location $origin
     * @param Jne\Contracts\Foundation\Location $destination
     * @param Jne\Contracts\Foundation\Weight   $weight
     */
    public function __construct(LocationInterface $origin, LocationInterface $destination, WeightInterface $weight)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->weight = $weight;
    }

    /**
     * Get shipment's origin.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function origin()
    {
        return $this->origin;
    }

    /**
     * Get shipment's destination.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function destination()
    {
        return $this->destination;
    }

    /**
     * Get shipment's weight.
     *
     * @return Jne\Contracts\Foundation\Weight
     */
    public function weight()
    {
        return $this->weight;
    }
}
