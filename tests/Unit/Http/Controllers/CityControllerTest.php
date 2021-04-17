<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CityController;
use App\Models\City;
use App\Models\Country;
use App\Services\CityService;
use App\Services\CountryService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
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
        $cityServiceMock = \Mockery::mock(CityService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $builderMock = \Mockery::mock(Builder::class);
        $countryMock = \Mockery::mock(Country::class);
        $paginatorMock = \Mockery::mock(Paginator::class);
        $countryId = "1";

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
        $result = $cityController->getCitiesByCountry($countryId, $cityServiceMock, $countryServiceMock);
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
}
