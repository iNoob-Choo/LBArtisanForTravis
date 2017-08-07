<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LBTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
     public function testExample()
     {
       $this->browse(function (Browser $browser) {
         $browser->visit('/login')
                  ->type('email', 'choo@hotmail.com')
                  ->type('password', 'password')
                  ->press('Login')
                  ->assertSee('USER Dashboard')
                  ->clickLink("Add Load Balancer")
                  ->assertSee("Load Balancer")
                  ->value('#providername','Linode Manager')
                  ->value('#location','9')
                  ->value('#labelname','LB Test 2')
                  ->click('button[type="submit"]') //click the submit button
                  ->assertPathIs('/LB/LoadBalancers')
                  ->assertSee('LB Test 2');
             });
     }
}
