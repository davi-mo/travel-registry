<?php

namespace App\Console\Commands;

use App\Services\CountryService;
use App\Services\RegionService;
use App\Services\RestCountryService;
use Illuminate\Console\Command;

class PopulateCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:populate {region=europe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the list of countries';

    /** @var CountryService */
    protected $countryService;

    /** @var RegionService */
    protected $regionService;

    /** @var RestCountryService */
    protected $restCountryService;

    /**
     * Create a new command instance.
     *
     * @param CountryService $countryService
     * @param RegionService $regionService
     * @param RestCountryService $restCountryService
     * @return void
     */
    public function __construct(
        CountryService $countryService,
        RegionService $regionService,
        RestCountryService $restCountryService
    ){
        $this->countryService = $countryService;
        $this->regionService = $regionService;
        $this->restCountryService = $restCountryService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $regionName = lcfirst($this->argument('region'));
        $region = $this->regionService->getRegion($regionName);

        $countries = $this->restCountryService->getCountries($region->name);
        $this->countryService->populateCountries($countries);

        return 0;
    }
}
