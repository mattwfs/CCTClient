@extends('layouts.users')
@section('main-content')
<p>You have <strong class="text-danger">{{get_referred_account_count(auth()->user()->id)}}</strong> referrals in total.</p>
<table class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Email</th>
     <th>Status</th>
     <th></th>
   </tr>
 </thead>
  <tbody>
    @if(count($referrals))
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
      <td>{{ $referral->email }}</td>
      <td>
        @if($referral->status == 'new')
        <span class="label label-danger">Not responded</span>
        @elseif($referral->status == 'account_created')
        <span class="label label-primary">Created account</span>
        @elseif($referral->status == 'applied')
        
            @if($referral->application_status == 'accepted')
            <span class="label label-success">Awarded Study</span>
        
            @elseif($referral->application_status == 'rejected')
            <span class="label label-danger">Declined</span>
        
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
        @if(get_referral_application_count($referral->email))
      <a href="{{url('user/referral/application/'.$referral->id)}}" class="btn btn-default" title="View all Applications"><i class="fa fa-eye"></i> &nbsp;&nbsp; {{get_referral_application_count($referral->email)}}</a>
        @endif
      </td>
    </tr>
    @endforeach
    @else
<tr>
<td colspan="5"><p><em>You have no referrals in our record.</em></p></td>    
</tr>
    @endif
  </tbody>
</table>
<p style="margin-top:50px;">
<h4 class="modal-title">Refer a colleague to Conduct Clinical Trials</h4>

    <form method="post" action="{{url('user/referral/colleague')}}" class="form">
        {!! csrf_field() !!}
        <div class="form-group col-xs-12 col-md-6">
            <input type="email" name="email" class="form-control" placeholder="Email" required/>
            <input type="text" name="name" class="form-control" placeholder="Name" required/>
            <p style="margin-top:15px;"><button type="submit" class="btn btn-primary">Submit</button></p>
        </div>

    </form>
</p>
</div>
{!! $referrals->links() !!}
@endsection

@section('page_title')
 My Referrals
@endsection