<?php

namespace Tests\Unit\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Http\Middleware\VerifyExistingRegion;
use App\Models\Region;
use App\Services\RegionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Tests\TestCase;

class VerifyExistingRegionTest extends TestCase
{
    /**
     * @covers \App\Http\Middleware\VerifyExistingRegion::__construct
     * @covers \App\Http\Middleware\VerifyExistingRegion::handle
     */
    public function testVerifyRegionNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $routeMock = \Mockery::mock(Route::class);
        $regionId = "9999";

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('regionId')
            ->andReturn($regionId);
        $regionServiceMock->shouldReceive('getRegionById')
            ->once()
            ->with($regionId)
            ->andReturnNull();
        $next = function () {
        };

        $verifyExistingRegionMock = new VerifyExistingRegion($regionServiceMock);
        $verifyExistingRegionMock->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingRegion::__construct
     * @covers \App\Http\Middleware\VerifyExistingRegion::handle
     */
    public function testVerifyExistingRegionWithoutParameter()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $routeMock = \Mockery::mock(Route::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('regionId')
            ->andReturnNull();
        $next = function () {
        };

        $verifyExistingRegionMock = new VerifyExistingRegion($regionServiceMock);
        $verifyExistingRegionMock->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingRegion::__construct
     * @covers \App\Http\Middleware\VerifyExistingRegion::handle
     */
    public function testVerifyExistingRegion()
    {
        $requestMock = \Mockery::mock(Request::class);
        $regionServiceMock = \Mockery::mock(RegionService::class);
        $routeMock = \Mockery::mock(Route::class);
        $regionId = "9999";
        $region = \Mockery::mock(Region::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('regionId')
            ->andReturn($regionId);
        $regionServiceMock->shouldReceive('getRegionById')
            ->once()
            ->with($regionId)
            ->andReturn($region);
        $next = function () {
        };

        $verifyExistingRegionMock = new VerifyExistingRegion($regionServiceMock);
        $verifyExistingRegionMock->handle($requestMock, $next);
    }
}
