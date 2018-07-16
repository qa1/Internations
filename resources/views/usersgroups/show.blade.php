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
                <div class="card-header">User Group</div>

                <form action="/user/attach" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="user" class="col-sm-3 control-label">Attach User to Group:</label>

                        <div class="col-sm-6">
                            <input name="user_id" type="hidden" value="{{ $user->id }}">
                            <select name="group_id" class="form-control">
                              @foreach($groups as $group)
                              <option value="{{ $group->id }}">{{ $group->name }}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default" style="background-color: lightseagreen;">
                                <i class="fa fa-plus"></i> Attach to Group
                            </button>
                        </div>
                    </div>
                </form>
                <div class="card-body">

                    <div>
                    </div>
                    @foreach ($user->groups as $group)
                    <div>
                        @if( App\Group::find($group->pivot->group_id) )
                        {{ App\Group::find($group->pivot->group_id)->name }}
                        <form action="/user/{{ $user->id }}/detach/{{ $group->pivot->group_id }}" method="POST" style="margin:0px; padding:0px">
                          {{ csrf_field() }}
                          <button type="submit" class="btn" style="background-color:rgba(220,53,69,.5); float: right; margin: -30px 5px">
                              <i class="fa fa-plus"></i> Delete
                          </button>
                        </form>
                        <hr style="background-color:rgba(255,193,7,.5);">
                        @else
                        This user is not joined to any group
                        @endif
                    </div>
                    @endforeach
                </div>
                <div style="margin-left:34%">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
