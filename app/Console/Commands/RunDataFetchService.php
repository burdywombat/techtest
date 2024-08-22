<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DataFetchService;

class RunDataFetchService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-data-fetch-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves and inserts/updates the data fetch service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new DataFetchService;

        return $service->run();
    }
}
