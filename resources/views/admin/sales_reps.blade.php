@extends('layouts.admin')
@section('main-content')
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <input type="text" class="form-control" data-filter="table" data-target="#sales-reps-table" placeholder="Filter Table"/>
    </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Sales Representatives</div>
  <div class="panel-body">
    <table id="sales-reps-table" class="table table-bordered">
        <thead>
          <tr>
            <th>Joined on</th>
            <th>Name</th>
            <th>Email</th>
            <th>Clinics</th>
              <th>Approved</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @foreach($users as $user)
          <tr
          @if(!$user->is_active)
          style="color:red;"
          @endif
          >
            <td>{{$user->created_at}}</td>
            <td>{{$user->first_name}} {{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            <td><span class="label label-default">{{count($user->clinics)}}</span></td>
          <td>@if($user->is_approved==1)
              <span class="fa fa-check text-success"></span> Approved
              @elseif($user->is_approved==0)
              <span class="fa fa-exclamation text-danger"></span> Not Approved
              @endif</td>
            <td><a class="btn btn-default" href="{{url('admin/sales-rep/edit/'.$user->id)}}"><i class="fa fa-pencil"></i></a> <a href="{{url('admin/sales-rep/'.$user->id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                <a class="btn btn-danger delete-admin-confirmation" href="#" data-url="{{url('admin/user/delete')}}" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$user->id}}"><i class="fa fa-trash"></i></a></td>
          </tr>
          @endforeach
        </tbody>
    </table>

  </div>
</div>

<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <input type="text" class="form-control" data-filter="table" data-target="#sales-managers-table" placeholder="Filter Table"/>
    </div>
</div>

<div class="panel panel-primary">
            <div class="panel-heading">Sales Managers</div>
    <div class="panel-body">
        <table id="sales-managers-table" class="table table-bordered">
            <thead>
            <tr>
                <th>Joined on</th>
                <th>Name</th>
                <th>Email</th>
                <th>Sales Reps</th>
                <th>Approved</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($users_managers as $user)
            <tr>
                <td>{{$user->created_at}}</td>
                <td>{{$user->first_name}} {{$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user->is_approved==1)
                <span class="fa fa-check text-success"></span> Approved
                @elseif($user->is_approved==0)
                <span class="fa fa-exclamation text-danger"></span> Not Approved
                @endif
                </td>
                <td><span class="label label-default">{{count($user->sales_reps)}}</span></td>
                <td><a class="btn btn-default" href="{{url('admin/sales-rep/edit/'.$user->id)}}"><i class="fa fa-pencil"></i></a> <a href="{{url('admin/sales-manager/'.$user->id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-danger delete-admin-confirmation" href="#" data-url="{{url('admin/user/delete')}}" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$user->id}}"><i class="fa fa-trash"></i></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>

    </div></div>

@include('partials.admin.admin_confirmation')
            @endsection
@section('page_title')
Sales Representatives
@endsection