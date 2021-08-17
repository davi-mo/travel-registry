<?php

namespace App\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Services\CityService;
use Illuminate\Http\Request;
use Closure;

class VerifyExistingCity
{
    private CityService $cityService;

    /**
     * VerifyExistingCity constructor.
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
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
        $cityId = $request->route()->parameter('cityId');
        if (!$cityId || !$this->cityService->getById($cityId)) {
            throw NotFoundException::becauseCityIsInvalid();
        }

        return $next($request);
    }
}
