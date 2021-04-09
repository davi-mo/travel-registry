<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class VisitedCityControllerTest extends TestCase
{
    use RefreshDatabase;

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

        $response = $this->get(route('visitedCities'));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
    }
}
