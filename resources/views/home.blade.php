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
                        <label for="user" class="col-sm-3 control-label">Create new simple user:</label>

                        <div class="col-sm-6">
                            <input type="text" name="user" id="user-name" class="form-control">
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
                <hr>

                <div class="card-body">

                    @foreach ($users as $user)
                    <div>
                        {{ $user->name }}
                          <button type="submit" class="btn" style="background-color:rgba(220,53,69,.5); float: right; margin: 0px 5px">
                              <i class="fa fa-plus"></i> Delete
                          </button>
                          <button type="submit" class="btn" style="background-color:rgba(40,167,69,.5); float: right; margin: 0px 5px">
                              <i class="fa fa-plus"></i> Add to group
                          </button>
                          <select style="float:right">
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                          </select>
                          @if( ! empty($user->groups) )
                          <br>
                          Groups:
                          @endif
                          @foreach($user->groups as $group)
                          <button type="submit" class="btn delete-group">
                              <i class="fa fa-plus"></i> <span>{{ App\Group::find($group->pivot->group_id)->name }}</span>
                          </button>
                          @endforeach
                        <hr style="background-color:rgba(255,193,7,.5);">
                    </div>
                    @endforeach
                </div>
                <div style="margin-left:34%">
                  {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
