<?php	

namespace App\Console\Commands\File;

class GeneratePayDatesCSV {
	/**
     * Add data to selected output file, will overwrite current file
     * @param array $rows  Data to be added
     * @param string $path Path to file
     */
    public function addDataToCSV(array $rows, string $path) : void
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
}