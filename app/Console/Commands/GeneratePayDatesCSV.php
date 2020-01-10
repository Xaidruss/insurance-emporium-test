<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GeneratePayDatesCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:pay-dates-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a CSV for Wage Pay Dates for the next 12 months.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get Output Path
        $path = $this->getOutputPath();

        // Get Date to Start From
        $start_date = $this->getStartDate();
        
        // Calculate Pay Dates
        $rows = $this->getPaymentDates($start_date);

        dd($start_date, $path);
    }

    /**
     * Get Payment Dates per month
     * @param  Carbon      $start_date Date to calculate payments from
     * @param  int|integer $length     Number of months to calculate
     * @return array                   Array of payment dates
     */
    private function getPaymentDates(Carbon $start_date, int $length = 12) : array
    {
        
    }

    /**
     * Get Carbon instance of starting date for csv export
     * @return \Carbon\Carbon Starting Date for csv export
     */
    private function getStartDate() : Carbon
    {
        return new Carbon;
    }

    /**
     * Get string path for output csv
     * @return string Path for csv
     */
    private function getOutputPath() : string
    {
        return base_path();
    }
}
