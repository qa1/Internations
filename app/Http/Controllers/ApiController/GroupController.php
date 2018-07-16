<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Group as GroupResource;
use Validator;

class GroupController extends \App\Http\Controllers\Controller
{

    /**
     * The group's list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GroupResource::collection(Group::all());
    }

    /**
     * Show the current group details
     *
     * @return App\Http\Resources\Group
     */
    public function show($id)
    {
      return new GroupResource(Group::find($id));
    }

    /**
     * Create new group
     *
     * @return Json
     */
    public function store(Request $request)
    {
      try
      {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:groups'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $group = new Group();
        $group->name = $request->name;
        $group->save();

        return response()->json([
          'status' => 'success',
          'description' => 'The group added to list successfully!'
        ]);
      }
      catch(Exception $e)
      {
        return response()->json([
          'status' => 'fail',
          'description' => 'The group does not added to list :('
        ]);
      }

      $request->session()->flash('status', 'The group created successfully!');
    }

    /**
     * remove the current group details
     *
     * @return App\Http\Resources\Group
     */
    public function destroy($id)
    {

      try
      {
        $group = Group::find($id);

        if( empty($group) )
        {
            return response()->json([
                                'status' => 'fail',
                                'message' => 'ResourceNotFound',
                                'description' => 'The group not found or deleted before.'
                              ])
                              ->setStatusCode(404);
        }

        if ( $group->users()->exists() )
        {
          return response()->json([
                              'status' => 'fail',
                              'message' => 'ResourceNotFound',
                              'description' => 'Sorry! The group is not empty, Please remove user from group, first.'
                            ])
                            ->setStatusCode(301);
        }

        $group->delete();

        return response()->json([
                           'status' => 'success',
                           'message' => 'DeleteGroup',
                           'description' => 'The group deleted successfully!'
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
