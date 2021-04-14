<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\VisitedCityController;
use App\Models\User;
use App\Models\VisitedCities;
use App\Services\VisitedCitiesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Tests\TestCase;

class VisitedCityControllerTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::getByUser
     */
    public function testGetByUser()
    {
        $user = User::all()->first();
        $this->be($user);

        $collectionMock = \Mockery::mock(Collection::class);
        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $visitedCityServiceMock->shouldReceive('getByUser')
            ->once()
            ->with($user->id)
            ->andReturn($collectionMock);

        $visitedCityController = new VisitedCityController();
        $response = $visitedCityController->getByUser($visitedCityServiceMock);
        $this->assertEquals("visited-cities", $response->getName());
        $this->assertContains($collectionMock, $response->getData());
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::editVisitedCity
     */
    public function testEditVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $visitedCityId = 1;

        $visitedCityServiceMock->shouldReceive('getById')
            ->once()
            ->with($visitedCityId)
            ->andReturn($visitedCityMock);

        $visitedCityController = new VisitedCityController();
        $response = $visitedCityController->editVisitedCity($visitedCityId, $visitedCityServiceMock);

        $this->assertInstanceOf(View::class, $response);
        $this->assertContains($visitedCityMock, $response->getData());
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::updateVisitedCity
     */
    public function testUpdateVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $requestMock = \Mockery::mock(Request::class);
        $visitedCityId = 1;

        $visitedCityServiceMock->shouldReceive('getById')
            ->once()
            ->with($visitedCityId)
            ->andReturn($visitedCityMock);
        $requestMock->shouldReceive('get')
            ->once()
            ->with('visitedAt')
            ->andReturn("10/04/2021");
        $visitedCityServiceMock->shouldReceive('updateVisitedCity')
            ->once()
            ->with($visitedCityMock, "10/04/2021")
            ->andReturnNull();

        $visitedCityController = new VisitedCityController();
        $response = $visitedCityController->updateVisitedCity($visitedCityId, $requestMock, $visitedCityServiceMock);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::deleteVisitedCity
     */
    public function testDeleteVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCityServiceMock = \Mockery::mock(VisitedCitiesService::class);
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $visitedCityId = 1;

        $visitedCityServiceMock->shouldReceive('getById')
            ->once()
            ->with($visitedCityId)
            ->andReturn($visitedCityMock);
        $visitedCityServiceMock->shouldReceive('deleteVisitedCity')
            ->once()
            ->with($visitedCityMock)
            ->andReturnNull();

        $visitedCityController = new VisitedCityController();
        $response = $visitedCityController->deleteVisitedCity($visitedCityId, $visitedCityServiceMock);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
