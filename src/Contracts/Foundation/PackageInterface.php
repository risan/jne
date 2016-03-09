<?php

namespace Jne\Contracts\Foundation;

interface PackageInterface
{
    /**
     * Get package's origin.
     *
     * @return \Jne\Contracts\Foundation\LocationInterface
     */
    public function origin();

    /**
     * Get package's destination.
     *
     * @return \Jne\Contracts\Foundation\LocationInterface
     */
    public function destination();

    /**
     * Get package's weight.
     *
     * @return \Jne\Contracts\Foundation\WeightInterface
     */
    public function weight();
}
