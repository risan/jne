<?php

namespace Jne;

use Jne\Contracts\Foundation\Weight as WeightInterface;
use Jne\Contracts\Foundation\Package as PackageInterface;
use Jne\Contracts\Foundation\Location as LocationInterface;

class Package implements PackageInterface {
    /**
     * Package's origin.
     *
     * @var Jne\Contracts\Foundation\Location
     */
    protected $origin;

    /**
     * Package's destination.
     *
     * @var Jne\Contracts\Foundation\Location
     */
    protected $destination;

    /**
     * Package's weight.
     *
     * @var Jne\Contracts\Foundation\Weight
     */
    protected $weight;

    /**
     * Create a new instance of Package.
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
     * Get package's origin.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function origin()
    {
        return $this->origin;
    }

    /**
     * Get package's destination.
     *
     * @return Jne\Contracts\Foundation\Location
     */
    public function destination()
    {
        return $this->destination;
    }

    /**
     * Get package's weight.
     *
     * @return Jne\Contracts\Foundation\Weight
     */
    public function weight()
    {
        return $this->weight;
    }
}
