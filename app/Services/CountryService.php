<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CountryService
{
    /**
     * @param array $data
     */
    public function populateCountries(array $data) : void
    {
        foreach ($data as $countries) {
            $countryName = $countries['name']['common'];
            if ($countryName === "Åland Islands") {
                $countryName = "Aland Islands";
            }

            $capital = isset($countries['capital']) ? reset($countries['capital']) : "";
            $countryCode = isset($countries['cca2']) ? $countries['cca2'] : "";
            $this->saveCountry(
                $countryName,
                $countryCode,
                $capital,
                $countries['region'],
            );
        }
    }

    /**
     * @param string $name
     * @param string $code
     * @param string $capital
     * @param string $regionName
     */
    public function saveCountry(string $name, string $code, string $capital, string $regionName) : void
    {
        $region = Region::whereName($regionName)->first();
        $country = Country::whereName($name)->first();

        $this->updateCountry($country ?? app()->make(Country::class), $region, $name, $code, $capital);
    }

    /**
     * @param Country $country
     * @param Region $region
     * @param string $name
     * @param string $code
     * @param string $capital
     */
    public function updateCountry(Country $country, Region $region, string $name, string $code, string $capital)
    {
        $country->name = $name;
        $country->code = $code;
        $country->capital = $capital;
        $country->region_id = $region->id;
        $country->save();
    }

    /**
     * @param string $name
     * @return Country|null
     */
    public function getByName(string $name) : ?Country
    {
        return Country::whereName($name)->first();
    }

    /**
     * @param string $regionId
     * @return Builder
     */
    public function getByRegion(string $regionId) : Builder
    {
        return Country::where('region_id', $regionId)->orderBy("name");
    }

    /**
     * @param string $countryId
     * @return Country|null
     */
    public function getById(string $countryId) : ?Country
    {
        return Country::find($countryId);
    }

    /**
     * @param string $regionId
     * @param string $term
     * @return Builder
     */
    public function filterCountry(string $regionId, string $term) : Builder
    {
        return Country::where('region_id', $regionId)->where(function ($query) use ($term) {
            $query->where('name', 'LIKE', "%$term%");
            $query->orWhere('code', 'LIKE', "%$term%");
        });
    }

    /**
     * @param string $regionId
     * @return Country
     */
    public function getRandomCountry(string $regionId) : Country
    {
        $countryName = $this->getRandomCountryWithCities($regionId);
        return $this->getByName($countryName);
    }

    /**
     * @param string $regionId
     * @return string|null
     */
    protected function getRandomCountryWithCities(string $regionId) : ?string
    {
        $randomCountry = DB::table('cities')
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->select('countries.name AS name')
            ->where('countries.region_id', '=', $regionId)
            ->distinct()
            ->inRandomOrder()
            ->get()
            ->first();

        return $randomCountry?->name;
    }
}
