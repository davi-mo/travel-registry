<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
