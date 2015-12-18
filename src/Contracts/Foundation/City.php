<?php

namespace Jne\Contracts\Foundation;

interface City {
    /**
     * Get city's name.
     *
     * @return string
     */
    public function name();

    /**
     * Get city's code.
     *
     * @return string
     */
    public function code();
}
