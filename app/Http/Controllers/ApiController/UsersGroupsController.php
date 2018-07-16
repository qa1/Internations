<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\UserGroup;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UsersGroups as UsersGroupsResource;
use App\Http\Resources\Group as GroupResource;

class UsersGroupsController extends \App\Http\Controllers\Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => UserGroup::all()]);
    }

    /**
     * Show current user info
     *
     * @param  Integer $id
     * @return
     */
    public function show($id)
    {

      return response()->json(['data' => UserGroup::find($id) ]);

    }

    /**
     * remove the current user details
     *
     * @return App\Http\Resources\User
     */
    public function destroy($id)
    {

      try
      {
        $user_group = UserGroup::find($id);

        if( empty($user_group) )
        {
            return response()->json([
                                'status' => 'fail',
                                'message' => 'ResourceNotFound',
                                'description' => 'The User and Group relation not found or deleted before.'
                              ])
                              ->setStatusCode(404);
        }

        $user_group->delete();

        return response()->json([
                           'status' => 'success',
                           'message' => 'AddNewRelation',
                           'description' => 'The user and group relation deleted successfully!'
                         ])
                         ->setStatusCode(200);
      }
      catch(Exception $e)
      {
        return response()->json([
                           'status' => 'fail',
                           'message' => 'InternalError',
                           'description' => 'The server encountered an internal error. Please retry the request.'
                         ])
                         ->setStatusCode(500);
      }

    }

}
