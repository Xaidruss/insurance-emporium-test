<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilepathNullTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFilepathNull()
    {
        $this->artisan('generate:pay-dates-csv')
             ->expectsOutput('CSV Saved to: C:\Sites\i\insurance-emporium-test\output.csv')
             ->assertExitCode(0);
    }
}
