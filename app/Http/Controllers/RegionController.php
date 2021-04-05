<?php

namespace App\Http\Controllers;

use App\Services\RegionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class RegionController extends Controller
{
    /**
     * @param RegionService $regionService
     * @return View
     */
    public function getAllRegions(RegionService $regionService) : View
    {
        $regions = $regionService->getAllRegions();
        return view("regions")->with("regions", $regions);
    }

    public function getActiveRegions(RegionService $regionService) : View
    {
        $regions = $regionService->getActiveRegions();
        return view("countries")
            ->with("regions", $regions)
            ->with("selectedRegionId", 0)
            ->with("countries", new Collection());
    }

    /**
     * @param string $regionId
     * @param RegionService $regionService
     * @return RedirectResponse
     */
    public function updateRegion(string $regionId, RegionService $regionService) : RedirectResponse
    {
        $regionService->activeInactiveRegion($regionId);
        return redirect()->to('/regions');
    }
}
