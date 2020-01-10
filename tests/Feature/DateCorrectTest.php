<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DateCorrectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCorrectDate()
    {
        $this->artisan('generate:pay-dates-csv --date="01/01/2021"')
             ->expectsOutput('CSV Saved to: C:\Sites\i\insurance-emporium-test\output.csv')
             ->assertExitCode(0);
    }
}
