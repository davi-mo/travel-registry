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

    /**
     * @param int $visitedCityId
     * @return VisitedCities|null
     */
    public function getById(int $visitedCityId) : ?VisitedCities
    {
        return VisitedCities::find($visitedCityId);
    }

    /**
     * @param VisitedCities $visitedCity
     * @param string|null $visitedAt
     */
    public function updateVisitedCity(VisitedCities $visitedCity, ?string $visitedAt)
    {
        $visitedCity->visited_at = $visitedAt ? \DateTime::createFromFormat('Y-m-d', $visitedAt) : null;
        $visitedCity->save();
    }

    /**
     * @param VisitedCities $visitedCity
     * @throws \Exception
     */
    public function deleteVisitedCity(VisitedCities $visitedCity)
    {
        $visitedCity->delete();
    }
}
