@extends('layouts.wrapper')
@section('main-layout')

<!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="panel panel-primary">
          <div class="panel-heading"><i class="fa fa-lock"></i> Login</div>
          <div class="panel-body">
            @include('partials.message-display')
          <form class="form" action="{{ url('login') }}" method="post">
                        {!! csrf_field() !!}
                  <span class="hidden"><input type="text" name="username" value=""/></span>
                        <div class="row">
                          <div class="col-md-12 form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="Email" name="user_email" required/>
                              </div>
                          </div>
                          <div class="col-md-12 form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="Password" name="user_password" required/>
                              </div>
                          </div>
                          <div class="col-md-12 form-group">
                              <button class="btn btn-primary btn-block" type="submit">Log me in</button>
                          </div>
                        </div>
                </form>
            <p><a href="{{url('forgot-password')}}">Forgot password ?</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page_title')
Member Login
@endsection