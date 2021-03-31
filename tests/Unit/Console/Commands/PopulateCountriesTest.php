<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\PopulateCountries;
use App\Models\Region;
use App\Services\CountryService;
use App\Services\RegionService;
use App\Services\RestCountryService;
use Symfony\Component\Console\Input\InputInterface;
use Tests\TestCase;

class PopulateCountriesTest extends TestCase
{
    /**
     * @covers \App\Console\Commands\PopulateCountries::__construct
     */
    public function testNameAndDescription()
    {
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $restCountryServiceMock = \Mockery::mock(RestCountryService::class);

        $populateCountries = new PopulateCountries($countryServiceMock, $regionServiceMock, $restCountryServiceMock);
        $this->assertEquals('country:populate', $populateCountries->getName());
        $this->assertEquals('This will populate the list of countries', $populateCountries->getDescription());
    }

    /**
     * @covers \App\Console\Commands\PopulateCountries::handle
     */
    public function testGetHandle()
    {
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $restCountryServiceMock = \Mockery::mock(RestCountryService::class);
        $inputMock = \Mockery::mock(InputInterface::class);
        $regionName = "Europe";
        $regionMock = \Mockery::mock(Region::class);

        $inputMock->shouldReceive('getArgument')
            ->once()
            ->with('region')
            ->andReturn($regionName);

        $regionServiceMock->shouldReceive('getRegion')
            ->once()
            ->with($regionName)
            ->andReturn($regionMock);
        $regionMock->shouldReceive('getAttribute')
            ->once()
            ->with('name')
            ->andReturn($regionName);
        $restCountryServiceMock->shouldReceive('getCountries')
            ->once()
            ->with($regionName)
            ->andReturn([]);

        $countryServiceMock->shouldReceive('populateCountries')
            ->once()
            ->with([])
            ->andReturnNull();

        $populateCountries = new PopulateCountries($countryServiceMock, $regionServiceMock, $restCountryServiceMock);
        $populateCountries->setInput($inputMock);
        $this->assertEquals(0, $populateCountries->handle());
    }
}
