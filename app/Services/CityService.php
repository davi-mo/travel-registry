<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;

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
     * @param Country $country
     * @param array $cities
     */
    protected function saveCity(Country $country, array $cities) : void
    {
        foreach ($cities as $cityName) {
            $city = $this->getByName($cityName);
            if (!$city) {
                $city = new City();
                $city->name = $cityName;
                $city->country_id = $country->id;
                $city->save();
            }
        }
    }
}
