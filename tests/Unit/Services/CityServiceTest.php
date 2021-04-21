<?php

namespace Tests\Unit\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\VisitedCities;
use App\Services\CityService;
use App\Services\CountryService;
use App\Services\RestCityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Services\CityService::__construct
     * @covers \App\Services\CityService::getByName
     */
    public function testGetByNameNotFound()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $this->assertNull($cityService->getByName("unit-test"));
    }

    /**
     * @covers \App\Services\CityService::__construct
     * @covers \App\Services\CityService::getByName
     */
    public function testGetByName()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $city = City::all()->first();

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $returnedCity = $cityService->getByName($city->name);
        $this->assertNotNull($returnedCity);
        $this->assertEquals($city, $returnedCity);
    }

    /**
     * @covers \App\Services\CityService::populateCities
     */
    public function testPopulateCity()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $cityServiceMock = \Mockery::mock(CityService::class, [
            $restCityServiceMock,
            $countryServiceMock
        ])->shouldAllowMockingProtectedMethods()->makePartial();
        $countryMock = \Mockery::mock(Country::class);

        $responseData = [
            "error" => false,
            "msg" => "unit-test message",
            "data" => [
                [
                    "country" => "Albania",
                    "cities" => [
                        "Elbasan",
                        "Petran",
                    ]
                ]
            ]
        ];

        $restCityServiceMock->shouldReceive('getCities')
            ->once()
            ->withNoArgs()
            ->andReturn($responseData);
        $countryServiceMock->shouldReceive('getByName')
            ->once()
            ->with("Albania")
            ->andReturn($countryMock);
        $cityServiceMock->shouldReceive('saveCity')
            ->once()
            ->with($countryMock, ["Elbasan", "Petran"])
            ->andReturnNull();

        $cityServiceMock->populateCities();
    }

    /**
     * @covers \App\Services\CityService::saveCity
     */
    public function testSaveCity()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $cityServiceMock = \Mockery::mock(CityService::class, [
            $restCityServiceMock,
            $countryServiceMock
        ])->shouldAllowMockingProtectedMethods()->makePartial();
        $countryMock = \Mockery::mock(Country::class);
        $cities = ['unit-test-city', 'another-city'];

        $cityServiceMock->shouldReceive('getByName')
            ->once()
            ->with($cities[0])
            ->andReturnNull();
        $countryMock->shouldReceive('getAttribute')
            ->twice()
            ->with('id')
            ->andReturn(1);

        $cityServiceMock->saveCity($countryMock, $cities);
    }

    /**
     * @covers \App\Services\CityService::getByCountry
     */
    public function testGetByCountry()
    {
        $city = City::inRandomOrder()->first();
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $cities = $cityService->getByCountry((string) $city->country_id)->get();
        $this->assertNotNull($cities);
    }

    /**
     * @covers \App\Services\CityService::getById
     */
    public function testGetById()
    {
        $city = City::inRandomOrder()->first();
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $returnedCity = $cityService->getById((string) $city->id);
        $this->assertNotNull($returnedCity);
        $this->assertEquals($city, $returnedCity);
    }

    /**
     * @covers \App\Services\CityService::getById
     */
    public function testGetByIdNotFound()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $returnedCity = $cityService->getById("9999");
        $this->assertNull($returnedCity);
    }

    /**
     * @covers \App\Services\CityService::updateCity
     */
    public function testUpdateCity()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $cityMock = \Mockery::mock(City::class);
        $cityName = "unit-test-name";

        $cityMock->shouldReceive('setAttribute')
            ->once()
            ->with("name", $cityName)
            ->andReturnNull();
        $cityMock->shouldReceive('setAttribute')
            ->once()
            ->with("state", null)
            ->andReturnNull();
        $cityMock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $cityService->updateCity($cityMock, $cityName);
    }

    /**
     * @covers \App\Services\CityService::filterCity
     */
    public function testFilterCityByName()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $city = City::inRandomOrder()->first();

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $returnedCities = $cityService->filterCity($city->country_id, $city->name)->get();
        $this->assertNotNull($returnedCities);
    }

    /**
     * @covers \App\Services\CityService::getRandomCityName
     */
    public function testGetRandomCityName()
    {
        $restCityServiceMock = \Mockery::mock(RestCityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $city = City::inRandomOrder()->first();
        $visitedCity = VisitedCities::inRandomOrder()->first();

        $cityService = new CityService($restCityServiceMock, $countryServiceMock);
        $cityName = $cityService->getRandomCityName($city->country_id, [$visitedCity->id]);
        $this->assertNotNull($cityName);
    }
}
