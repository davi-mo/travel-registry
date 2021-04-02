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

    public function testGetAllRegions()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getAllRegions'));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testUpdateRegion()
    {
        $user = User::all()->first();
        $this->be($user);

        $region = Region::all()->first();

        $response = $this->get(route('updateRegion', ['regionId' => $region->id]));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response->baseResponse);
    }
}
