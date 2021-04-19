<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CountryService
{
    protected const DIFFERENT_COUNTRY_NAMES = [
        "Åland Islands" => "Aland Islands",
        "Macedonia (the former Yugoslav Republic of)" => "Macedonia",
        "Moldova (Republic of)" => "Moldova",
        "Republic of Kosovo" => "Kosovo",
        "Russian Federation" => "Russia",
        "United Kingdom of Great Britain and Northern Ireland" => "United Kingdom"
    ];

    /**
     * @param array $data
     */
    public function populateCountries(array $data) : void
    {
        foreach ($data as $countries) {
            $countryName = isset($this::DIFFERENT_COUNTRY_NAMES[$countries['name']]) ?? $countries['name'];
            $this->saveCountry(
                $countryName,
                $countries['alpha2Code'],
                $countries['capital'],
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
        $country = Country::whereName($name)->first();
        if (!$country) {
            $country = new Country();
            $region = Region::whereName($regionName)->first();
            $this->updateCountry($country, $region, $name, $code, $capital);
        }
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
        return Country::where('region_id', $regionId);
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
}
