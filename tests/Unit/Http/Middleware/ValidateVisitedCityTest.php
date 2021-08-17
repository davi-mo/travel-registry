<?php

namespace Tests\Unit\Http\Middleware;

use App\Exceptions\DifferentUserVisitedCityException;
use App\Exceptions\NotFoundException;
use App\Http\Middleware\ValidateVisitedCity;
use App\Models\User;
use App\Models\VisitedCities;
use App\Services\VisitedCitiesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ValidateVisitedCityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Middleware\ValidateVisitedCity::__construct
     * @covers \App\Http\Middleware\ValidateVisitedCity::handle
     */
    public function testValidateVisitedCityNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $routeMock = \Mockery::mock(Route::class);
        $visitedCityId = "9999";

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('visitedCityId')
            ->andReturn($visitedCityId);
        $visitedCityServiceMock->shouldReceive('getById')
            ->once()
            ->with($visitedCityId)
            ->andReturnNull();
        $next = function () {
        };

        $validateVisitedCity = new ValidateVisitedCity($visitedCityServiceMock);
        $validateVisitedCity->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\ValidateVisitedCity::__construct
     * @covers \App\Http\Middleware\ValidateVisitedCity::handle
     */
    public function testValidateVisitedCityDoesntBelongToLoggedUser()
    {
        $this->expectException(DifferentUserVisitedCityException::class);
        $this->expectExceptionCode(Response::HTTP_FORBIDDEN);

        $user = User::all()->first();
        $this->be($user);

        $requestMock = \Mockery::mock(Request::class);
        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $routeMock = \Mockery::mock(Route::class);
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $visitedCityId = "1";

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('visitedCityId')
            ->andReturn($visitedCityId);
        $visitedCityServiceMock->shouldReceive('getById')
            ->once()
            ->with($visitedCityId)
            ->andReturn($visitedCityMock);
        $visitedCityMock->shouldReceive('getAttribute')
            ->once()
            ->with('user_id')
            ->andReturn(9999);
        $next = function () {
        };

        $validateVisitedCity = new ValidateVisitedCity($visitedCityServiceMock);
        $validateVisitedCity->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\ValidateVisitedCity::__construct
     * @covers \App\Http\Middleware\ValidateVisitedCity::handle
     */
    public function testValidateVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCity = VisitedCities::all()->first();
        $visitedCity->user_id = $user->id;

        $requestMock = \Mockery::mock(Request::class);
        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $routeMock = \Mockery::mock(Route::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('visitedCityId')
            ->andReturn($visitedCity->id);
        $visitedCityServiceMock->shouldReceive('getById')
            ->once()
            ->with($visitedCity->id)
            ->andReturn($visitedCity);
        $next = function () {
        };

        $validateVisitedCity = new ValidateVisitedCity($visitedCityServiceMock);
        $validateVisitedCity->handle($requestMock, $next);
    }
}
