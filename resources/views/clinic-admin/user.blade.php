@extends('layouts.users')
@section('main-content')
<div class="row">
     <div class="col-md-12">
          <div class="panel panel-primary">
               <div class="panel-heading">
                    <div class="row">
                       <div class="col-md-8">{{$user->first_name}} {{$user->last_name}}</div>
                       <div class="col-md-4 text-right">
                            <!--<a href="{{url('user/clinic/add-user')}}" class="btn btn-default">
                                <i class="fa fa-pencil"></i> Edit user
                            </a>-->
                        </div>
                    </div>
               </div>
               
               <div class="panel-body">
                  
                    <div class="row">
                         <div class="col-md-6">
                            <p>
                              <i class="fa fa-calendar"></i> 
                              <small class="text-primary">
                                Member since : {{ date("jS M, Y",strtotime($user->created_at)) }}
                              </small>
                            </p>
                            <p>
                              <i class="fa fa-map-marker"></i> 
                              <small>
                              {{ $user->street_address.', '.$user->city }} {{ $user->state.' '.$user->postcode }}
                              </small>
                            </p>
                             <p>
                              <i class="fa fa-phone"></i> 
                              <small>{{ $user->phone }}</small>
                            </p>
                             <p>
                              <i class="fa fa-envelope"></i> 
                              <small>{{ $user->email }}</small>
                            </p>
                         </div>
                         <div class="col-md-6">
                            <p>
                                 @if($user->is_active)
                                 <span class="label label-success">Active</span>
                                 @else
                                 <span class="label label-warning">Inactive</span>
                                 @endif
                            </p>
                              <hr/>
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
</div>
</div>
@endif

@endsection

@section('page_title')
        User : {{$user->first_name}} {{$user->last_name}}
@endsection