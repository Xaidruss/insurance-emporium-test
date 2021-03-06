<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LengthLargeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLengthLarge()
    {
        $this->artisan('generate:pay-dates-csv --length="2400"')
             ->expectsOutput('CSV Saved to: C:\Sites\i\insurance-emporium-test\output.csv')
             ->assertExitCode(0);
    }
}
