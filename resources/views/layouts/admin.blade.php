@extends('layouts.wrapper')
@section('main-layout')

<!--start #main-content-->
<div class="inner-content pad">
  <div class="container-fluid">
   
    <div class="row">
      <div class="col-md-3">
        
        <ul class="user-menu nav nav-pills nav-stacked">
          <li class="{{ Request::is('admin') ? 'active' : 'regular' }}">
            <a href="{{url('admin')}}">Dashboard</a>
          </li>
          <li class="{{ Request::is('admin/specializations') ? 'active' : 'regular' }}">
            <a href="{{url('admin/specializations')}}">Specializations</a>
          </li>
          <li class="{{ Request::is('admin/users') ? 'active' : 'regular' }}">
            <a href="{{url('admin/users')}}">Sites</a>
          </li>
          <li class="{{ Request::is('admin/all-users') ? 'active' : 'regular' }}">
            <a href="{{url('admin/all-users')}}">Users</a>
          </li>
          <li class="{{ Request::is('admin/trials') ? 'active' : 'regular' }}">
            <a href="{{url('admin/trials')}}">Trials</a>
          </li>
          <li class="{{ Request::is('admin/awarded') ? 'active' : 'regular' }}">
            <a href="{{url('admin/awarded')}}">Awarded Trials</a>
          </li>
          <li class="{{ Request::is('admin/applications') ? 'active' : 'regular' }}">
            <a href="{{url('admin/applications')}}">Applications
                @if(get_new_application_count())
                <span class="label label-danger">{{ get_new_application_count() }}</span>
                @endif</a>
          </li>
            <li class="{{ Request::is('admin/referrals') ? 'active' : 'regular' }}">
                <a href="{{url('admin/referrals')}}">Referrals
                    @if(get_new_referral_count())
                    <span class="label label-danger">{{ get_new_referral_count() }}</span>
                    @endif</a>
                </a>
            </li>
          <li class="{{ Request::is('admin/sales-rep') ? 'active' : 'regular' }}">
            <a href="{{url('admin/sales-rep')}}">Sales</a>
          </li>
          <li class="{{ Request::is('admin/messages') ? 'active' : 'regular' }}">
            <a href="{{url('admin/messages')}}">
              <i class="fa fa-envelope"></i> Messages 
              @if(get_new_message_count())
                <span class="label label-danger">{{ get_new_message_count() }}</span>
              @endif
            </a>
          </li>
          <li class="{{ Request::is('admin/settings') ? 'active' : 'regular' }}">
              <a href="{{url('admin/settings')}}">Settings</a>
            </li>
        </ul>
        
       
        
        
        
      </div>
      
      <div class="col-md-9">
       @yield('main-content')
      </div>
    </div>
    
  </div>
</div>
 <!--end #main-content-->
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/trumbowyg.min.js')}}"></script>
<script>
$('.editor').trumbowyg();
</script>
@endpush

@section('css_link')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/trumbowyg.css')}}"/>
@endsection