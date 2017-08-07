<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\LB;
use App\APIKEY;
use App\BackendServer;
use App\FrontendServer;

class UnitTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
     public function testUserCreation()
     {
       //given two User in the system
       $first  = factory(User::class)->create();
       $second = factory(User::class)->create([
         'created_at' => \Carbon\Carbon::now()->subMonth()
       ]);

       //when
       $user = User::select('created_at')->get();

       //then
       // test registration of user, created 2 user and db will have 2
       $this->assertCount(2,$user);

     }

     public function testLBCreation()
     {
       //create 20 LB
       $lb  = factory(LB::class,20)->make();
       //test that the database has 20 rows
       $this->assertCount(20,$lb);

     }

     public function testAPICreation()
     {
       //create 20 API
       $api_key  = factory(APIKEY::class,20)->make();
       //test that the database has 20 rows
       $this->assertCount(20,$api_key);

     }

     public function testFrontendCreation()
     {
       //create 20 API
       $object  = factory(FrontendServer::class,20)->make();
       //test that the database has 20 rows
       $this->assertCount(20,$object);



     }

     public function testBackendCreation()
     {
       //create 20 API
       $object  = factory(BackendServer::class,20)->make();
       //test that the database has 20 rows
       $this->assertCount(20,$object);

     }

}
