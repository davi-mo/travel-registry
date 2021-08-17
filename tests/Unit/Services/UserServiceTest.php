<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Services\UserService::getById
     */
    public function testGetById()
    {
        $databaseUser = User::all()->first();

        $userService = new UserService();
        $user = $userService->getById($databaseUser->id);
        $this->assertNotNull($user);
        $this->assertEquals($databaseUser, $user);
    }

    /**
     * @covers \App\Services\UserService::getById
     */
    public function testGetRegionByIdNotFound()
    {
        $userService = new UserService();
        $this->assertNull($userService->getById("9999"));
    }

    /**
     * @covers \App\Services\UserService::updateUser
     */
    public function testUpdateUser()
    {
        $userMock = \Mockery::mock(User::class);
        $userServiceMock = \Mockery::mock(UserService::class)->makePartial();
        $name = "unit-test";

        $userMock->shouldReceive('setAttribute')
            ->once()
            ->with('name', $name);
        $userMock->shouldReceive('setAttribute')
            ->once();
        $userMock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnTrue();
        $userServiceMock->updateUser($userMock, $name);
    }
}
