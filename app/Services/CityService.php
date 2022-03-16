<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CityService
{
    /** @var RestCityService */
    private $restCityService;

    /** @var CountryService */
    private $countryService;

    /**
     * CityService constructor.
     * @param RestCityService $restCityService
     * @param CountryService $countryService
     */
    public function __construct(RestCityService $restCityService, CountryService $countryService)
    {
        $this->restCityService = $restCityService;
        $this->countryService = $countryService;
    }

    public function populateCities() : void
    {
        $responseData = $this->restCityService->getCities();
        foreach ($responseData['data'] as $data) {
            $country = $this->countryService->getByName($data['country']);
            if ($country) {
                $this->saveCity($country, $data['cities']);
            }
        }
    }

    /**
     * @param string $name
     * @return City|null
     */
    public function getByName(string $name) : ?City
    {
        return City::whereName($name)->first();
    }

    /**
     * @param string $countryId
     * @return Builder
     */
    public function getByCountry(string $countryId) : Builder
    {
        return City::where("country_id", $countryId);
    }

    /**
     * @param string $cityId
     * @return City|null
     */
    public function getById(string $cityId) : ?City
    {
        return City::find($cityId);
    }

    /**
     * @param City $city
     * @param string $cityName
     * @param string|null $cityState
     */
    public function updateCity(City $city, string $cityName, ?string $cityState = null)
    {
        $city->name = $cityName;
        $city->state = $cityState;
        $city->save();
    }

    /**
     * @param string $countryId
     * @param string $name
     * @return Builder
     */
    public function filterCity(string $countryId, string $name) : Builder
    {
        return City::where([
            ["country_id", $countryId],
            ["name", "LIKE", "%$name%"]
        ]);
    }

    /**
     * @param string $countryId
     * @param array $visitedCitiesIds
     * @return string|null
     */
    public function getRandomCityName(string $countryId, array $visitedCitiesIds) : ?string
    {
        $randomCity = DB::table('cities')
            ->select('name')
            ->where('country_id', '=', $countryId)
            ->whereNotIn('id', $visitedCitiesIds)
            ->inRandomOrder()
            ->get()
            ->first();

        return $randomCity?->name;
    }

    /**
     * @param Country $country
     * @param array $cities
     */
    protected function saveCity(Country $country, array $cities) : void
    {
        foreach ($cities as $cityName) {
            $city = $this->getByName($cityName);
            if (!$city) {
                $city = app()->make(City::class);
                $city->name = $cityName;
                $city->country_id = $country->id;
                $city->save();
            }
        }
    }
}
