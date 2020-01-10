<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DateIncorrectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIncorrectDate()
    {
        $this->artisan('generate:pay-dates-csv --date="-=01/01/2020"')
             ->expectsQuestion('That date is not valid, did you mean "01/01/2020"?', 'yes')
             ->expectsOutput('CSV Saved to: C:\Sites\i\insurance-emporium-test\output.csv')
             ->assertExitCode(0);
    }
}
