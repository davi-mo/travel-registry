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

        $response = $this->post(route('getCountriesByRegion'), ["_method" => "POST", "region" => 4]);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response->baseResponse);
        $this->assertEquals(4, $response->baseResponse->getOriginalContent()->getData()['selectedRegionId']);
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
}
