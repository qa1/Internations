<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;

class UsersGroupsController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_admin', '<>', '1')->paginate(10);

        return view('usersgroups.index', ['users' => $users]);
    }

    public function show($id)
    {

      $user = User::find($id);

      $groups = Group::get();

      return View('usersgroups.show', ['user' => $user, 'groups' => $groups]);

    }

    public function destroy(Request $request, $user_id, $group_id)
    {

      $user = User::find($user_id)->groups()->detach($group_id);

      $users = User::where('is_admin', '<>', '1')->paginate(10);

      $request->session()->flash('status', 'The Group dettached successfully!');

      return redirect("user-group/$user_id");
    }

    public function store(Request $request)
    {

      $user_id = $request->input('user_id');

      $group_id = $request->input('group_id');

      if( User::find($user_id)->groups()->where('group_id', $group_id)->exists() )
      {
        $request->session()->flash('faild', 'This user already added to this group! nothing to update. :(');
      }
      else
      {
        $user = User::find($user_id)->groups()->attach($group_id);

        $request->session()->flash('status', 'The Group attached successfully!');
      }

      return redirect("user-group/$user_id");

    }

}
