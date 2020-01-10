<?php

namespace App\Console\Commands\Config;

use Carbon\Carbon;
use App\Console\Commands\GeneratePayDatesCSV as Command;

class GeneratePayDatesCSV {
    /**
     * The Command being run
     * @var \App\Console\Commands\GeneratePayDatesCSV
     */
	private $command;

    /**
     * The options provided for this command
     * 
     * @var array
     */
    protected $options = [];

    /**
     * Setup Config object
     * @param Command $command The command being run
     */
	public function __construct(Command $command)
	{
		$this->command = $command;
	}

	/**
     * Set command options using optional arguments
     */
    public function setCommandOptions() : void
    {
        $file_path = $this->command->argument('file_path');

        if ($file_path) {
            // Use provided file path
            $this->options['file_path'] = $file_path;
        } else {
            // Use default
            $this->options['file_path'] = base_path() . DIRECTORY_SEPARATOR . 'output.csv';
        }

        $date = $this->command->option('date');

        if ($date) {
            // Correct date format = d/m/Y
            // Checks for exact format match
            if (preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $date)) {
                $this->options['date'] = Carbon::createFromFormat('d/m/Y', $date);
            } else {
                // Attempt to guess correct date using Carbon::parse and sanitized string
                $new_date = preg_replace('/[^a-z\/0-9]+/i', '', $date);
                $new_date = @Carbon::parse($new_date);

                if (!$new_date) {
                    $new_date = new Carbon;
                }

                // check if new date is correct
                $correct = $this->command->confirm('That date is not valid, did you mean "' . $new_date->format('d/m/Y') . '"?');
                
                if ($correct) {
                    $this->options['date'] = $new_date;
                } else {
                    exit;
                }
            }
        } else {
            // Provides default of current date
            $this->options['date'] = new Carbon;
        }

        $format = $this->command->option('format');
        
        if ($format) {
            $this->options['date_format'] = $format;
        } else {
            $this->options['date_format'] = 'jS F Y';
        }

        $length = (int)$this->command->option('length');
        
        if ($length) {
            $this->options['length'] = $length;
        } else {
            $this->options['length'] = 12;
        }
    }

    /**
     * Get Option value from config
     * @param  string $key     Option to return
     * @param  string $default Value to return if option not found
     * @return mixed           Option value
     */
    public function getOption(string $key, $default = '')
    {
    	if (isset($this->options[$key])) {
    		return $this->options[$key];
    	} else {
    		return $default;
    	}
    }
}