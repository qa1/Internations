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
                <div class="card-header">Group List</div>

                <form action="{{ url('group') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="user" class="col-sm-3 control-label">Create new simple Group:</label>

                        <div class="col-sm-6">
                            <input type="text" name="group" class="form-control">
                        </div>
                    </div>

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default" style="background-color: lightseagreen;">
                                <i class="fa fa-plus"></i> Create Group
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="card-body">
                    @foreach ($groups as $group)
                    <div>
                          <span>{{ $group->name }}</span> - <span style="color:gray">{{ $group->users()->count() }} Users</span>
                          <form action="/group/{{$group->id}}" method="POST">
                          <div>
                          <input name="_method" type="hidden" value="DELETE">
                          {{ csrf_field() }}
                          @if( $group->users()->where('group_id', $group->id)->exists() )
                          <button type="submit" class="btn" style="background-color:rgba(171, 171, 171, 0.5); float: right; margin: -30px 5px">
                              <i class="fa fa-plus"></i> Delete
                          </button>
                          @else
                          <button type="submit" class="btn" style="background-color:rgba(220,53,69,.5); float: right; margin: -30px 5px">
                              <i class="fa fa-plus"></i> Delete
                          </button>
                          @endif
                          </div>
                          </form>
                        <hr style="background-color:rgba(255,193,7,.5);">
                    </div>
                    @endforeach
                </div>
                <div style="margin-left:34%">
                  {{ $groups->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
