<?php

namespace Jne;

use Jne\Contracts\Foundation\Weight as WeightInterface;
use Jne\Contracts\Foundation\Location as LocationInterface;
use Jne\Contracts\Foundation\Packet as PacketInterface;

class Packet implements PacketInterface {
    /**
     * Packet's origin.
     *
     * @var Jne\Contracts\Foundation\Location
     */
    protected $origin;

    /**
     * Packet's destination.
     *
     * @var Jne\Contracts\Foundation\Location
     */
    protected $destination;

    /**
     * Packet's weight.
     *
     * @var Jne\Contracts\Foundation\Weight
     */
    protected $weight;

    /**
     * Create a new instance of Packet.
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
     * Get packet's origin.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function origin()
    {
        return $this->origin;
    }

    /**
     * Get packet's destination.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function destination()
    {
        return $this->destination;
    }

    /**
     * Get packet's weight.
     *
     * @return Jne\Contracts\Foundation\Weight
     */
    public function weight()
    {
        return $this->weight;
    }
}
