<?php

namespace App\Http\Middleware;

use App\Exceptions\NotFoundException;
use App\Services\CountryService;
use Closure;
use Illuminate\Http\Request;

class VerifyExistingCountry
{
    /** @var CountryService */
    private CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
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
        $countryId = $request->route()->parameter('countryId');
        if (!$countryId || !$this->countryService->getById($countryId)) {
            throw NotFoundException::becauseCountryIsInvalid();
        }

        return $next($request);
    }
}
