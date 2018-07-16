<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserList()
    {
        User::where('email', 'test@test.com')->delete();
        
        $user = new User();
        $user->email = 'test@test.com';
        $user->name = 'test';
        $user->password = bcrypt('123456');
        $user->is_admin = 0;
        $user->save();

        $response = $this->call('GET', '/api/user');

        // Assert user list
        $response->assertJsonStructure( [
                                          'data' => [
                                            '*' => [
                                              'id',
                                              'name',
                                              'email',
                                              'groups' => [ '*' => [
                                                'id',
                                                'name',
                                                'created_at',
                                                'updated_at'
                                              ]
                                            ]
                                          ]]]);

        $this->assertEquals(200, $response->status());

    }

    /**
     * Add new user to API
     *
     * @return void
     */
    public function testUserAdd()
    {
      User::where('email', 'test@test.com')->delete();

      $response = $this->call('POST', '/api/user', ['email' => 'test@test.com',
                                                    'name' => 'test',
                                                    'password' => '123456',
                                                    'is_admin' => 0]);

      // Assert the User insertion action
      $response->assertJson( [
                              "status" => "success",
                              "description" => "The User added to list successfully!"
                            ]);

      $this->assertEquals(200, $response->status());

      $response = $this->call('POST', '/api/user', ['email' => 'test@test.com',
                                                    'name' => 'test',
                                                    'password' => '123456',
                                                    'is_admin' => 0]);

      // Assert the douplicated insertion action
      $response->assertJson( [
                              "error" => [ "email" => [ "The email has already been taken." ] ]
                            ]);

      $this->assertEquals(401, $response->status());
    }

    /**
     * Delete a user from API
     *
     * @return void
     */
    public function testUserDeletetion()
    {
      User::where('email', 'test@test.com')->delete();

      $user = new User();
      $user->email = 'test@test.com';
      $user->name = 'test';
      $user->password = bcrypt('123456');
      $user->is_admin = 0;
      $user->save();

      // Assert User deletion
      $response = $this->call('Delete', "/api/user/$user->id");

      $response->assertJson([
        "status" => "success",
        "message" => "DeleteUser",
        "description" => "The user deleted successfully!"
      ]);

      $this->assertEquals(200, $response->status());

      // Assert not found deletion
      $response = $this->call('Delete', "/api/user/$user->id");

      $response->assertJson([
        "status" => "fail",
        "message" => "ResourceNotFound",
        "description" => "The User not found or deleted before."
      ]);

      $this->assertEquals(404, $response->status());
    }

    /**
     * Delete a user from API
     *
     * @return void
     */
    public function testGetUser()
    {

      User::where('email', 'test@test.com')->delete();

      $user = new User();
      $user->email = 'test@test.com';
      $user->name = 'test';
      $user->password = bcrypt('123456');
      $user->is_admin = 0;
      $user->save();

      // Assert show user section
      $response = $this->call('GET', "/api/user/$user->id");

      $response->assertJson([
                              'data' => [
                                  'name' => 'test',
                                  'email' => 'test@test.com',
                                ]
                            ]);

      $this->assertEquals(200, $response->status());
    }
}
