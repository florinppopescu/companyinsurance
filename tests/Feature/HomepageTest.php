<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCheckHomepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
