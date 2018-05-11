@extends('layouts.users')
@section('main-content')
<p>You have submitted <strong class="text-danger">{{count($applications)}}</strong> applications in total.</p>
<table class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Protocol Number & Title</th>
     <th>Investigator</th>
     <th>Note</th>
     <th>Status</th>
     <th style="width:50px;"></th>
   </tr>
 </thead>
  <tbody>
    @foreach($applications as $application)
    <tr>
      <td>
        <i class="fa fa-calendar text-danger"></i> 
        <small>
          <em>
            {{date("jS M, Y",strtotime($application->created_at))}}
          </em>
        </small>
      </td>
      <td>
        {{ $application->trial->title }}
        @if($application->trial->deleted_at)
          <em class="text-danger">
            ( Deleted )
          </em>
        @endif
      </td>
      <td>
          @if($application->investigator)
          {{ ucfirst($application->investigator->first_name) }} {{ ucfirst($application->investigator->last_name) }}
          @else
          {{ ucfirst(auth()->user()->first_name) }} {{ ucfirst(auth()->user()->last_name) }}
          @endif
      </td>
      <td><small><em>{{$application->note}}</em></small></td>
      <td>
            @if($application->status == 'accepted' || $application->status == 'selected')
            <span class="label label-success">Awarded Study</span>
        
            @elseif($application->status == 'rejected')
            <span class="label label-danger">Declined</span>
        
            @elseif($application->status == 'pending_sponsor_approval')
            <span class="label label-warning">Pending Sponsor Approval</span>
        
            @elseif($application->status == 'sponsor_declined')
            <span class="label label-danger">Sponsor Declined</span>
        
            @elseif($application->status == 'md_declined')
            <span class="label label-danger">MD Declined</span>
        
            @elseif($application->status == 'delayed')
            <span class="label label-warning">Delayed</span>
        
            @elseif($application->status == 'new')
            <span class="label label-info">Applied</span>
            @else
            <span class="label label-info">{{$application->status}}</span>
            @endif
      </td>
      <td>
        <a target="_blank" href="{{ url('user/application/'.$application->id.'/download') }}" class="btn btn-default" title="Download my application">
          <i class="fa fa-download" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{!! $applications->links() !!}
@endsection

@section('page_title')
 My Applications
@endsection