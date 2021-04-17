<?php

namespace Tests\Unit\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Http\Middleware\VerifyExistingCity;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Tests\TestCase;

class VerifyExistingCityTest extends TestCase
{
    /**
     * @covers \App\Http\Middleware\VerifyExistingCity::__construct
     * @covers \App\Http\Middleware\VerifyExistingCity::handle
     */
    public function testVerifyCityNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $cityServiceMock = \Mockery::mock(CityService::class);
        $routeMock = \Mockery::mock(Route::class);
        $cityId = "9999";

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('cityId')
            ->andReturn($cityId);
        $cityServiceMock->shouldReceive('getById')
            ->once()
            ->with($cityId)
            ->andReturnNull();
        $next = function () {
        };

        $verifyExistingCity = new VerifyExistingCity($cityServiceMock);
        $verifyExistingCity->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingCity::__construct
     * @covers \App\Http\Middleware\VerifyExistingCity::handle
     */
    public function testVerifyExistingCityWithoutParameter()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $cityServiceMock = \Mockery::mock(CityService::class);
        $routeMock = \Mockery::mock(Route::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('cityId')
            ->andReturnNull();
        $next = function () {
        };

        $verifyExistingCity = new VerifyExistingCity($cityServiceMock);
        $verifyExistingCity->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingCity::__construct
     * @covers \App\Http\Middleware\VerifyExistingCity::handle
     */
    public function testVerifyExistingCity()
    {
        $requestMock = \Mockery::mock(Request::class);
        $cityServiceMock = \Mockery::mock(CityService::class);
        $routeMock = \Mockery::mock(Route::class);
        $cityId = "1";
        $city = \Mockery::mock(City::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('cityId')
            ->andReturn($cityId);
        $cityServiceMock->shouldReceive('getById')
            ->once()
            ->with($cityId)
            ->andReturn($city);
        $next = function () {
        };

        $verifyExistingCity = new VerifyExistingCity($cityServiceMock);
        $verifyExistingCity->handle($requestMock, $next);
    }
}
