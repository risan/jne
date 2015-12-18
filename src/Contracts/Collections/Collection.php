<?php

namespace Jne\Contracts\Collections;

use Jne\Contracts\Mapper;

interface Collection {
    /**
     * Create collection instance from raw array.
     *
     * @param  array  $data
     * @param  Jne\Contracts\Mapper $mapper
     * @return Jne\Contracts\Collections
     */
    static public function fromRaw(array $data, Mapper $mapper);
}
