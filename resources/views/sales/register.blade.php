@extends('layouts.wrapper')
@section('main-layout')

<!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="panel panel-primary">
          <div class="panel-heading"><i class="fa fa-lock"></i> Register as sales representative</div>
          <div class="panel-body">
            @include('partials.message-display')
          <form class="form" action="{{url('sales-rep/register')}}" method="post">
                <span class="hidden"><input type="text" name="username" value=""/></span>
                {!! csrf_field() !!}
                
               
            
                <div class="row form-group">
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="First name" name="first_name" value="{{old('first_name')}}" required>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Last name" name="last_name" value="{{old('last_name')}}" required>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}" required>
                      </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password" required>
                      </div>
                  </div>
                    <div class="col-md-4">
                        <div class="input-group">

                            I am a:
                            <select name="role_id">
                                <option value="{{ get_role_id('sales_rep')}}">Sales representative</option>
                                <option value="{{ get_role_id('sales_manager')}}">Sales manager</option>
                            </select>
                 <br/><br/>
                      <button class="btn btn-primary btn-block" type="submit">Create account</button>
                  </div>
                </div>
        </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page_title')
Register as sales represntative
@endsection