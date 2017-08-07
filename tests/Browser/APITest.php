<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APITest extends DuskTestCase
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
                  ->clickLink("Add API KEY")
                  ->assertSee("API KEY")
                  ->value('#providername','Linode Manager')
                  ->value('#apikey','X8vHzZGp4VnVU0CIsGDodNjhuACq8jx1DoT4LqocHzmqwfzWxES9ec0kPDy3xAdF')
                  ->click('button[type="submit"]') //click the submit button
                  ->assertPathIs('/home')
                  ->assertSee('USER Dashboard')
                  ->clickLink('View API KEY')
                  ->assertSee('X8vHzZGp4VnVU0CIsGDodNjhuACq8jx1DoT4LqocHzmqwfzWxES9ec0kPDy3xAdF');
             });
     }





}
