@extends('layouts.admin')
@section('main-content')

<div class="panel panel-primary">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-9">All Users</div>
            <div class="col-md-3">
                <input type="text" class="form-control" data-filter="table" data-target="#users-table" placeholder="Filter Table"/>
            </div>
        </div>
    </div>

    <div class="panel-body">

        <table id="users-table" class="table table-bordered table-striped">
            <thead class="background-primary">
            <tr>
                <th>User Name</th>
                <th>Clinic</th>
                <th>Email</th>
                <th>Partner</th>
                <th>Specializations</th>
                <th>Approved</th>

                <th style="width:190px;">#</th>
            </tr>
            </thead>


            <tbody>
            @if($users->isEmpty())
            <tr><td colspan="6">No users for this clinic</td></tr>
            @else
            @foreach($users as $user)
            <tr style="background-color:#fff">
                <td>
                    {{$user->first_name}} {{$user->last_name}}
                    @if($user->is_primary_contact)
                    <sup><small class="text-danger">Primary contact</small></sup>
                    @endif
                </td>
                <td>@if(!empty($user->clinic))
                    {{$user->clinic->name }}
                    @endif
                </td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user->is_partner==1)
                    <span class="fa fa-check text-success"></span> Partner
                    @elseif($user->is_partner==2)
                    <span class="fa fa-check text-success"></span> Special
                    @endif
                </td>
                <td>
                    @foreach($user->specializations as $specialization)
                    <span style="margin-bottom:2px;display:inline-block;" class="label label-default">{{$specialization->name}}</span>&nbsp;&nbsp;
                    @endforeach
                </td>
                <td>
                    @if(empty($user->clinic) || $user->clinic->is_approved==0)
                    <span class="fa fa-exclamation text-danger"></span> Site Not Approved
                    <br/>
                    @endif

                    @if($user->is_approved==1)
                    <span class="fa fa-check text-success"></span> Approved
                    @elseif($user->is_approved==0)
                    <span class="fa fa-exclamation text-danger"></span> Not Approved
                    @endif
                </td>
                <td>
                    <a class="modal-crud-edit btn btn-default" href="{{url('admin/users/'.$user->id)}}"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-primary" href="{{url('admin/message/'.$user->id)}}"><i class="fa fa-envelope"></i></a>
                    <a class="btn btn-info" href="{{url('admin/user/'.$user->id)}}"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-danger delete-admin-confirmation" href="#" data-url="{{url('admin/user/delete')}}" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$user->id}}"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
            @endif
            </tbody>

        </table>
    </div>
</div>
@include('partials.admin.admin_confirmation')
@endsection
@section('page_title')
Users list
@endsection