@extends('layouts.wrapper')
@section('main-layout')


<!--start #main-content-->
<div class="inner-content pad">
  <div class="container-fluid">
   
    <div class="row">
      <div class="col-md-3">
        <ul class="user-menu nav nav-pills nav-stacked">
          <li class="{{ Request::is('rep') ? 'active' : 'regular' }}">
              @if(auth()->user()->role_id!=get_role_id('sales_manager'))
              <a href="{{url('rep')}}">Dashboard</a>
              @else
              <a href="{{url('sales_manager')}}">Dashboard</a>
              @endif
          </li>
            <li class="{{ Request::is('rep/clinics') ? 'active' : 'regular' }}">
                @if(auth()->user()->role_id!=get_role_id('sales_manager'))
                <a href="{{url('rep/clinics')}}">Clinics</a>
                @else
                <a href="{{url('sales_manager/clinics')}}">Clinics</a>
                @endif
          </li>
            <li class="{{ Request::is('rep/open-trials') ? 'active' : 'regular' }}">
                @if(auth()->user()->role_id!=get_role_id('sales_manager'))
                <a href="{{url('rep/open-trials')}}">Open Trials</a>
                @else
                <a href="{{url('sales_manager/open-trials')}}">Open Trials</a>
                @endif
          </li>
            <li class="{{ Request::is('rep/financials') ? 'active' : 'regular' }}">
                @if(auth()->user()->role_id!=get_role_id('sales_manager'))
                <a href="{{url('rep/financials')}}">Financials</a>
                @else
                <a href="{{url('sales_manager/financials')}}">Financials</a>
                @endif
            </li>

        </ul>
      </div>
      
      <div class="col-md-9">
        @include('partials.user-dashboard-messages')
        
       @yield('main-content')
      </div>
    </div>
    
  </div>
</div>
 <!--end #main-content-->
@endsection