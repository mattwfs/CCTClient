@extends('layouts.wrapper')
@section('main-layout')

<!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="panel panel-primary">
          <div class="panel-heading"><i class="fa fa-lock"></i> Create account</div>
          <div class="panel-body">
            @include('partials.message-display')
          <form class="form" action="{{url('register')}}" method="post">
                <span class="hidden"><input type="text" name="username" value=""/></span>
                {!! csrf_field() !!}
                
                <div class="row form-group">
                  <br/>
                  <p class="text-center text-info"><strong>Clinic information</strong></p>
                  <div class="col-md-3">
                      <input type="text" class="form-control" placeholder="Clinic Name" name="clinic_name" value="{{old('clinic_name')}}" required>
                  </div>
                  <div class="col-md-3">
                      <input type="text" class="form-control" placeholder="Clinic Phone" name="clinic_phone" value="{{old('clinic_phone')}}" required>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-3">
                      <input type="text" class="form-control" placeholder="Clinic Address" name="clinic_address" value="{{old('clinic_address')}}" required>
                  </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="clinic_city" placeholder="Clinic City" value="{{old('clinic_city')}}" required/>
                    </div>
                    <div class="col-md-3">
                        <select id="states" class="form-control select2-field" name="clinic_state" required>
                            <option selected disabled>Select Clinic State</option>
                            <?php
                            $states = get_states();
                            foreach($states as $code => $name):
                                echo '<option value="'.$code.'">'.$name.'</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="clinic_postcode" placeholder="Clinic Zip Code" required/>
                    </div>
                </div>
            
                <div class="row form-group">
                  <br/>
                  <p class="text-center text-info"><strong>User information</strong></p>
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
                      <button class="btn btn-primary btn-block" type="submit">Create account</button>
                  </div>
                </div>
        </form>
            <br/>
            <p class="text-right">
              <a href="{{url('login')}}">Login</a> | 
              <a href="{{url('sales-rep/register')}}">Register as Sales representative</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page_title')
Create account
@endsection