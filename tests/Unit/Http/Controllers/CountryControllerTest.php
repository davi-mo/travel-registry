<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CountryController;
use App\Models\Country;
use App\Models\Region;
use App\Services\CountryService;
use App\Services\RegionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
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

    /**
     * @covers \App\Http\Controllers\CountryController::editCountryPage
     */
    public function testEditCountryPage()
    {
        $countryId = "1";
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $countryMock = \Mockery::mock(Country::class);

        $countryServiceMock->shouldReceive('getById')
            ->once()
            ->with($countryId)
            ->andReturn($countryMock);

        $countryController = \Mockery::mock(CountryController::class)->makePartial();
        $response = $countryController->editCountryPage($countryId, $countryServiceMock);
        $this->assertInstanceOf(View::class, $response);
        $this->assertContains($countryMock, $response->getData());
    }

    /**
     * @covers \App\Http\Controllers\CountryController::updateCountry
     */
    public function testUpdateCountry()
    {
        $countryId = "1";
        $regionName = "Europe";
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $requestMock = \Mockery::mock(Request::class);
        $countryMock = \Mockery::mock(Country::class);
        $regionMock = \Mockery::mock(Region::class);

        $countryServiceMock->shouldReceive('getById')
            ->once()
            ->with($countryId)
            ->andReturn($countryMock);

        $requestMock->shouldReceive('get')
            ->once()
            ->with('region')
            ->andReturn($regionName);
        $regionServiceMock->shouldReceive('getRegion')
            ->once()
            ->with($regionName)
            ->andReturn($regionMock);

        $requestMock->shouldReceive('get')
            ->once()
            ->with('name')
            ->andReturn('countryName');
        $requestMock->shouldReceive('get')
            ->once()
            ->with('code')
            ->andReturn('countryCode');
        $requestMock->shouldReceive('get')
            ->once()
            ->with('capital')
            ->andReturn('countryCapital');
        $countryServiceMock->shouldReceive('updateCountry')
            ->once()
            ->with($countryMock, $regionMock, 'countryName', 'countryCode', 'countryCapital')
            ->andReturnNull();

        $countryController = \Mockery::mock(CountryController::class)->makePartial();
        $response = $countryController->updateCountry(
            $countryId,
            $requestMock,
            $countryServiceMock,
            $regionServiceMock
        );

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}