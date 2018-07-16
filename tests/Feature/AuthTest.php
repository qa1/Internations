<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuthTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * The token registration test example.
     *
     * @return void
     */
    public function testTokenRegistration()
    {

      User::where('email', 'test@test.com')->delete();

      $response = $this->post('/api/register', ['email' => 'test@test.com', 'name' => 'test', 'password' => '123456', 'is_admin' => 0]);

      $this->assertEquals(200, $response->status());

      User::where('email', 'test@test.com')->delete();

      $response = $this->post('/api/register', ['email' => 'test@test.com', 'name' => 'test', 'password' => '123456', 'is_admin' => 0]);

      // Assert the JSON structure of successfull action.
      $response->assertJsonStructure( [
                                        'status',
                                        'token'
                                        ]);


      $response = $this->post('/api/register', ['email' => 'test@test.com', 'name' => 'test', 'password' => '123456', 'is_admin' => 0]);

      // Assert if user is douplicated
      $this->assertEquals(401, $response->status());

      $response->assertJsonStructure( [
                                        'error' => [ 'email' ]
                                      ]);


    }
}
