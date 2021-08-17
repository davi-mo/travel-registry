<?php

namespace App\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Services\UserService;
use Illuminate\Http\Request;
use \Closure;

class VerifyExistingUser
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->route()->parameter('userId');
        $user = $this->userService->getById($userId);
        if (!$user) {
            throw NotFoundException::becauseUserIsInvalid();
        }

        if ($user->id !== auth()->user()->id) {
            throw NotFoundException::becauseUserIsInvalid();
        }

        return $next($request);
    }
}
