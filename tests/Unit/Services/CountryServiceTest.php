<?php

namespace Tests\Unit\Services;

use App\Models\Country;
use App\Services\CountryService;
use Tests\TestCase;

class CountryServiceTest extends TestCase
{
    public function testPopulateCountries()
    {
        $data = [
            [
                'name' => 'country-name',
                'alpha2Code' => 'cn',
                'capital' => 'capital',
                'region' => 'Europe',
            ]
        ];

        $countryService = new CountryService();
        $countryService->populateCountries($data);
        $this->assertTrue(true);
    }

    public function testSaveCountry()
    {
        $countryService = new CountryService();
        $countryService->saveCountry("name", "nm", "capital", "Europe");

        $country = Country::whereName("name")->first();
        $this->assertNotNull($country);
        $this->assertNotNull($country->id);
    }
}
