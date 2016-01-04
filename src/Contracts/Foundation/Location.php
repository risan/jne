<?php

namespace Jne\Contracts\Foundation;

interface Location
{
    /**
     * Get location's name.
     *
     * @return string
     */
    public function name();

    /**
     * Get location's code.
     *
     * @return string
     */
    public function code();
}
