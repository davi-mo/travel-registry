<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CityController;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Services\CityService;
use App\Services\CountryService;
use App\Services\RegionService;
use App\Services\VisitedCitiesService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\CityController::getCitiesByCountry
     */
    public function testGetCitiesByCountry()
    {
        $requestMock = \Mockery::mock(Request::class);
        $cityServiceMock = \Mockery::mock(CityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $builderMock = \Mockery::mock(Builder::class);
        $countryMock = \Mockery::mock(Country::class);
        $paginatorMock = \Mockery::mock(Paginator::class);
        $countryId = "1";

        $requestMock->shouldReceive('get')
            ->once()
            ->with('name')
            ->andReturn("");
        $cityServiceMock->shouldReceive('getByCountry')
            ->once()
            ->with($countryId)
            ->andReturn($builderMock);
        $builderMock->shouldReceive('paginate')
            ->once()
            ->with(50)
            ->andReturn($paginatorMock);
        $countryServiceMock->shouldReceive('getById')
            ->once()
            ->with($countryId)
            ->andReturn($countryMock);

        $cityController = new CityController();
        $result = $cityController->getCitiesByCountry($countryId, $requestMock, $cityServiceMock, $countryServiceMock);
        $this->assertEquals("cities", $result->name());
        $this->assertEquals($paginatorMock, $result->getData()['cities']);
        $this->assertEquals($countryMock, $result->getData()['country']);
    }

    /**
     * @covers \App\Http\Controllers\CityController::getCitiesByCountry
     */
    public function testFilterCitiesByName()
    {
        $requestMock = \Mockery::mock(Request::class);
        $cityServiceMock = \Mockery::mock(CityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $builderMock = \Mockery::mock(Builder::class);
        $countryMock = \Mockery::mock(Country::class);
        $paginatorMock = \Mockery::mock(Paginator::class);
        $countryId = "1";

        $requestMock->shouldReceive('get')
            ->once()
            ->with('name')
            ->andReturn("unit-test");
        $cityServiceMock->shouldReceive('filterCity')
            ->once()
            ->with($countryId, "unit-test")
            ->andReturn($builderMock);
        $builderMock->shouldReceive('paginate')
            ->once()
            ->with(50)
            ->andReturn($paginatorMock);
        $countryServiceMock->shouldReceive('getById')
            ->once()
            ->with($countryId)
            ->andReturn($countryMock);

        $cityController = new CityController();
        $result = $cityController->getCitiesByCountry($countryId, $requestMock, $cityServiceMock, $countryServiceMock);
        $this->assertEquals("cities", $result->name());
        $this->assertEquals($paginatorMock, $result->getData()['cities']);
        $this->assertEquals($countryMock, $result->getData()['country']);
    }

    /**
     * @covers \App\Http\Controllers\CityController::editCityPage
     */
    public function testEditCityPage()
    {
        $cityId = "1";
        $cityServiceMock = \Mockery::mock(CityService::class);
        $cityMock = \Mockery::mock(City::class);

        $cityServiceMock->shouldReceive('getById')
            ->once()
            ->with($cityId)
            ->andReturn($cityMock);

        $cityController = \Mockery::mock(CityController::class)->makePartial();
        $response = $cityController->editCityPage($cityId, $cityServiceMock);
        $this->assertInstanceOf(View::class, $response);
        $this->assertContains($cityMock, $response->getData());
        $this->assertEquals("edit-city", $response->getName());
    }

    /**
     * @covers \App\Http\Controllers\CityController::markVisitedCity
     */
    public function testMarkVisitedCity()
    {
        $cityId = "1";
        $cityServiceMock = \Mockery::mock(CityService::class);
        $cityMock = \Mockery::mock(City::class);

        $cityServiceMock->shouldReceive('getById')
            ->once()
            ->with($cityId)
            ->andReturn($cityMock);

        $cityController = \Mockery::mock(CityController::class)->makePartial();
        $response = $cityController->markVisitedCity($cityId, $cityServiceMock);
        $this->assertInstanceOf(View::class, $response);
        $this->assertContains($cityMock, $response->getData());
        $this->assertEquals("mark-visited-city", $response->getName());
    }

    /**
     * @covers \App\Http\Controllers\CityController::updateCity
     */
    public function testUpdateCity()
    {
        $cityServiceMock = \Mockery::mock(CityService::class);
        $requestMock = \Mockery::mock(Request::class);
        $cityMock = \Mockery::mock(City::class);
        $cityId = "1";
        $cityName = "city-name-test";
        $cityState = null;
        $countryId = "1";

        $cityServiceMock->shouldReceive('getById')
            ->once()
            ->with($cityId)
            ->andReturn($cityMock);
        $requestMock->shouldReceive('get')
            ->once()
            ->with('name')
            ->andReturn($cityName);
        $requestMock->shouldReceive('get')
            ->once()
            ->with('state')
            ->andReturn($cityState);
        $cityMock->shouldReceive('getAttribute')
            ->once()
            ->with('country_id')
            ->andReturn($countryId);
        $cityServiceMock->shouldReceive('updateCity')
            ->once()
            ->with($cityMock, $cityName, $cityState)
            ->andReturnNull();

        $cityController = \Mockery::mock(CityController::class)->makePartial();
        $response = $cityController->updateCity($cityId, $requestMock, $cityServiceMock);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    /**
     * @covers \App\Http\Controllers\CityController::nextVisitedCity
     */
    public function testNextVisitedCityWithoutRegion()
    {
        $requestMock = \Mockery::mock(Request::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $cityServiceMock = \Mockery::mock(CityService::class);
        $regionsMock = \Mockery::mock(Collection::class);

        $regionServiceMock->shouldReceive('getActiveRegions')
            ->once()
            ->withNoArgs()
            ->andReturn($regionsMock);
        $requestMock->shouldReceive('get')
            ->once()
            ->with('region')
            ->andReturnNull();

        $cityController = new CityController();
        $result = $cityController->nextVisitedCity(
            $requestMock,
            $regionServiceMock,
            $countryServiceMock,
            $visitedCityServiceMock,
            $cityServiceMock
        );

        $this->assertEquals("next-visited-city", $result->name());
        $this->assertEquals($regionsMock, $result->getData()['regions']);
        $this->assertEmpty($result->getData()['countryName']);
        $this->assertEmpty($result->getData()['cityName']);
    }

    /**
     * @covers \App\Http\Controllers\CityController::nextVisitedCity
     */
    public function testNextVisitedCityWitRegion()
    {
        $user = \Mockery::mock(User::class);
        $requestMock = \Mockery::mock(Request::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $cityServiceMock = \Mockery::mock(CityService::class);
        $regionsMock = \Mockery::mock(Collection::class);
        $countryMock = \Mockery::mock(Country::class);
        $region = "4";
        $countryId = "1";
        $countryName = "random-country-name";
        $cityName = "random-city-name";
        $visitedCityIds = [1,2,3];
        $userId = 1;

        $this->be($user);
        $regionServiceMock->shouldReceive('getActiveRegions')
            ->once()
            ->withNoArgs()
            ->andReturn($regionsMock);
        $requestMock->shouldReceive('get')
            ->once()
            ->with('region')
            ->andReturn($region);
        $countryServiceMock->shouldReceive('getRandomCountry')
            ->once()
            ->with($region)
            ->andReturn($countryMock);
        $countryMock->shouldReceive('getAttribute')
            ->once()
            ->with('name')
            ->andReturn($countryName);
        $user->shouldReceive('getAttribute')
            ->once()
            ->with('id')
            ->andReturn($userId);
        $visitedCityServiceMock->shouldReceive('getVisitedCitiesIds')
            ->once()
            ->with($userId)
            ->andReturn($visitedCityIds);
        $countryMock->shouldReceive('getAttribute')
            ->once()
            ->with('id')
            ->andReturn($countryId);
        $cityServiceMock->shouldReceive('getRandomCityName')
            ->once()
            ->with($countryId, $visitedCityIds)
            ->andReturn($cityName);

        $cityController = new CityController();
        $result = $cityController->nextVisitedCity(
            $requestMock,
            $regionServiceMock,
            $countryServiceMock,
            $visitedCityServiceMock,
            $cityServiceMock
        );

        $this->assertEquals("next-visited-city", $result->name());
        $this->assertEquals($regionsMock, $result->getData()['regions']);
        $this->assertEquals($countryName, $result->getData()['countryName']);
        $this->assertEquals($cityName, $result->getData()['cityName']);
    }
}
