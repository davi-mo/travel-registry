<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Region;

class CountryService
{
    /**
     * @param array $data
     */
    public function populateCountries(array $data) : void
    {
        foreach ($data as $countries) {
            $this->saveCountry(
                $countries['name'],
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
            $region = Region::whereName($regionName)->first();

            $country = new Country();
            $country->name = $name;
            $country->code = $code;
            $country->capital = $capital;
            $country->region_id = $region->id;
            $country->save();
        }
    }
}
