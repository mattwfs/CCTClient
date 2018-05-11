@extends('layouts.wrapper')
@section('main-layout')

<!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="panel panel-primary">
          <div class="panel-heading"><i class="fa fa-lock"></i> Forgot password</div>
          <div class="panel-body">
            
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success">
                <strong>{{ session('message') }}</strong>
            </div>
        @endif
            
          <form class="form" action="{{ url('forgot-password') }}" method="post">
                        {!! csrf_field() !!}
            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="Email address" value="{{old('email')}}" required/>
            </div>
            <p>
              <button type="submit" class="btn btn-primary">Send me a password reset link</button>
            </p>           
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page_title')
Forgot password
@endsection