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

        dd($start_date, $path, $rows);
    }

    /**
     * Get Payment Dates per month
     * @param  Carbon      $start_date Date to calculate payments from
     * @param  int|integer $length     Number of months to calculate
     * @return array                   Array of payment dates
     */
    private function getPaymentDates(Carbon $start_date, int $length = 12) : array
    {
        // Carbon is mutable, so create clone for method
        $start_date = clone $start_date;

        // Default return array
        $return = [];

        // Loop for $length and append to array using column names
        for ($i = 0; $i < $length; $i++) {
            $return[] = [
                'month'               => $start_date->format('F Y'),
                'base_payment_date'   => $this->getBasePaymentDate($start_date),
                'bonues_paymnet_date' => $this->getBonusPaymentDate($start_date)
            ];

            $start_date->addMonth();
        }

        return $return;
    }

    /**
     * [getBasePaymentDate description]
     * @param  Carbon $date [description]
     * @return [type]       [description]
     */
    private function getBasePaymentDate(Carbon $date) : 
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
