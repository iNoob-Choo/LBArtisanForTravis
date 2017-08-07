<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
      $this->browse(function (Browser $browser) {
      $browser->visit('/') //Go to the homepage
              ->clickLink('Register') //Click the Register link
              ->assertSee('Register') //Make sure the phrase in the arguement is on the page
      //Fill the form with these values
              ->value('#name', 'Joe')
              ->value('#email', 'joe@example.com')
              ->value('#password', '123456')
              ->value('#password-confirm', '123456')
              ->click('button[type="submit"]') //Click the submit button on the page
              ->assertPathIs('/home') //Make sure you are in the home page
      //Make sure you see the phrase in the arguement
              ->assertSee("USER Dashboard");
  });
    }
}
