@extends('layouts.wrapper')
@section('main-layout')

@if(is_profile_complete())
<!--start #main-content-->
<div class="inner-content pad">
  <div class="container-fluid">
   
    <div class="row">
      <div class="col-md-3">
        <ul class="user-menu nav nav-pills nav-stacked">
          @if(auth()->user()->role_id == get_role_id('user'))
          <li class="{{ Request::is('user') ? 'active' : 'regular' }}">
            <a href="{{url('user')}}">Dashboard</a>
          </li>

          <li class="{{ Request::is('user/open-trials') ? 'active' : 'regular' }}">
            <a href="{{url('user/open-trials')}}">Open Trials</a>
          </li>

          <li class="{{ Request::is('user/my-applications') ? 'active' : 'regular' }}">
            <a href="{{url('user/my-applications')}}">My Applications</a>
          </li>
          
          
          <li class="{{ Request::is('user/messages') ? 'active' : 'regular' }}">
            <a href="{{url('user/messages')}}">Messages 
            @if(get_new_message_count())
            <span class="label label-danger">{{ get_new_message_count() }}</span>
            @endif
            </a>
          </li>

          <!--<li class="{{ Request::is('user/investigators') ? 'active' : 'regular' }}">
            <a href="{{url('user/investigators')}}">Additional Investigators</a>
          </li>-->
          
          <li class="{{ Request::is('user/referrals') ? 'active' : 'regular' }}">
            <a href="{{url('user/referrals')}}">Referrals</a>
          </li>


          <li class="{{ Request::is('user/clinic/users') ? 'active' : 'regular' }}">
            <a href="{{url('user/clinic/users')}}">Additional Study Staff</a>
          </li>

            @if(auth()->user()->is_partner)
            <li class="{{ Request::is('user/finances') ? 'active' : 'regular' }}">
                <a href="{{url('user/finances')}}">Finances</a>
            </li>

            <li class="{{ Request::is('user/training') ? 'active' : 'regular' }}">
                <a href="{{url('user/training')}}">Training Portal</a>
            </li>
            @endif
          <li><a href="" data-toggle="modal" data-target="#call-me-back">
            <span class="text-danger" style="font-size:1.2em;font-weight:bold;">
            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>&nbsp;&nbsp;Call Me Back
            </span>
          </a></li>
          @elseif(auth()->user()->role_id == get_role_id('sales_rep'))
          <li class="{{ Request::is('sales') ? 'active' : 'regular' }}">
            <a href="{{url('sales')}}">Dashboard</a>
          </li>
          
          <li class="{{ Request::is('sales') ? 'active' : 'regular' }}">
            <a href="{{url('sales')}}">Dashboard</a>
          </li>
          @endif
        </ul>
        @include('partials.call-me-back')
      </div>
      
      <div class="col-md-9">
        @include('partials.user-dashboard-messages')
        
       @yield('main-content')
      </div>
    </div>
    
  </div>
</div>
@else
@include('users.incomplete-profile')
@endif
 <!--end #main-content-->
@endsection

@push('scripts')
<script>
$(function(){

  $("#call-me-back-form").on('submit',function(e){
    e.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    var form_data = form.serialize();
    
    $.post(url,form_data,function(data){
      
      if(data == 'success'){
        form.trigger('reset');
        $('#call-me-back').modal('hide')
        toastr.success("Your request has been sent.");
      }
      else{
        console.log(data);
      }
      
    });
  });

});
</script>


@endpush