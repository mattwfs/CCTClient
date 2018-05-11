@extends('layouts.admin')
@section('main-content')
<div class="panel panel-primary">
  <div class="panel-heading">Sales Representatives</div>
  <div class="panel-body">
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>Joined on</th>
            <th>Name</th>
            <th>Email</th>
            <th>Clinics</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{$user->created_at}}</td>
            <td>{{$user->first_name}} {{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            <td><span class="label label-default">{{count($user->clinics)}}</span></td>
            <td><a href="{{url('admin/sales-rep/'.$user->id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
          </tr>
          @endforeach
        </tbody>
    </table>

  </div>
</div>
            @endsection
@section('page_title')
Sales Representatives
@endsection