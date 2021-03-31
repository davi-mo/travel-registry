<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Controllers\HomeController::home()
     */
    public function testGetHome()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('home'));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
