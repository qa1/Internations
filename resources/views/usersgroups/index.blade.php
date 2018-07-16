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
                <div class="card-header">Users and Groups List</div>
                <div class="card-body">
                    <div>
                        Username - Groups
                        <hr style="background-color:rgba(255,193,7,.5);">
                    </div>
                    @foreach ($users as $user)
                    <div>
                        <a href="{{ url('user-group/') }}/{{ $user->id }}">{{ $user->name }}</a> ->
                        @foreach( $user->groups as $group )
                        @if( App\Group::find($group->pivot->group_id) )
                        <span style="background-color: darkseagreen; padding: 5px; margin: 5px;">
                          {{ App\Group::find($group->pivot->group_id)->name }}
                        </span>
                        @endif
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
