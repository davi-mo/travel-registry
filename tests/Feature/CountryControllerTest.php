<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Controllers\CountryController::getCountriesByRegion
     */
    public function testGetCountriesByRegion()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getCountriesByRegion', ["regionId" => 4]));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
    }

    /**
     * @covers \App\Http\Controllers\CountryController::getCountriesByRegion
     */
    public function testGetCountriesByRegionWithInvalidRegion()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getCountriesByRegion', ["regionId" => 99999]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The region is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\CountryController::getCountriesByRegion
     */
    public function testFilterCountry()
    {
        $user = User::all()->first();
        $this->be($user);

        $country = Country::inRandomOrder()->first();
        $country->region_id = 4;
        $country->save();

        $response = $this->get(route('getCountriesByRegion', ["regionId" => $country->region_id]) . "?term=" . $country->code);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals(1, $response->baseResponse->getOriginalContent()->getData()['countries']->count());
    }

    /**
     * @covers \App\Http\Controllers\CountryController::getCountriesByRegion
     */
    public function testFilterCountriesWithInvalidRegion()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getCountriesByRegion', ["regionId" => 99999]) . "?term=unittest");
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The region is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\CountryController::editCountryPage
     */
    public function testEditCountryPage()
    {
        $user = User::all()->first();
        $this->be($user);
        $country = Country::all()->first();

        $response = $this->get(route('editCountryPage', ['countryId' => $country->id]));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals($country->id, $response->baseResponse->getOriginalContent()->getData()['country']->id);
    }

    /**
     * @covers \App\Http\Controllers\CountryController::editCountryPage
     */
    public function testEditCountryPageWithInvalidCountry()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('editCountryPage', ['countryId' => "9999"]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The country is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\CountryController::updateCountry
     */
    public function testUpdateCountry()
    {
        $user = User::all()->first();
        $this->be($user);
        $country = Country::all()->first();

        $response = $this->put(
            route('updateCountry', ['countryId' => $country->id]),
            ["_method" => "PUT", "region" => "Europe", "name" => "name", "code" => "cd", "capital" => "capital"]
        );
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response->baseResponse);

        $updatedCountry = Country::find($country->id);
        $this->assertEquals("name", $updatedCountry->name);
        $this->assertEquals("cd", $updatedCountry->code);
        $this->assertEquals("capital", $updatedCountry->capital);
    }

    /**
     * @covers \App\Http\Controllers\CountryController::updateCountry
     */
    public function testUpdateCountryWithInvalidCountry()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->put(
            route('updateCountry', ['countryId' => "9999"]),
            ["_method" => "PUT", "region" => "Europe", "name" => "name", "code" => "cd", "capital" => "capital"]
        );
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The country is invalid", $response->exception->getMessage());
    }
}
