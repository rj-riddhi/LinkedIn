<?php

namespace Tests\Unit;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRegestration()
    {
       $response = $this->call('POST','/api/Loginuser',[
        // 'profile' => 'User Profile Picture',
        'usersFirstName' => 'fisrt',
        'usersLastName' => 'Last',
        'email' => "user@gmail.com",
        'phone' => '1234567089',
        'password' => 'pass@pass',
        'role' => 'Admin',
        'pwdRepeat'=>'pass@pass',
        'date' => '2022-01-26',
        'technologies'=>"['html,'css']"
      ]);
      $response->assertStatus(200);
    }

    public function testUserLogin()
    {
      $response = $this->call("POST","/UserLogin",[
        'Email'=>'user@gmail.com',
        'password'=>'pass@pass',
        'user_type'=>'0'
      ]);
      $response->assertStatus(200);

    }
}
