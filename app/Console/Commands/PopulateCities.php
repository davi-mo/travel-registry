<?php

namespace App\Console\Commands;

use App\Services\CityService;
use Illuminate\Console\Command;

class PopulateCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'city:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will populate the list of cities';

    /** @var CityService */
    private $cityService;

    /**
     * Create a new command instance.
     *
     * @param CityService $cityService
     * @return void
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->cityService->populateCities();
        return 0;
    }
}
