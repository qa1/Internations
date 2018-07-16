@extends('layouts.app')
<style type="text/css">
.delete-group{
  background-color:rgba(0,123,255,.5);;
}
.delete-group:hover{
  background-color: rgba(220,53,69,.5);
}
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User List</div>

                <form action="{{ url('user') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="user" class="col-sm-3 control-label">Username:</label>

                        <div class="col-sm-6">
                            <input type="text" name="username" class="form-control">
                        </div>

                        <label for="email" class="col-sm-3 control-label">Email:</label>

                        <div class="col-sm-6">
                            <input type="text" name="email" class="form-control">
                        </div>

                        <label for="password" class="col-sm-3 control-label">Password:</label>

                        <div class="col-sm-6">
                            <input type="password" name="password"  class="form-control">
                        </div>
                    </div>

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default" style="background-color: lightseagreen;">
                                <i class="fa fa-plus"></i> New User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
