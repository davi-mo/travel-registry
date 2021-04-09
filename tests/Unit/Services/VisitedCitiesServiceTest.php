<?php

namespace Tests\Unit\Services;

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

    public function testGetByUserEmpty()
    {
        $visitedCitiesService = new VisitedCitiesService();
        $visitedCities = $visitedCitiesService->getByUser(99999);
        $this->assertEmpty($visitedCities);
    }
}
