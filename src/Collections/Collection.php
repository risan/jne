<?php

namespace Jne\Collections;

use Jne\Contracts\Mapper;
use Illuminate\Support\Collection as BaseCollection;
use Jne\Contracts\Collections\Collection as CollectionInterface;

class Collection extends BaseCollection implements CollectionInterface {
    /**
     * Create collection instance from raw array.
     *
     * @param  array  $data
     * @param  Jne\Contracts\Mapper $mapper
     * @return Jne\Contracts\Collections
     */
    static public function fromRaw(array $data, Mapper $mapper)
    {
        return new static($mapper->map($data));
    }
}
