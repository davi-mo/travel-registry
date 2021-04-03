<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\PopulateCities;
use App\Services\CityService;
use Tests\TestCase;

class PopulateCitiesTest extends TestCase
{
    /**
     * @covers \App\Console\Commands\PopulateCities::__construct
     */
    public function testNameAndDescription()
    {
        $cityServiceMock = \Mockery::mock(CityService::class);

        $populateCountries = new PopulateCities($cityServiceMock);
        $this->assertEquals('city:populate', $populateCountries->getName());
        $this->assertEquals('This command will populate the list of cities', $populateCountries->getDescription());
    }

    /**
     * @covers \App\Console\Commands\PopulateCities::handle
     */
    public function testGetHandle()
    {
        $cityServiceMock = \Mockery::mock(CityService::class);
        $cityServiceMock->shouldReceive('populateCities')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        $populateCountries = new PopulateCities($cityServiceMock);
        $this->assertEquals(0, $populateCountries->handle());
    }
}
