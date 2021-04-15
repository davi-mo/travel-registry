<?php

namespace Tests\Unit\Services;

use App\Exceptions\NotFoundException;
use App\Models\Region;
use App\Services\RegionService;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegionServiceTest extends TestCase
{
    /**
     * @covers \App\Services\RegionService::getRegion
     */
    public function testGetRegion()
    {
        $regionService = new RegionService();
        $region = $regionService->getRegion("Europe");
        $this->assertNotNull($region);
        $this->assertEquals( "Europe", $region->name);
    }

    /**
     * @covers \App\Services\RegionService::getRegion
     */
    public function testGetRegionNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $regionService = new RegionService();
        $regionService->getRegion("Invalid Region");
    }

    /**
     * @covers \App\Services\RegionService::getAllRegions
     */
    public function testGetAllRegions()
    {
        $regionService = new RegionService();
        $regions = $regionService->getAllRegions();
        $this->assertNotEmpty($regions);
        $this->assertCount(5, $regions);
    }

    /**
     * @covers \App\Services\RegionService::activeInactiveRegion
     */
    public function testActiveInactiveRegion()
    {
        $regionMock = \Mockery::mock(Region::class);
        $regionServiceMock = \Mockery::mock(RegionService::class)->makePartial();
        $regionId = "1";

        $regionServiceMock->shouldReceive('getRegionById')
            ->once()
            ->with($regionId)
            ->andReturn($regionMock);
        $regionMock->shouldReceive('getAttribute')
            ->once()
            ->with('active')
            ->andReturn(0);
        $regionMock->shouldReceive('setAttribute')
            ->once()
            ->with('active', 1);
        $regionMock->shouldReceive('setAttribute')
            ->once();
        $regionMock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnNull();
        $regionServiceMock->activeInactiveRegion($regionId);
    }

    /**
     * @covers \App\Services\RegionService::getRegionById
     */
    public function testGetRegionById()
    {
        $regionService = new RegionService();
        $region = $regionService->getRegionById("1");
        $this->assertNotNull($region);
        $this->assertEquals(1, $region->id);
    }

    /**
     * @covers \App\Services\RegionService::getRegionById
     */
    public function testGetRegionByIdNotFound()
    {
        $regionService = new RegionService();
        $region = $regionService->getRegionById("9999");
        $this->assertNull($region);
    }
}
