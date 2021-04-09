<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\VisitedCityController;
use App\Models\User;
use App\Services\VisitedCitiesService;
use Illuminate\Database\Eloquent\Collection;
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
}
