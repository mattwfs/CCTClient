<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<meta id="baseurl" name="baseurl" content="{{ url('/')}}"/>
<link rel="icon"
      type="image/png"
      href="http://dev.fasttrackclinicalsolutions.com/favicon.png">
<title>
@hasSection('page_title')
  @yield('page_title')
@else
  Conduct Clinical Trials
@endif
</title>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/validation.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/media.css') }}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!--Start of Zendesk Chat Script-->
    @if(!empty(auth()->user()->role_id) && auth()->user()->role_id == get_role_id("user"))
    <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){
            z._.push(c)},$=z.s=
            d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
            _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
            $.src='https://v2.zopim.com/?5U7tGgxRy4YdF71MQn8v2B6by2m1EJQQ';z.t=+new Date;$.
                type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
    </script>
    @endif
    <!--End of Zendesk Chat Script-->
@hasSection('css_link')
  @yield('css_link')
@endif


</head>
<body>

<!--start of #main-header-->
<header id="main-header">
  <div class="mid">
    <div class="container">
      <div class="row">
          <div class="col-md-4">
              <a href="{{ url('/') }}" id="logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Conduct Clinical Trials Portal" class="img-responsive"/>
              </a>
          </div>
        <div class="col-md-8">
            <nav class="navbar" id="main-navbar">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-collapse" aria-expanded="false">
                  <i class="fa fa-bars"></i>
                </button>
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="main-nav-collapse">

                <ul class="nav navbar-nav navbar-right">
                @if(! auth()->user())
                  <li><a href="{{url('login')}}"><i class="fa fa-lock"></i> Login</a></li>
                  <li><a href="{{url('register')}}"><i class="fa fa-user"></i> Create account</a></li>
                @else
                    <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                          @if(auth()->user()->user_type=='clinic')
                          {{ auth()->user()->clinic->name }} <small>({{ auth()->user()->first_name.' '.auth()->user()->last_name }})</small>
                          @else
                          {{ auth()->user()->first_name.' '.auth()->user()->last_name }}
                          @endif
                          <span class="caret"></span>
                   </a>
                  <ul class="dropdown-menu">
                      <li><a href="{{get_dashboard_url()}}">Dashboard</a></li>
                      <li><a href="{{get_dashboard_url().'/edit-profile'}}">Edit profile</a></li>
                    <li><a href="{{url('change-password')}}">Change Password</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('logout')}}" class="text-danger">Logout</a></li>
                  </ul>
                </li>
                @endif
                </ul>
              </div><!-- /.navbar-collapse -->
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!--end of .mid-->

</header>
 <!--end of #main-header-->

        @yield('main-layout')



 <!--start of #main-footer-->
<footer id="main-footer" class="pad">
 <div class="container">
   <p>4533 MacArthur Blvd., Newport Beach, CA 92660<br/>
   Phone : 888-635-0552<br/>
    Email : info<i class="fa fa-at" aria-hidden="true"></i>conductclinicaltrials.com
    </p>

   <p class="text-center social">
     <a href=""><i class="fa fa-facebook"></i></a>
     <a href=""><i class="fa fa-twitter"></i></a>
     <a href=""><i class="fa fa-youtube"></i></a>
   </p>

   <p class="text-center">
       The Conduct Clinical Trials Portal&reg; supports: Mozilla Firefox 29+, Chrome 34+, and any other modern web browser compatible with HTML5 and CSS3.
     </ul>
   </p>
   <p>&copy; Copyright <?= date("Y"); ?>. All Rights reserved. <a style="color:white;" href="{{ url('privacy') }}">Privacy Policy</a></p>
 </div>
</footer>
 <!--end of #main-footer-->
<script type="text/javascript" src="{{ asset('assets/js/jquery.repeater.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>x
<script type="text/javascript" src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/ajax-crud.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
        'use strict';
        $('.repeater').repeater({initEmpty: true});
});
</script>
@stack('scripts')
</body>
</html>