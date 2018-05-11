@extends('layouts.users')
@section('main-content')
<table class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Protocol Number & Title</th>
     <th>Status</th>
     <th>Notes</th>
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
      <td>{{ $application->trial->title }}</td>
      <td>
            @if($application->status == 'accepted' || $application->status == 'selected')
            <span class="label label-success">Awarded Study</span>
        
            @elseif($application->status == 'rejected')
            <span class="label label-danger">Rejected</span>
        
            @elseif($application->status == 'pending_sponsor_approval')
            <span class="label label-warning">Pending Sponsor Approval</span>
        
            @elseif($application->status == 'sponsor_declined')
            <span class="label label-danger">Sponsor Declined</span>
        
            @elseif($application->status == 'MD_Declined')
            <span class="label label-danger">MD Declined</span>
        
            @elseif($application->status == 'delayed')
            <span class="label label-warning">Delayed</span>
        
            @elseif($application->status == 'review')
            <span class="label label-warning">Under review</span>
        
            @elseif($application->status == 'new')
            <span class="label label-info">Applied</span>
            @endif
      </td>
      <td>{{ $application->note }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
{!! $applications->links() !!}
@endsection

@section('page_title')
Applications By Referred Account
@endsection