<?php

namespace Jne\Contracts\Foundation;

interface Package
{
    /**
     * Get package's origin.
     *
     * @return \Jne\Contracts\Foundation\Location
     */
    public function origin();

    /**
     * Get package's destination.
     *
     * @return \Jne\Contracts\Foundation\Location
     */
    public function destination();

    /**
     * Get package's weight.
     *
     * @return \Jne\Contracts\Foundation\Weight
     */
    public function weight();
}
