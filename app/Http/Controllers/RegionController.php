<?php

namespace App\Http\Controllers;

use App\Services\RegionService;
use Illuminate\View\View;

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
}
