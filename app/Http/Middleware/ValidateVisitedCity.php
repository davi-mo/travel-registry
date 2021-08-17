<?php

namespace App\Http\Middleware;

use App\Exceptions\DifferentUserVisitedCityException;
use App\Exceptions\NotFoundException;
use App\Services\VisitedCitiesService;
use Illuminate\Http\Request;
use Closure;

class ValidateVisitedCity
{
    private VisitedCitiesService $visitedCitiesService;

    /**
     * ValidateVisitedCity constructor.
     * @param VisitedCitiesService $visitedCitiesService
     */
    public function __construct(VisitedCitiesService $visitedCitiesService)
    {
        $this->visitedCitiesService = $visitedCitiesService;
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
        $visitedCityId = $request->route()->parameter('visitedCityId');
        $visitedCity = $this->visitedCitiesService->getById($visitedCityId);
        if (!$visitedCity) {
            throw NotFoundException::becauseVisitedCityIsInvalid();
        }

        if ($visitedCity?->user_id !== auth()->user()->id) {
            throw DifferentUserVisitedCityException::becauseDifferentUserVisitedCity();
        }

        return $next($request);
    }
}
