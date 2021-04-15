<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CityController;
use App\Models\Country;
use App\Services\CityService;
use App\Services\CountryService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
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
}
