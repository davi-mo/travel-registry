<?php

namespace Tests\Feature;

use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Controllers\RegionController::getAllRegions
     */
    public function testGetAllRegions()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getAllRegions'));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @covers \App\Http\Controllers\RegionController::updateRegion
     */
    public function testUpdateRegion()
    {
        $user = User::all()->first();
        $this->be($user);

        $region = Region::all()->first();

        $response = $this->put(route('updateRegion', ['regionId' => $region->id]));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response->baseResponse);
    }

    public function testUpdateWithInvalidRegion()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->put(route('updateRegion', ['regionId' => "9999"]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The region is invalid", $response->exception->getMessage());
    }
}
