<?php

namespace Jne;

use Jne\Contracts\Foundation\Location as LocationInterface;

class Location implements LocationInterface
{
    /**
     * Location's name.
     *
     * @var string
     */
    protected $name;

    /**
     * Location's code.
     *
     * @var string
     */
    protected $code;

    /**
     * Create a new instance of Location.
     *
     * @param string $name
     * @param string $code
     */
    public function __construct($name, $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Get location's name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get location's code.
     *
     * @return string
     */
    public function code()
    {
        return $this->code;
    }
}
