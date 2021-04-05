<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CountryController;
use App\Services\CountryService;
use App\Services\RegionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\CountryController::getCountriesByRegion
     */
    public function testGetCountriesByRegion()
    {
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $requestMock = \Mockery::mock(Request::class);
        $regionsMock = \Mockery::mock(Collection::class);
        $countriesMock = \Mockery::mock(Collection::class);

        $requestMock->shouldReceive('get')
            ->once()
            ->with('region')
            ->andReturn(4);
        $regionServiceMock->shouldReceive('getActiveRegions')
            ->once()
            ->withNoArgs()
            ->andReturn($regionsMock);
        $countryServiceMock->shouldReceive('getByRegion')
            ->once()
            ->with(4)
            ->andReturn($countriesMock);

        $countryController = new CountryController();
        $result = $countryController->getCountriesByRegion($requestMock, $countryServiceMock, $regionServiceMock);
        $this->assertEquals("countries", $result->name());
        $this->assertEquals(4, $result->getData()['selectedRegionId']);
        $this->assertEquals($regionsMock, $result->getData()['regions']);
        $this->assertEquals($countriesMock, $result->getData()['countries']);
    }
}
