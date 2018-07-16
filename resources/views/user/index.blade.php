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
                <div class="card-body">

                  <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-6">
                          <a href="{{ url('user/create') }}" class="btn btn-default" style="background-color: lightseagreen; color:black;">
                              <i class="fa fa-plus"></i> New User
                          </a>
                      </div>
                  </div>
                    <hr>
                    @foreach ($users as $user)
                    <div>
                        <span>{{ $user->name }}</span>
                        <form action="/user/{{$user->id}}" method="POST">
                        <input name="_method" type="hidden" value="DELETE">
                          <button type="submit" class="btn" style="background-color:rgba(220,53,69,.5); float: right; margin: -30px 5px">
                              <i class="fa fa-plus"></i> Delete
                          </button>
                          {{ csrf_field() }}
                        </form>
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
