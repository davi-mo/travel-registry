<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
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

    /**
     * @covers \App\Http\Controllers\CityController::getCitiesByCountry
     */
    public function testFilterCitiesByName()
    {
        $city = City::inRandomOrder()->first();
        $country = Country::find($city->country_id);
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getCitiesByCountry', ["countryId" => $country->id]) . "?name=" . $city->name);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals($country, $response->baseResponse->getOriginalContent()->getData()['country']);
        $this->assertEquals(1, $response->baseResponse->getOriginalContent()->getData()['cities']->count());
    }

    /**
     * @covers \App\Http\Controllers\CityController::getCitiesByCountry
     */
    public function testFilterCitiesByNameWithInvalidCountry()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getCitiesByCountry', ["countryId" => 99999]) . "?name=city-test");
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The country is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\CityController::editCityPage
     */
    public function testEditCityPage()
    {
        $user = User::all()->first();
        $this->be($user);
        $city = City::all()->first();

        $response = $this->get(route('editCityPage', ['cityId' => $city->id]));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals($city->id, $response->baseResponse->getOriginalContent()->getData()['city']->id);
    }

    /**
     * @covers \App\Http\Controllers\CityController::editCityPage
     */
    public function testEditCityPageWithInvalidCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('editCityPage', ['cityId' => "9999"]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The city is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\CityController::updateCity
     */
    public function testUpdateCity()
    {
        $user = User::all()->first();
        $this->be($user);
        $city = City::inRandomOrder()->first();

        $response = $this->put(
            route('updateCity', ['cityId' => $city->id]),
            ["_method" => "PUT", "name" => "name", "state" => "", "country" => "country"]
        );
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response->baseResponse);

        $updatedCity = City::find($city->id);
        $this->assertEquals("name", $updatedCity->name);
        $this->assertNull($updatedCity->state);
    }

    /**
     * @covers \App\Http\Controllers\CityController::updateCity
     */
    public function testUpdateCityWithInvalidCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->put(
            route('updateCity', ['cityId' => "9999"]),
            ["_method" => "PUT", "name" => "name", "state" => "", "country" => "country"]
        );
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The city is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\CityController::markVisitedCity
     */
    public function testMarkVisitedCity()
    {
        $user = User::all()->first();
        $this->be($user);
        $city = City::all()->first();

        $response = $this->get(route('markVisitedCity', ['cityId' => $city->id]));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals($city->id, $response->baseResponse->getOriginalContent()->getData()['city']->id);
    }

    /**
     * @covers \App\Http\Controllers\CityController::markVisitedCity
     */
    public function testMarkVisitedCityWithInvalidCity()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('markVisitedCity', ['cityId' => "9999"]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The city is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\CityController::nextVisitedCity
     */
    public function testNextVisitedCityWithoutSelectionRegion()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('nextVisitedCity'));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEmpty($response->baseResponse->getOriginalContent()->getData()['countryName']);
        $this->assertEmpty($response->baseResponse->getOriginalContent()->getData()['cityName']);
    }

    /**
     * @covers \App\Http\Controllers\CityController::nextVisitedCity
     */
    public function testNextVisitedCityWithRegion()
    {
        $city = City::all()->first();
        $country = $city->country;
        $regionId = $country->region_id;

        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('nextVisitedCity') . "?region=$regionId");
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertNotEmpty($response->baseResponse->getOriginalContent()->getData()['countryName']);
    }
}
