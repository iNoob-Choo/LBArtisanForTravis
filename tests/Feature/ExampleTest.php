<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testRoutes()
    {
        $response = $this->get('/login');
        // 200 means, simply, that the request was received and understood and is being processed.
        $response->assertSee("Login");
        $this->withoutMiddleware();
        $this->get('/home')->assertSee('Login')
    }


}
