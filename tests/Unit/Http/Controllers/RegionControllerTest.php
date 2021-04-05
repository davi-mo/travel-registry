<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\RegionController;
use App\Services\RegionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegionControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\RegionController::getAllRegions
     */
    public function testGetAllRegions()
    {
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $collectionMock = \Mockery::mock(Collection::class);

        $regionServiceMock->shouldReceive('getAllRegions')
            ->once()
            ->withNoArgs()
            ->andReturn($collectionMock);

        $regionController = new RegionController();
        $result = $regionController->getAllRegions($regionServiceMock);
        $this->assertEquals("regions", $result->name());
        $this->assertContains($collectionMock, $result->getData());
    }

    /**
     * @covers \App\Http\Controllers\RegionController::getActiveRegions
     */
    public function testGetActiveRegions()
    {
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $collectionMock = \Mockery::mock(Collection::class);

        $regionServiceMock->shouldReceive('getActiveRegions')
            ->once()
            ->withNoArgs()
            ->andReturn($collectionMock);

        $regionController = new RegionController();
        $result = $regionController->getActiveRegions($regionServiceMock);
        $this->assertEquals("countries", $result->name());
        $this->assertContains($collectionMock, $result->getData());
        $this->assertEquals(0, $result->getData()['selectedRegionId']);
        $this->assertEquals($collectionMock, $result->getData()['regions']);
    }

    /**
     * @covers \App\Http\Controllers\RegionController::updateRegion
     */
    public function testUpdateRegion()
    {
        $regionId = "1";
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $regionServiceMock->shouldReceive('activeInactiveRegion')
            ->once()
            ->with($regionId)
            ->andReturnNull();

        $regionController = new RegionController();
        $response = $regionController->updateRegion($regionId, $regionServiceMock);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }
}
