@extends('layouts.admin')
@section('main-content')
<div class="row">
  <div class="col-md-6">
    
    <div class="panel panel-success">
      <div class="panel-body">
        <h3>
          {{ ucwords($user->first_name.' '.$user->last_name) }}
          @if($user->is_primary_contact)
          <sup><small class="text-danger">Primary contact</small></sup>
          @endif
        </h3>
        <p><strong class="text-danger">{{ $user->practise_name }}</strong></p>
        <p>
          <i class="fa fa-envelope"></i> 
          <small>{{ $user->email }}</small>
        </p>
        <p>
          <i class="fa fa-phone"></i> 
          <small>{{ $user->phone }}</small>
        </p>
        <p>
          <i class="fa fa-map-marker"></i> 
          <small>
          {{ $user->street_address.', '.$user->city }} {{ $user->state.' '.$user->postcode }}
          </small>
        </p>
        <p>
          <i class="fa fa-calendar"></i> 
          <small class="text-primary">
            Member since : {{ date("jS M, Y",strtotime($user->created_at)) }}
          </small>
        </p>
        <p>
          <i class="fa fa-check"></i> 
          <small class="text-primary">
            @if($user->clinic_id!=0)
            Clinic : <a href="{{url('admin/clinic/'.$user->clinic_id)}}">{{ $user->clinic->name }}</a>
            @endif
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
        @if($user->is_partner)
        <span class="label label-info">Partner</span>
        @else
        <span class="label label-info">Partner</span>
        @endif
          
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
        
        @if($user->referred_by)
        <hr/>
        <p> 
        <a href="{{url('admin/user/'.$user->referred_by)}}" class="btn btn-danger btn-block">
          Referred By : {{referred_by($user->id)}}
        </a>
        </p>
        @endif
        
        @if($user->is_partner)
        <hr/>
        <p>
        <a class="btn btn-success btn-block btn-lg" href="#" data-toggle="modal" data-target="#add-finance-modal" data-user="{{ $user->id }}">
          <i class="fa fa-plus"></i> 
          Add a financial transaction
        </a>
        </p>
        @include('partials.add-finance')
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
     <th>Status</th>
       <th>Notes</th>
     <th>#</th>
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
      <td>
        <a href="{{url('admin/application/'.$application->id)}}" class="btn btn-primary">
        <i class="fa fa-eye"></i>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table> 
</div>
</div>
@endif






@if(count($referrals))
<div class="panel panel-info">
<div class="panel-heading">
  <div class="row">
    <div class="col-md-9">
    Referrals
    </div>
    <div class="col-md-3">
    <input type="text" class="form-control" data-filter="table" data-target="#referrals-table" placeholder="Filter Table Data">
    </div>
  </div>  
</div>
<div class="panel-body" style="max-height:400px;overflow-y:scroll;">
<table id="referrals-table" class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Protocol Number & Title</th>
     <th>Email</th>
     <th>Status</th>
     <th></th>
   </tr>
 </thead>
  <tbody>
    @foreach($referrals as $referral)
    <tr>
      <td>
        <i class="fa fa-calendar text-danger"></i> 
        <small>
          <em>
            {{date("jS M, Y",strtotime($referral->created_at))}}
          </em>
        </small>
      </td>
      <td>{{ $referral->trial->title }}</td>
      <td>{{ $referral->email }}</td>
      <td>
        @if($referral->status == 'new')
        <span class="label label-danger">Not responded</span>
        @elseif($referral->status == 'account_created')
        <span class="label label-primary">Created account</span>
        @elseif($referral->status == 'applied')
        
            @if($referral->application_status == 'accepted')
            <span class="label label-success">Awarded Study</span>
        
            @elseif($referral->application_status == 'pending_sponsor_approval')
            <span class="label label-warning">Pending Sponsor Approval</span>
        
            @elseif($referral->application_status == 'sponsor_declined')
            <span class="label label-danger">Sponsor Declined</span>
        
            @elseif($referral->application_status == 'MD_Declined')
            <span class="label label-danger">MD Declined</span>
        
            @elseif($referral->application_status == 'delayed')
            <span class="label label-warning">Delayed</span>
        
            @else
            <span class="label label-success">Applied</span>
            @endif
        
        @endif
      </td>
      <td>
        @if($referral->status == 'applied' || $referral->status == 'account_created')
        @if(get_user_id($referral->email))
      <a href="{{url('admin/user/'.get_user_id($referral->emai))}}" class="btn btn-primary" title="View all Applications"><i class="fa fa-eye"></i></a>
        @endif
        @endif
      </td>
    </tr>
    @endforeach
   
  </tbody>
</table>  
</div>
</div>
@endif






@if(count($finances))
<div class="panel panel-info">
<div class="panel-heading">
  <div class="row">
    <div class="col-md-9">
    Finances
    </div>
    <div class="col-md-3">
    <input type="text" class="form-control" data-filter="table" data-target="#finances-table" placeholder="Filter Table Data">
    </div>
  </div>  
</div>
<div class="panel-body" style="max-height:400px;overflow-y:scroll;">
<table id="finances-table" class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Title</th>
     <th>Earning amount</th>
   </tr>
 </thead>
  <tbody>
    @foreach($finances as $finance)
    <tr>
      <td>
        <i class="fa fa-calendar text-danger"></i>
        <small>
          <em>

          </em>
        </small>
      </td>
      <td>{{ $finance->trial->title }}</td>
      <td>{{ $finance->earnings_amount }}</td>
    </tr>
    @endforeach
  </tbody>
</table>  
</div>
</div>
@endif










@endsection

@section('page_title')
Application
@endsection