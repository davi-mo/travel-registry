<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function getUser() : View
    {
        $user = auth()->user();
        return view("edit-user")->with("user", $user);
    }

    /**
     * @param string $userId
     * @param Request $request
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function updateUser(
        string $userId,
        Request $request,
        UserService $userService,
    ) : RedirectResponse {
        $user = $userService->getById($userId);
        $userName = $request->get('name');

        $userService->updateUser($user, $userName);
        return redirect()->to('/home');
    }
}
