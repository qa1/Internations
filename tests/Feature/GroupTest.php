<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Group;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GroupTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * The group test example.
     *
     * @return void
     */
    public function testGroupList()
    {
      Group::where('name', 'test')->delete();

      $response = $this->call('GET', '/api/group');

      // Assert user list
      $response->assertJsonStructure( [
                                        'data' => [
                                          '*' => [
                                            'id',
                                            'name',
                                            'users' => [ '*' => [
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
     * Add new Group to API
     *
     * @return void
     */
    public function testGroupAdd()
    {
      Group::where('name', 'test')->delete();

      $response = $this->call('POST', '/api/group', [
                                                      'name' => 'test'
                                                    ]);

      // Assert the User insertion action
      $response->assertJson( [
                              "status" => "success",
                              "description" => "The group added to list successfully!"
                            ]);

      $this->assertEquals(200, $response->status());

      $response = $this->call('POST', '/api/group', [
                                                    'name' => 'test'
                                                   ]);

      // Assert the douplicated insertion action
      $response->assertJson( [
                              "error" => [ "name" => [ "The name has already been taken." ] ]
                            ]);

      $this->assertEquals(401, $response->status());
    }

    /**
     * Delete a user from API
     *
     * @return void
     */
    public function testGroupDeletetion()
    {
      Group::where('name', 'test')->delete();

      $group = new Group();
      $group->name = 'test';
      $group->save();

      // Assert User deletion
      $response = $this->call('Delete', "/api/group/$group->id");

      $response->assertJson([
        "status" => "success",
        "message" => "DeleteGroup",
        "description" => "The group deleted successfully!"
      ]);

      $this->assertEquals(200, $response->status());

      // Assert not found deletion
      $response = $this->call('Delete', "/api/group/$group->id");

      $response->assertJson([
        "status" => "fail",
        "message" => "ResourceNotFound",
        "description" => "The group not found or deleted before."
      ]);

      $this->assertEquals(404, $response->status());
    }

    /**
     * Delete a group from API
     *
     * @return void
     */
    public function testGetGroup()
    {
      Group::where('name', 'test')->delete();

      $group = new Group();
      $group->name = 'test';
      $group->save();

      $group = Group::where('name', 'test')->first();

      // Assert show user section
      $response = $this->call('GET', "/api/group/$group->id");

      $response->assertJson([
                              'data' => [
                                  'id' => $group->id,
                                  'name' => 'test'
                                ]
                            ]);

      $this->assertEquals(200, $response->status());
    }
}
