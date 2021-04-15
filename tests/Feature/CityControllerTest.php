<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Controllers\CityController::getCitiesByCountry
     */
    public function testGetCitiesByCountry()
    {
        $country = Country::inRandomOrder()->first();
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getCitiesByCountry', ["countryId" => $country->id]));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals($country, $response->baseResponse->getOriginalContent()->getData()['country']);
    }

    /**
     * @covers \App\Http\Controllers\CityController::getCitiesByCountry
     */
    public function testGetCitiesByCountryWithInvalidCountry()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getCitiesByCountry', ["countryId" => 99999]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The country is invalid", $response->exception->getMessage());
    }
}
