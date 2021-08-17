<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Http\Controllers\UserController::getUser
     */
    public function testGetUser()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->get(route('getUser'));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @covers \App\Http\Controllers\UserController::updateUser
     */
    public function testUpdateUser()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->put(
            route('updateUser', ['userId' => $user->id]),
            ["_method" => "PUT", "name" => "unit-test-name"]
        );
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response->baseResponse);
    }

    /**
     * @covers \App\Http\Controllers\UserController::updateUser
     */
    public function testUpdateUserWithInvalidUser()
    {
        $user = User::all()->first();
        $this->be($user);

        $response = $this->put(
            route('updateUser', ['userId' => 9999]),
            ["_method" => "PUT", "name" => "unit-test-name"]
        );
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The user is invalid", $response->exception->getMessage());
    }

    /**
     * @covers \App\Http\Controllers\UserController::updateUser
     */
    public function testUpdateUserForADifferentUserThanLogged()
    {
        $user = User::all()->first();
        $lastUser = User::all()->last();
        $this->be($user);

        $response = $this->put(
            route('updateUser', ['userId' => $lastUser->id]),
            ["_method" => "PUT", "name" => "unit-test-name"]
        );
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->exception->getCode());
        $this->assertEquals("The user is invalid", $response->exception->getMessage());
    }
}
