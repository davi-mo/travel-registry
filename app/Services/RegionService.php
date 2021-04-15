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
     * @param string $regionId
     * @return Region|null
     */
    public function getRegionById(string $regionId) : ?Region
    {
        return Region::find($regionId);
    }

    /**
     * @param string $regionId
     */
    public function activeInactiveRegion(string $regionId)
    {
        $region = $this->getRegionById($regionId);
        $region->active = $region->active == 0 ? 1 : 0;
        $region->updated_at = now();
        $region->save();
    }
}
