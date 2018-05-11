@extends('layouts.wrapper')
@section('main-layout')

<!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="panel panel-primary">
          <div class="panel-heading"><i class="fa fa-lock"></i> Create a new password</div>
          <div class="panel-body">
           @include('partials.message-display')
          <form class="form" action="{{ url('reset-password') }}" method="post">
                        {!! csrf_field() !!}
          <input type="hidden" name="key" value="{{$reset_key}}" />
          <input type="hidden" name="update" value="{{$user_id}}" />
            <div class="form-group">
              <input type="password" name="password" placeholder="Password" class="form-control" required/>
            </div>
            
            <div class="form-group">
              <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control"/>
            </div>
            
            <p><button type="submit" class="btn btn-primary">Change password</button></p>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page_title')
Reset password
@endsection