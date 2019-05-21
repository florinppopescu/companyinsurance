<?php

namespace Tests\Feature;

use App\Services\CompaniesHouse\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompaniesHomeApi extends TestCase
{
    /**
     * This will ensure that the variables are correctly configured
     * and we have a connection to the CompaniesHome REST Api
     *
     * @return void
     */
    public function testCheckConnection()
    {
        $companiesHomeClient = new Client();

        $response = $companiesHomeClient->getCompany('1a');

        // we expect to not find that company
        $this->assertEquals(404, $response->code);
    }
}
