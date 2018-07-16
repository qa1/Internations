<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application group.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::where('name', '<>', 'admin')->paginate(10);

        return view('group.index', ['groups' => $groups]);
    }

    public function store(Request $request)
    {

      $user = new Group();
      $user->name = $request->group;
      $user->save();

      $request->session()->flash('status', 'The group created successfully!');

      return redirect("group");

    }

    public function destroy(Request $request, $id)
    {

      $group = Group::findOrFail($id);

      if ( $group->users()->exists() )
      {
          $request->session()->flash('faild', 'Sorry! The user already exists, Please remove user from group, first.');
      }
      else
      {
        $group->delete();

        $request->session()->flash('status', 'The Group deleted successfully!');
      }

      return redirect("group");

    }

    public function show()
    {
        return Group::find(1);
    }

}
