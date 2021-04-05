<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
