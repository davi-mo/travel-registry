<?php

namespace App\Services;

use App\Models\VisitedCities;
use Illuminate\Database\Eloquent\Collection;

class VisitedCitiesService
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function getByUser(int $userId) : Collection
    {
        return VisitedCities::where('user_id', $userId)->get();
    }
}
