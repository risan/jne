<?php

namespace Jne\Mappers;

use Jne\Location;
use Jne\Contracts\Mapper;

class LocationMapper implements Mapper {
    /**
     * Map array data to instance of object.
     *
     * @param  array $data
     * @return mixed
     */
    public function map(array $data)
    {
        return array_map(function($location) {
            return new Location($location['value'], $location['code']);
        }, $data['suggestions']);
    }
}
