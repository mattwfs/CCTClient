@extends('layouts.admin')
@section('main-content')
<div class="row">
    <div class="col-lg-9">
        <a href="{{url('admin/applications')}}" class="btn btn-default">New Applications</a>
        <a href="{{url('admin/applications/processed')}}" class="btn btn-default active">Processed Applications</a>
        <a href="{{url('admin/applications/waitlist')}}" class="btn btn-default">Waitlist Applications</a>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" data-filter="table" data-target="#applications-table" placeholder="Filter Table"/>
    </div>
</div>

@if(! count($applications))
<p class="text-danger text-center"><em>There are no applications for this Trial</em></p>
@else
<p>
</p>
<table class="table table-bordered" id="applications-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Trial Title</th>
            <th>User Submitted</th>
            <th>Investigator</th>
            <th>Partner</th>
            <th>Status</th>
            <th style="width:200px">Note</th>
            <th>#</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($applications as $application)
        <tr class="{{$application->status}}">
            <td>{{ date("jS M Y",strtotime($application->created_at)) }}</td>
            <td>{{ $application->trial->title }}</td>
            <td>
                @if($application->user)
                {{ $application->user->first_name.' '.$application->user->last_name }}
                @endif
            </td>
            <td>
                @if($application->investigator)
                {{ $application->investigator->first_name.' '.$application->investigator->last_name }}</td>
                @endif
            <td>
            @if($application->user->is_partner)
                <i class="text-success fa fa-check"></i>
            @else
                <i class="text-danger fa fa-times"></i>
            @endif  
            </td>
            <td>{{ $application->status }}</td>
            <td>{{ $application->note }}</td>
            <td>
            <a href="{{url('admin/application/'.$application->id)}}" class="btn btn-default">
                <i class="fa fa-eye"></i>    
            </a>
                <a href="#" data-url="{{url('admin/application/delete')}}" class="btn btn-danger delete-admin-confirmation" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$application->id}}">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif
@include('partials.admin.admin_confirmation')
@endsection

@section('page_title')
Applications
@endsection