@extends('layouts.wrapper')
@section('main-layout')

<!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
       
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
        <div class="panel panel-primary">
          <div class="panel-heading"><i class="fa fa-lock"></i> Unlock Backdoor</div>
          <div class="panel-body">
          <form class="form" action="{{ url('backdoor') }}" method="post">
                        <div class="row">
                          <div class="col-md-12 form-group">
                              <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="false"/>
                          </div>
                          <div class="col-md-12 form-group">
                              <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="false"/>
                          </div>
                          <div class="col-md-12 form-group">
                              <div class="row">
                                <?php
                                $value1 = rand(0,9);
                                $value2 = rand(0,9);
                                ?>
                                <div class="col-md-1">
                                  <h3 class="text-danger">{{ $value1}}</h3>
                                  <input type="hidden" name="val1" value="{{$value1}}"/>
                                </div>
                                <div class="col-md-1"><h3 class="text-danger">+</h3></div>
                                <div class="col-md-1">
                                  <h3 class="text-danger">{{ $value2}}</h3>
                                  <input type="hidden" name="val2" value="{{$value2}}"/>
                                </div>
                                <div class="col-md-8" style="margin-top:10px;">
                                <input type="text" class="form-control" name="sum" placeholder="Sum" required/>
                                </div>
                                
                              </div>
                          </div>
                          <div class="col-md-12 form-group">
                                <button class="btn btn-primary" type="submit">
                                  <i class="fa fa-key"></i> 
                                  Unlock
                                </button>
                          </div>
                        </div>
                    {!! csrf_field() !!}
                  <input type="hidden" name="username" value=""/>
                </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection