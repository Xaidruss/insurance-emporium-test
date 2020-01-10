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
    protected $signature = 'generate:pay-dates-csv {file_path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a CSV for Wage Pay Dates for the next 12 months.';

    /**
     * The overwiteable options provided for this command
     * 
     * @var array
     */
    protected $options = [];

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
        // Process Input Options
        $this->setCommandOptions();

        // Get Output Path
        $path = $this->getOutputPath();

        // Get Date to Start From
        $start_date = $this->getStartDate();
        
        // Calculate Pay Dates
        $rows = $this->getPaymentDates($start_date);

        // Add headers to data array
        array_unshift($rows, [
            'Month',
            'Base Payment Date',
            'Bonus Payment Date'
        ]);

        // Add data to csv at $path
        $this->addDataToCSV($rows, $path);
    }

    private function setCommandOptions() : void
    {
        $file_path = $this->argument('file_path');

        if ($file_path) {
            $this->options['file_path'] = $this->argument('file_path');
        } else {
            $this->options['file_path'] = base_path() . DIRECTORY_SEPARATOR . 'output.csv';
        }
    }

    private function addDataToCSV($rows, $path) : void
    {
        // Create file handle
        $file = fopen($path, 'w+');

        // Add data to file, lenght is calculated outside of for loop to improve speed
        $length = count($rows);
        for ($i = 0; $i < $length; $i++) {
            fputcsv($file, $rows[$i]);
        }

        // Close file
        fclose($file);
    }

    /**
     * Get Payment Dates per month
     * @param  Carbon      $start_date Date to calculate payments from
     * @param  int|integer $length     Number of months to calculate
     * @return array                   Array of payment dates
     */
    private function getPaymentDates(Carbon $start_date, int $length = 12) : array
    {
        // Carbon is mutable, so create clone for method to pevent global changes
        $start_date = clone $start_date;

        // Default return array
        $return = [];

        // Loop for $length and append to array using column names
        for ($i = 0; $i < $length; $i++) {
            $return[] = [
                $start_date->format('F Y'),
                $this->getBasePaymentDate($start_date),
                $this->getBonusPaymentDate($start_date)
            ];

            $start_date->addMonth();
        }

        return $return;
    }

    /**
     * Get base payment date for month, base payment is on the last working day
     * of month where working days are Monday - Friday.
     * @param  Carbon $date Carbon date of selected month
     * @return string       Formatted date of base payment date
     */
    private function getBasePaymentDate(Carbon $date) : string
    {
        // Carbon is mutable, so create clone for method to pevent global changes
        $date = clone $date;

        // Set cloned date to end of month
        $date->endOfMonth();

        // Get month to prevent infinite loop
        $month = $date->format('n');
        while ($date->format('n') == $month) {
            $day_in_week_index = $date->format('N');
            // Break if valid weekday
            if ($day_in_week_index >= 1 && $day_in_week_index <= 5) {
                break;
            }

            $date->subDay();
        }

        // Format date
        return $date->format('jS F Y');
    }

    /**
     * Get bonus payment date for month
     * @param  Carbon $date Carbon date of selected month
     * @return string       Formatted date of bonus payment date
     */
    private function getBonusPaymentDate(Carbon $date) : string
    {
        // Carbon is mutable, so create clone for method to pevent global changes
        $date = clone $date;

        // Set date to 10th
        $date->setDay(10);

        // if date on Saturday or Sunday find first Tuesday (index = 2)
        $week_index = $date->format('N');
        if ($week_index == 0 || $week_index == 6) {
            // Required date is closer to beginning of month so set date to beginning of month
            $date->startOfMonth();

            // Get month to prevent infinite loop
            $month = $date->format('n');
            while ($date->format('n') == $month) {
                // Break if tuesday
                if ($date->format('N') == 2) {
                    break;
                }

                $date->addDay();
            }
        }

        return $date->format('jS F Y');
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
        // Check for directory
        if (is_dir($this->options['file_path'])) {
            return $this->options['file_path'] . DIRECTORY_SEPARATOR . 'output.csv';
        } else {
            return $this->options['file_path'];
        }
    }
}
