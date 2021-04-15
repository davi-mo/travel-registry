<?php

namespace App\Http\Controllers;

use App\Services\RegionService;
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
