<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

        $groups = Group::all();

        return view('user.index', ['users' => $users, 'groups' => $groups]);
    }

    public function create()
    {

      return view('user.create');

    }

    public function destroy(Request $request, $id)
    {

      $user = User::findOrFail($id);

      $user->delete();

      $request->session()->flash('status', 'The User deleted successfully!');

      return redirect("user");

    }

    public function store(Request $request)
    {

      $user = new User();
      $user->name = $request->username;
      $user->password = Hash::make($request->password);
      $user->email = $request->email;
      $user->is_admin = 0;
      $user->save();

      $request->session()->flash('status', 'The user created successfully!');

      return redirect("user");

    }

}
