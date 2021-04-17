<?php

namespace App\Services;

use App\Models\City;
use App\Models\User;
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
     * @param City $city
     * @param User $user
     * @param string|null $visitedAt
     */
    public function saveVisitedCity(VisitedCities $visitedCity, City $city, User $user, ?string $visitedAt = null)
    {
        $visitedCity->city_id = $city->id;
        $visitedCity->user_id = $user->id;
        $visitedCity->visited_at = $visitedAt ? \DateTime::createFromFormat('Y-m-d', $visitedAt) : null;
        $visitedCity->save();
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
