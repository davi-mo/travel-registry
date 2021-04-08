<?php

namespace Tests\Unit\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Http\Middleware\VerifyExistingCountry;
use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Tests\TestCase;

class VerifyExistingCountryTest extends TestCase
{
    /**
     * @covers \App\Http\Middleware\VerifyExistingCountry::__construct
     * @covers \App\Http\Middleware\VerifyExistingCountry::handle
     */
    public function testVerifyCountryNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $routeMock = \Mockery::mock(Route::class);
        $countryId = "9999";

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('countryId')
            ->andReturn($countryId);
        $countryServiceMock->shouldReceive('getById')
            ->once()
            ->with($countryId)
            ->andReturnNull();
        $next = function () {
        };

        $verifyExistingCountry = new VerifyExistingCountry($countryServiceMock);
        $verifyExistingCountry->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingCountry::__construct
     * @covers \App\Http\Middleware\VerifyExistingCountry::handle
     */
    public function testVerifyExistingCountryWithoutParameter()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $requestMock = \Mockery::mock(Request::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $routeMock = \Mockery::mock(Route::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('countryId')
            ->andReturnNull();
        $next = function () {
        };

        $verifyExistingCountry = new VerifyExistingCountry($countryServiceMock);
        $verifyExistingCountry->handle($requestMock, $next);
    }

    /**
     * @covers \App\Http\Middleware\VerifyExistingCountry::__construct
     * @covers \App\Http\Middleware\VerifyExistingCountry::handle
     */
    public function testVerifyExistingCountry()
    {
        $requestMock = \Mockery::mock(Request::class);
        $countryServiceMock = \Mockery::mock(CountryService::class);
        $routeMock = \Mockery::mock(Route::class);
        $countryId = "1";
        $country = \Mockery::mock(Country::class);

        $requestMock->shouldReceive('route')
            ->once()
            ->withNoArgs()
            ->andReturn($routeMock);
        $routeMock->shouldReceive('parameter')
            ->once()
            ->with('countryId')
            ->andReturn($countryId);
        $countryServiceMock->shouldReceive('getById')
            ->once()
            ->with($countryId)
            ->andReturn($country);
        $next = function () {
        };

        $verifyExistingCountry = new VerifyExistingCountry($countryServiceMock);
        $verifyExistingCountry->handle($requestMock, $next);
    }
}
