<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitedCities;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
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

    /**
     * @covers \App\Http\Controllers\VisitedCityController::editVisitedCity
     */
    public function testEditVisitedCityWithInvalidId()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('editVisitedCity', ['visitedCityId' => 9999]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The visited city is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::editVisitedCity
     */
    public function testEditVisitedCityForDifferentUser()
    {
        $user = User::all()->first();
        $this->be($user);
        $visitedCity = VisitedCities::all()->first();

        $response = $this->get(route('editVisitedCity', ['visitedCityId' => $visitedCity->id]));
        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->exception->getCode());
        $this->assertEquals("Invalid user which visited the city", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::editVisitedCity
     */
    public function testEditVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCity = VisitedCities::all()->first();
        $visitedCity->user_id = $user->id;
        $visitedCity->save();

        $response = $this->get(route('editVisitedCity', ['visitedCityId' => $visitedCity->id]));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals(
            $visitedCity->id,
            $response->baseResponse->getOriginalContent()->getData()['visitedCity']->id
        );
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::updateVisitedCity
     */
    public function testUpdateVisitedCityWithInvalidId()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->put(
            route('updateVisitedCity', ['visitedCityId' => 9999]),
            ["_method" => "PUT", "visitedAt" => "2018-03-01"]
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The visited city is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::updateVisitedCity
     */
    public function testUpdateVisitedCityForDifferentUser()
    {
        $user = User::all()->first();
        $this->be($user);
        $visitedCity = VisitedCities::where('user_id', '<>', $user->id)->first();

        $response = $this->put(
            route('updateVisitedCity', ['visitedCityId' => $visitedCity->id]),
            ["_method" => "PUT", "visitedAt" => "2018-03-07"]
        );

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->exception->getCode());
        $this->assertEquals("Invalid user which visited the city", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::updateVisitedCity
     */
    public function testUpdateVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCity = VisitedCities::all()->first();
        $visitedCity->user_id = $user->id;
        $visitedCity->save();

        $response = $this->put(
            route('updateVisitedCity', ['visitedCityId' => $visitedCity->id]),
            ["_method" => "PUT", "visitedAt" => "2020-03-15"]
        );
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response->baseResponse);
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::deleteVisitedCity
     */
    public function testDeleteVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCity = VisitedCities::all()->first();
        $visitedCity->user_id = $user->id;
        $visitedCity->save();

        $response = $this->delete(route('deleteVisitedCity', ['visitedCityId' => $visitedCity->id]));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response->baseResponse);

        $visitedCity = VisitedCities::find($visitedCity->id);
        $this->assertNull($visitedCity);
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::deleteVisitedCity
     */
    public function testDeleteVisitedCityWithInvalidVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->delete(route('deleteVisitedCity', ['visitedCityId' => 99999]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The visited city is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\VisitedCityController::deleteVisitedCity
     */
    public function testDeleteVisitedCityForADifferentUser()
    {
        $user = User::all()->first();
        $this->be($user);

        $visitedCity = VisitedCities::all()->first();

        $response = $this->delete(route('deleteVisitedCity', ['visitedCityId' => $visitedCity->id]));
        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->exception->getCode());
        $this->assertEquals("Invalid user which visited the city", $response->exception->getMessage());
    }
}
