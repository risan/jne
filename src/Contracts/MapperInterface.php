<?php

namespace Jne\Contracts;

interface MapperInterface
{
    /**
     * Map array data to instance of object.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function map(array $data);
}
