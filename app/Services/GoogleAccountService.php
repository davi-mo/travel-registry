<?php

namespace App\Services;

use App\Models\GoogleAccount;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class GoogleAccountService
{
    public function getOrCreateUser(ProviderUser $providerUser) : User
    {
        $googleAccount = GoogleAccount::whereProvider('google')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($googleAccount) {
            return $googleAccount->user;
        } else {
            $googleAccount = $this->mountGoogleAccount($providerUser);
            $user = $this->getUser($providerUser) ?? $this->createUser($providerUser);
            $this->saveGoogleAccount($googleAccount, $user);

            return $user;
        }
    }

    /**
     * @param ProviderUser $providerUser
     * @return GoogleAccount
     */
    protected function mountGoogleAccount(ProviderUser $providerUser) : GoogleAccount
    {
        return new GoogleAccount(
            [
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'google'
            ]
        );
    }

    /**
     * @param GoogleAccount $googleAccount
     * @param User $user
     */
    protected function saveGoogleAccount(GoogleAccount $googleAccount, User $user)
    {
        $googleAccount->user()->associate($user);
        $googleAccount->save();
    }

    /**
     * @param ProviderUser $providerUser
     * @return User|null
     */
    protected function getUser(ProviderUser $providerUser) : ?User
    {
        return User::whereEmail($providerUser->getEmail())->first();
    }

    /**
     * @param ProviderUser $providerUser
     * @return User
     */
    protected function createUser(ProviderUser $providerUser) : User
    {
        return User::create(
            [
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'password' => md5(rand(1, 100000)),
            ]
        );
    }
}
