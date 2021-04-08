<?php

namespace App\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Services\RegionService;
use Closure;
use Illuminate\Http\Request;

class VerifyExistingRegion
{
    /** @var RegionService */
    private RegionService $regionService;

    /**
     * VerifyExistingRegion constructor.
     * @param RegionService $regionService
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
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
        $regionId = $request->route()->parameter('regionId');
        if (!$regionId || !$this->regionService->getRegionById($regionId)) {
            throw NotFoundException::becauseRegionIsInvalid();
        }

        return $next($request);
    }
}
