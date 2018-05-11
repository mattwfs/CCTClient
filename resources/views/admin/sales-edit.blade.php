@extends('layouts.admin')
@section('main-content')
<h2>{{'Edit : '. $user->first_name.' '.$user->last_name}}</h2>
<a href="{{str_replace(url('/'), '', url()->previous())}}">Back to List</a>
<form method="post" action="{{url('admin/users/update')}}" class="form">

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

    <div class="modal-body">
        <div class="row form-group">
            <div class="col-md-3">
                First name
                <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" required/>
            </div>
            <div class="col-md-3">
                Last name
                <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" required/>
            </div>
            <div class="col-md-3">
                Email
                <input type="email" class="form-control" name="email" value="{{$user->email}}" required/>
            </div>
            <div class="col-md-3">
                Source
                <input type="source" class="form-control" name="source" value="{{$user->source}}"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                Role
                <select name="user_type" id="user_type" class="form-control">
                    <option value="" selected disabled>User type</option>
                    <option value="sales" @if($user->user_type == 'sales') selected @endif>Sales Representative</option>
                    <option value="sales_manager" @if($user->user_type == 'sales_manager') selected @endif>Sales Manager</option>
                </select>
            </div>
            <div class="col-md-3">
                Status
                <select name="is_active" class="form-control">
                    <option value="0" @if($user->is_active == 0) selected @endif>Inactive</option>
                    <option value="1" @if($user->is_active == 1) selected @endif>Active</option>
                </select>
            </div>
            <div class="col-md-3">
                Approved
                <select name="is_approved" class="form-control">
                    <option value="0" @if($user->is_approved == 0) selected @endif>Not approved</option>
                    <option value="1" @if($user->is_approved == 1) selected @endif>Approved</option>
                </select>
            </div>

        </div>

    <p>
        <label>
            <input type="checkbox" name="new_password" value="yes"/>
            Send a new password for this user
        </label>
    </p>

    <p>
        <a href="{{url('admin/users')}}" class="btn btn-default">Cancel</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </p>
    {!! csrf_field() !!}
    <input type="hidden" name="id" value="{{$user->id}}"/>
</form>
@endsection
@section('page_title')
{{'Edit : '. $user->first_name.' '.$user->last_name}}
@endsection