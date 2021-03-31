<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;

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
            throw NotFoundException::becauseRegionWasNotFound($regionName);
        }

        return $region;
    }

    /**
     * @return Collection
     */
    public function getAllRegions() : Collection
    {
        return Region::all();
    }

    /**
     * @return Collection
     */
    public function getActiveRegions() : Collection
    {
        return Region::where('active', 1)->get();
    }
}
