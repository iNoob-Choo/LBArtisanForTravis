<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ServerTesting extends DuskTestCase
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
                  ->clickLink("View LB")
                  ->assertSee("Load Balancers")
                  ->clickLink('LB Test 1')
                  ->assertSee('Frontend Details')
                  ->clickLink('Add')
                  ->value('#port_no','80')
                  ->value('#protocol','HTTP')
                  ->click('button[type="submit"]') //click the submit button
                  ->assertPathIs('/LB/LoadBalancers')
                  ->clickLink('LB Test 1')
                  ->assertSee('HTTP')
                  ->clickLink('View Backend')
                  ->assertSee('Backend Server')
                  ->clickLink('Add')
                  ->value('#port_no','80')
                  ->value('#labelname','Test Backend 1')
                  ->value('#ip_address','192.168.0.1')
                  ->click('button[type="submit"]')
                  ->assertPathIs('/LB/LoadBalancers')
                  ->clickLink('LB Test 1')
                  ->clickLink('View Backend')
                  ->assertSee('Test Backend 1');

             });
     }
}
