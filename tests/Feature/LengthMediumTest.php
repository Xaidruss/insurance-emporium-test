<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LengthMediumTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLengthMedium()
    {
        $this->artisan('generate:pay-dates-csv --length="24"')
             ->expectsOutput('CSV Saved to: C:\Sites\i\insurance-emporium-test\output.csv')
             ->assertExitCode(0);
    }
}
