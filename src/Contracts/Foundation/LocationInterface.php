<?php

namespace Jne\Contracts\Foundation;

interface LocationInterface
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
