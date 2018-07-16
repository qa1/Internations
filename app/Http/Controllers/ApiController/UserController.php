<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use Validator;

class UserController extends \App\Http\Controllers\Controller
{

    /**
     * The user's list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Show the current user details
     *
     * @return App\Http\Resources\User
     */
    public function show($id)
    {
      return new UserResource(User::find($id));
    }

    /**
     * Create new user
     *
     * @return Json
     */
    public function store(Request $request)
    {
      try
      {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->is_admin = 0;
        $user->save();

        return response()->json([
          'status' => 'success',
          'description' => 'The User added to list successfully!'
        ]);
      }
      catch(Exception $e)
      {
        return response()->json([
          'status' => 'fail',
          'description' => 'The User does not added to list :('
        ]);
      }

      $request->session()->flash('status', 'The user created successfully!');
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
        $user = User::find($id);

        if( empty($user) )
        {
            return response()->json([
                                'status' => 'fail',
                                'message' => 'ResourceNotFound',
                                'description' => 'The User not found or deleted before.'
                              ])
                              ->setStatusCode(404);
        }

        $user->delete();

        return response()->json([
                           'status' => 'success',
                           'message' => 'DeleteUser',
                           'description' => 'The user deleted successfully!'
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
