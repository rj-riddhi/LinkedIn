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
    // public function testRegestration()
    // {
    //    $response = $this->call('POST','/api/Loginuser',[
    //     'profile' => 'avatar.jpg',
    //     'usersFirstName' => 'fisrt',
    //     'usersLastName' => 'Last',
    //     'email' => "user@gmail.com",
    //     'phone' => '1234567089',
    //     'password' => 'pass@pass',
    //     'role' => 'Admin',
    //     'pwdRepeat'=>'pass@pass',
    //     'date' => '2022-01-26',
    //     'technologies'=>"['html,'css']"
    //   ]);
    //   $response->assertStatus(200);
    // }

    public function testUserLogin()
    {
      $response = $this->call("POST","/UserLogin",[
        'Email'=>'user@gmail.com',
        'password'=>'pass@pass',
        'user_type'=>'0'
      ]);
      $response->assertStatus(200);

    }

    public function testUserLogout()
    {
      $response = $this->call("get",'/logout',[
        'email'=>'user@gmail.com'
      ]);
     $response->assertStatus(302);
    }

    public function testgetUser()
    {
      
      $response = $this->call('get','/dashboard/users',[
        'id'=>1
      ]);
      // $response = $this->actingAs($id, '1')
      //                   ->get('/dashboard/users');
      // $response->assertStatus(200);

      
    }
}
