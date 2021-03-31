<?php

namespace Tests\Unit\Services;

use App\Models\GoogleAccount;
use App\Models\User;
use App\Services\GoogleAccountService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleAccountServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @covers \App\Services\GoogleAccountService::getOrCreateUser
     */
    public function testGetAccountUser()
    {
        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('123456789');

        $builderMock = \Mockery::mock('Illuminate\Database\Eloquent\Builder');

        $googleAccount = GoogleAccount::all()->first();

        $googleAccountMock = \Mockery::mock(GoogleAccount::class);
        $googleAccountMock->shouldReceive('whereProvider')->with('google')->andReturn($builderMock);
        $builderMock->shouldReceive('whereProviderUserId')->with($abstractUser->getId())->andReturnSelf();
        $builderMock->shouldReceive('first')->withNoArgs()->andReturn($googleAccount);

        $googleAccountService = new GoogleAccountService();
        $googleAccountService->getOrCreateUser($abstractUser);
    }

    /**
     * @covers \App\Services\GoogleAccountService::getOrCreateUser
     * @covers \App\Services\GoogleAccountService::mountGoogleAccount
     * @covers \App\Services\GoogleAccountService::getUser
     * @covers \App\Services\GoogleAccountService::createUser
     * @covers \App\Services\GoogleAccountService::saveGoogleAccount
     */
    public function testCreateUser()
    {
        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('987654321');
        $abstractUser->shouldReceive('getEmail')->andReturn('test@test.com');
        $abstractUser->shouldReceive('getName')->andReturn('Test test');

        $builderMock = \Mockery::mock('Illuminate\Database\Eloquent\Builder');

        $user = new User();
        $user->id = 12345;

        $googleAccount = new GoogleAccount();
        $googleAccount->user = $user;

        $googleAccountMock = \Mockery::mock(GoogleAccount::class);
        $googleAccountMock->shouldReceive('whereProvider')->with('google')->andReturn($builderMock);
        $builderMock->shouldReceive('whereProviderUserId')->with($abstractUser->getId())->andReturnSelf();
        $builderMock->shouldReceive('first')->withNoArgs()->andReturn($googleAccount);

        $googleAccountService = new GoogleAccountService();
        $user = $googleAccountService->getOrCreateUser($abstractUser);
        $this->assertNotNull($user);
        $this->assertNotNull($user->id);
        $this->assertEquals('Test test', $user->name);
        $this->assertEquals('test@test.com', $user->email);
    }

    /**
     * @covers \App\Services\GoogleAccountService::mountGoogleAccount
     */
    public function testMountGoogleAccountService()
    {
        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('123456789');

        $googleAccountService = \Mockery::mock(GoogleAccountService::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $googleAccount = $googleAccountService->mountGoogleAccount($abstractUser);
        $this->assertNotNull($googleAccount);
        $this->assertEquals("123456789", $googleAccount->provider_user_id);
        $this->assertEquals("google", $googleAccount->provider);
    }

    /**
     * @covers \App\Services\GoogleAccountService::saveGoogleAccount
     */
    public function testSaveGoogleAccount()
    {
        $googleAccountMock = \Mockery::mock(GoogleAccount::class);
        $belongsToMock = \Mockery::mock(BelongsTo::class);
        $modelMock = \Mockery::mock(Model::class);
        $userMock = \Mockery::mock(User::class);

        $googleAccountMock->shouldReceive('user')
            ->once()
            ->withNoArgs()
            ->andReturn($belongsToMock);

        $belongsToMock->shouldReceive('associate')
            ->once()
            ->with($userMock)
            ->andReturn($modelMock);

        $googleAccountMock->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->andReturnTrue();

        $googleAccountService = \Mockery::mock(GoogleAccountService::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $googleAccountService->saveGoogleAccount($googleAccountMock, $userMock);
    }
}
