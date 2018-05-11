@extends('layouts.wrapper')
@section('main-layout')

<!--start of .banner-->

 
 
 <!--start #main-content-->
<div class="main-content pad text-center">
  <div class="container welcome-container">
    
    <h3>You were referred to www.cctclient.com by your friend {{ucfirst($referral->user->first_name)}} {{ucfirst($referral->user->last_name)}}</h3>
    <p>Please create your account to apply for study.</p>
    <div class="clearfix"><br/><br/></div>
    @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                <strong>{{ session()->get('success') }}</strong>
            </div>
        @endif
    <form  class="form"action="{{url('referral/register')}}" method="post">
        <input type="hidden" name="referral_id" value="{{$referral->id}}"/>
                {!! csrf_field() !!}
                <div class="row form-group">
                  <br/>
                  <p class="text-center text-info"><strong>Clinic information</strong></p>
                  <div class="col-md-3">
                      <input type="text" class="form-control" placeholder="Clinic name" name="clinic_name" value="{{old('clinic_name')}}" required>
                  </div>
                  <div class="col-md-3">
                      <input type="text" class="form-control" placeholder="Clinic Phone" name="clinic_phone" value="{{old('clinic_phone')}}" required>
                  </div>
                  <div class="col-md-3">
                      <input type="text" class="form-control" placeholder="Clinic Address" name="clinic_address" value="{{old('clinic_address')}}" required>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="First name" name="first_name" value="{{old('first_name')}}"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Last name" name="last_name" value="{{old('last_name')}}"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{$referral->email}}" readonly/>
                      </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <button class="btn btn-primary btn-block" type="submit">Create account</button>
                  </div>
                </div>
        </form>
   
  </div>
</div>
 <!--end #main-content-->

@endsection