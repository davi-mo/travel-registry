<?php

namespace Tests\Unit\Services;

use App\Models\City;
use App\Models\Country;
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
}
