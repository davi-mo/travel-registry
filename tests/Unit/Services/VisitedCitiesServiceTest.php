<?php

namespace Tests\Unit\Services;

use App\Models\City;
use App\Models\User;
use App\Models\VisitedCities;
use App\Services\VisitedCitiesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitedCitiesServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Services\VisitedCitiesService::getByUser
     */
    public function testGetByUser()
    {
        $visitedCity = VisitedCities::all()->first();

        $visitedCitiesService = new VisitedCitiesService();
        $visitedCities = $visitedCitiesService->getByUser($visitedCity->user_id);
        $this->assertNotEmpty($visitedCities);
    }

    /**
     * @covers \App\Services\VisitedCitiesService::getByUser
     */
    public function testGetByUserEmpty()
    {
        $visitedCitiesService = new VisitedCitiesService();
        $visitedCities = $visitedCitiesService->getByUser(99999);
        $this->assertEmpty($visitedCities);
    }

    /**
     * @covers \App\Services\VisitedCitiesService::getById
     */
    public function testGetById()
    {
        $visitedCity = VisitedCities::all()->first();

        $visitedCitiesService = new VisitedCitiesService();
        $returnedVisitedCity = $visitedCitiesService->getById($visitedCity->id);
        $this->assertNotNull($returnedVisitedCity);
        $this->assertEquals($visitedCity, $returnedVisitedCity);
    }

    /**
     * @covers \App\Services\VisitedCitiesService::getById
     */
    public function testGetByIdNotFound()
    {
        $visitedCitiesService = new VisitedCitiesService();
        $returnedVisitedCity = $visitedCitiesService->getById(99999);
        $this->assertNull($returnedVisitedCity);
    }

    /**
     * @covers \App\Services\VisitedCitiesService::updateVisitedCity
     */
    public function testUpdateVisitedCity()
    {
        $visitedAt = '2020-10-01';
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $visitedCityMock->shouldReceive('setAttribute')
            ->once()
            ->andReturnNull();
        $visitedCityMock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        $visitedCitiesService = new VisitedCitiesService();
        $visitedCitiesService->updateVisitedCity($visitedCityMock, $visitedAt);
    }

    /**
     * @covers \App\Services\VisitedCitiesService::updateVisitedCity
     */
    public function testUpdateVisitedCityWithEmptyDate()
    {
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $visitedCityMock->shouldReceive('setAttribute')
            ->once()
            ->with('visited_at', null)
            ->andReturnNull();
        $visitedCityMock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        $visitedCitiesService = new VisitedCitiesService();
        $visitedCitiesService->updateVisitedCity($visitedCityMock, null);
    }

    /**
     * @covers \App\Services\VisitedCitiesService::deleteVisitedCity
     */
    public function testDeleteVisitedCity()
    {
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $visitedCityMock->shouldReceive('delete')->once()->withNoArgs()->andReturnNull();

        $visitedCitiesService = new VisitedCitiesService();
        $visitedCitiesService->deleteVisitedCity($visitedCityMock);
    }

    /**
     * @covers \App\Services\VisitedCitiesService::saveVisitedCity
     */
    public function testSaveVisitedCity()
    {
        $visitedCityMock = \Mockery::mock(VisitedCities::class);
        $cityMock = \Mockery::mock(City::class);
        $userMock = \Mockery::mock(User::class);
        $cityId = "1";
        $userId = "1";

        $cityMock->shouldReceive('getAttribute')
            ->once()
            ->with('id')
            ->andReturn($cityId);
        $userMock->shouldReceive('getAttribute')
            ->once()
            ->with('id')
            ->andReturn($userId);
        $visitedCityMock->shouldReceive('setAttribute')
            ->once()
            ->with('city_id', $cityId)
            ->andReturnNull();
        $visitedCityMock->shouldReceive('setAttribute')
            ->once()
            ->with('user_id', $userId)
            ->andReturnNull();
        $visitedCityMock->shouldReceive('setAttribute')
            ->once()
            ->with('visited_at', null)
            ->andReturnNull();
        $visitedCityMock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        $visitedCitiesService = new VisitedCitiesService();
        $visitedCitiesService->saveVisitedCity($visitedCityMock, $cityMock, $userMock);
    }
}
