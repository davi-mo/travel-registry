<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Region;

class RegionService
{
    /**
     * @param string $regionName
     * @return Region
     * @throws NotFoundException
     */
    public function getRegion(string $regionName) : Region
    {
        $region = Region::whereName($regionName)->first();
        if (!$region) {
            throw new NotFoundException("$regionName not found");
        }

        return $region;
    }
}
