@extends('layouts.admin')
@section('main-content')
<h2>{{'Edit Specialization: '. $specialization->name}}</h2>
<form method="post" action="{{url('admin/specializations/update')}}" class="form">
        <div class="row">
          <div class="col-md-6">
                  @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              @if(Session::has('message'))
                  <div class="alert alert-success">
                      <p><strong>{{session('message')}}</strong></p>
                  </div>
              @endif
          </div>
        </div>
  
        <div class="row form-group">
          <div class="col-md-6">
            Name
            <input type="text" class="form-control" name="name" value="{{$specialization->name}}" required/>
          </div>
        </div>
        
        <div class="row form-group">
          <div class="col-md-6">
            Description
          <textarea class="form-control" name="description">{{$specialization->description}}</textarea>
          </div>
        </div>


        <div class="row form-group">
            <div class="col-md-6">
                Clinics<br/>
                <select style="width:100%;" class="select2-field form-control" name="clinics[]" multiple>
                    @foreach($clinics as $clinic)
                    <option value="{{$clinic->id}}"
                    @foreach($specialization->clinics as $u)
                    selected
                    @endforeach
                    >{{$clinic->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row form-group">
          <div class="col-md-6">
            Users<br/>
            <select style="width:100%;" class="select2-field form-control" name="users[]" multiple>
              @foreach($users as $user)
                <option value="{{$user->id}}"
                        @foreach($specialization->users as $u)
                          @if($user->id == $u->id)
                          selected
                          @endif
                        @endforeach
                        >{{$user->first_name}} ({{$user->email}})</option>
              @endforeach
            </select>
          </div>
        </div>
        <p>
          <a href="{{url('admin/specializations')}}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-primary">Update</button>
        </p>
  {!! csrf_field() !!}
  <input type="hidden" name="id" value="{{$specialization->id}}"/>
</form>
@endsection
@section('page_title')
{{'Edit : '. $specialization->name}}
@endsection