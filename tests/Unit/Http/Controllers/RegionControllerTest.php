<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\RegionController;
use App\Services\RegionService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class RegionControllerTest extends TestCase
{
    public function testGetAllRegions()
    {
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $collectionMock = \Mockery::mock(Collection::class);

        $regionServiceMock->shouldReceive('getAllRegions')
            ->once()
            ->withNoArgs()
            ->andReturn($collectionMock);

        $regionController = new RegionController();
        $regionController->getAllRegions($regionServiceMock);
    }
}
