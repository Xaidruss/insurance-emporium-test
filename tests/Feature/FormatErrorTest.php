<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormatErrorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFormatError()
    {
        $this->artisan('generate:pay-dates-csv --format="ddgs/fds"')
             ->expectsOutput('CSV Saved to: C:\Sites\i\insurance-emporium-test\output.csv')
             ->assertExitCode(0);
    }
}
