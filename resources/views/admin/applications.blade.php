@extends('layouts.admin')
@section('main-content')
<h4 class="text-primary">Applications for : {{$trial->title}}</h4>
<hr/>
@if(! count($applications))
<p class="text-danger text-center"><em>There are no applications for this Trial</em></p>
@else
<table class="table table-bordered table-striped">
    <thead>
        <tr style="background:#337ab7;">
            <th>Application Date</th>
            <th>User</th>
            <th>Partner</th>
            <th>Status</th>
            <th>Notes</th>
            <th>#</th>
        </tr>
    </thead>
    
    <tbody>
    @foreach($applications as $application)
        <tr class="{{$application->status}}">
            <td>{{ $application->created_at }}</td>
            <td>{{ $application->user->first_name.' '.$application->user->last_name }}</td>
            <td>
            @if($application->user->is_partner)
                <i class="text-success fa fa-check"></i>
            @else
                <i class="text-danger fa fa-times"></i>
            @endif  
            </td>
            <td>
                {{$application->status}}
            </td>
            <td>
                {{$application->note}}
            </td>
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