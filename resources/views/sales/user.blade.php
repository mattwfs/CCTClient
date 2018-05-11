@extends('layouts.sales')
@section('main-content')

<div class="row">
  <div class="col-md-6">
    
    <div class="panel panel-success">
      <div class="panel-body">
        <h3>
          {{ ucwords($user->first_name.' '.$user->last_name) }}</h3>
        <p><strong class="text-danger">{{ $user->practise_name }}</strong></p>
        <p>
          <i class="fa fa-envelope"></i> 
          <small>{{ $user->email }}</small>
        </p>
        <p>
          <i class="fa fa-phone"></i> 
          <small>{{ $user->clinic->phone }}</small>
        </p>
        <p>
          <i class="fa fa-map-marker"></i> 
          <small>
          {{ $user->clinic->address.', '.$user->clinic->city }} {{ $user->clinic->state.' '.$user->clinic->postcode }}
          </small>
        </p>
        <p>
          <i class="fa fa-calendar"></i> 
          <small class="text-primary">
            Member since : {{ date("jS M, Y",strtotime($user->created_at)) }}
          </small>
        </p>
      </div>
    </div>
  </div>
  
  <div class="col-md-6">
    
    <div class="panel panel-success">
      <div class="panel-body">
        <p>
          <i class="fa fa-calendar"></i> 
          <small class="text-primary">
            Member since : {{ date("jS M, Y",strtotime($user->created_at)) }}
          </small>
        </p>
        <p>
          
        @if($user->is_active)
        <span class="label label-success">Active</span>
        @else
        <span class="label label-warning">Inactive</span>
        @endif
        </p>
        @if(count($specializations))
        <p>
        @foreach($specializations as $specialization)
        <span class="label label-default">{{$specialization->name}}</span>
        @endforeach
        </p>
        @endif
        
      </div>
    </div>
  </div>
  
  
</div>

@if(count($applications))
<div class="panel panel-info">
<div class="panel-heading">
  <div class="row">
    <div class="col-md-9">
    Applications
    </div>
    <div class="col-md-3">
    <input type="text" class="form-control" data-filter="table" data-target="#applications-table" placeholder="Filter Table Data">
    </div>
  </div>  
</div>
<div class="panel-body" style="max-height:400px;overflow-y:scroll;">
 <table id="applications-table" class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Protocol Number & Title</th>
       <th>User Submitted</th>
       <th>Investigator</th>
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
        <td>{{ ucfirst($application->user->first_name) }} {{ ucfirst($application->user->last_name) }}</td>
        <td>{{ ucfirst($application->investigator->first_name) }} {{ ucfirst($application->investigator->last_name) }}</td>
      <td>
            @if($application->status == 'accepted' || $application->status == 'selected')
            <span class="label label-success">Awarded Study</span>
        
            @elseif($application->status == 'rejected')
            <span class="label label-danger">Rejected</span>
        
            @elseif($application->status == 'pending_sponsor_approval')
            <span class="label label-warning">Pending Sponsor Approval</span>
        
            @elseif($application->status == 'sponsor_declined')
            <span class="label label-danger">Sponsor Declined</span>
        
            @elseif($application->status == 'md_declined')
            <span class="label label-danger">MD Declined</span>
        
            @elseif($application->status == 'delayed')
            <span class="label label-warning">Delayed</span>
        
            @elseif($application->status == 'review')
            <span class="label label-warning">Under review</span>
        
            @elseif($application->status == 'new')
            <span class="label label-info">Applied</span>
            @endif
      </td>
      <td>
          {{ $application->note }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table> 
</div>
</div>
@endif

@endsection

@section('page_title')
        {{ ucwords($user->first_name.' '.$user->last_name) }}
@endsection