<?php

namespace Jne;

use Jne\Contracts\Foundation\WeightInterface;
use Jne\Contracts\Foundation\PackageInterface;
use Jne\Contracts\Foundation\LocationInterface;

class Package implements PackageInterface
{
    /**
     * Package's origin.
     *
     * @var \Jne\Contracts\Foundation\LocationInterface
     */
    protected $origin;

    /**
     * Package's destination.
     *
     * @var \Jne\Contracts\Foundation\LocationInterface
     */
    protected $destination;

    /**
     * Package's weight.
     *
     * @var \Jne\Contracts\Foundation\WeightInterface
     */
    protected $weight;

    /**
     * Create a new instance of Package.
     *
     * @param \Jne\Contracts\Foundation\LocationInterface $origin
     * @param \Jne\Contracts\Foundation\LocationInterface $destination
     * @param \Jne\Contracts\Foundation\WeightInterface   $weight
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
     * @return \Jne\Contracts\Foundation\LocationInterface
     */
    public function origin()
    {
        return $this->origin;
    }

    /**
     * Get package's destination.
     *
     * @return \Jne\Contracts\Foundation\LocationInterface
     */
    public function destination()
    {
        return $this->destination;
    }

    /**
     * Get package's weight.
     *
     * @return \Jne\Contracts\Foundation\WeightInterface
     */
    public function weight()
    {
        return $this->weight;
    }
}
