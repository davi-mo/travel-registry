<?php

namespace App\Http\Controllers;

use App\Services\GoogleAccountService;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthGoogleController
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToProvider() : RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @param GoogleAccountService $googleAccountService
     * @return RedirectResponse
     */
    public function handleProviderCallback(GoogleAccountService $googleAccountService) : RedirectResponse
    {
        $user = $googleAccountService->getOrCreateUser($providerUser = Socialite::driver('google')->user());
        auth()->login($user);
        return redirect()->to('/home');
    }
}
