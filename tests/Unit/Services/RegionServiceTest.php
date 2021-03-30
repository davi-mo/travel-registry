<?php

namespace Tests\Unit\Services;

use App\Exceptions\NotFoundException;
use App\Services\RegionService;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegionServiceTest extends TestCase
{
    public function testGetRegion()
    {
        $regionService = new RegionService();
        $region = $regionService->getRegion("Europe");
        $this->assertNotNull($region);
        $this->assertEquals( "Europe", $region->name);
    }

    public function testGetRegionNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $regionService = new RegionService();
        $regionService->getRegion("Invalid Region");
    }
}
