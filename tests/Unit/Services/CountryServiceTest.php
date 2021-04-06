<?php

namespace Tests\Unit\Services;

use App\Models\Country;
use App\Models\Region;
use App\Services\CountryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Services\CountryService::populateCountries
     */
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

    /**
     * @covers \App\Services\CountryService::saveCountry
     * @covers \App\Services\CountryService::updateCountry
     */
    public function testSaveCountry()
    {
        $countryService = new CountryService();
        $countryService->saveCountry("name", "nm", "capital", "Europe");

        $country = Country::whereName("name")->first();
        $this->assertNotNull($country);
        $this->assertNotNull($country->id);
    }

    /**
     * @covers \App\Services\CountryService::updateCountry
     */
    public function testUpdateCountry()
    {
        $region = Region::whereName("Europe")->first();
        $country = new Country();

        $countryService = new CountryService();
        $countryService->updateCountry($country, $region, "unit-test", "ut", "unit-test-capital");

        $updatedCountry = Country::whereName("unit-test")->first();
        $this->assertNotNull($updatedCountry);
        $this->assertNotNull($updatedCountry->id);
        $this->assertEquals("ut", $updatedCountry->code);
        $this->assertEquals("unit-test-capital", $updatedCountry->capital);
    }

    /**
     * @covers \App\Services\CountryService::getByName
     */
    public function testGetByNameNotFound()
    {
        $countryService = new CountryService();
        $country = $countryService->getByName("invalid-name");
        $this->assertNull($country);
    }

    /**
     * @covers \App\Services\CountryService::getByName
     */
    public function testGetByName()
    {
        $country = Country::all()->first();

        $countryService = new CountryService();
        $returnedCountry = $countryService->getByName($country->name);
        $this->assertNotNull($returnedCountry);
        $this->assertEquals($country, $returnedCountry);
    }

    /**
     * @covers \App\Services\CountryService::getByRegion
     */
    public function testGetByRegion()
    {
        $country = Country::all()->first();
        $countryService = new CountryService();
        $countries = $countryService->getByRegion($country->region_id);
        $this->assertNotNull($countries);
    }

    /**
     * @covers \App\Services\CountryService::getById
     */
    public function testGetByIdNotFound()
    {
        $countryService = new CountryService();
        $country = $countryService->getById("9999");
        $this->assertNull($country);
    }

    /**
     * @covers \App\Services\CountryService::getByName
     */
    public function testGetById()
    {
        $country = Country::all()->first();

        $countryService = new CountryService();
        $returnedCountry = $countryService->getById($country->id);
        $this->assertNotNull($returnedCountry);
        $this->assertEquals($country, $returnedCountry);
    }
}
