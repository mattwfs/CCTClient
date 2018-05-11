@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

@if(session()->has('message'))
    <div class="alert alert-success">
        <strong>{{ session('message') }}</strong>
    </div>
@endif
          
@if(get_referred_trial(auth()->user()->id))
    @if(! is_trial_expired($trial_id))
    <div class="alert alert-info">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              
              <p>
                  You were referred to a Trial by one of your friends which you have not applied yet. Please 
                  <a href="{{url('trial/'.get_referred_trial(auth()->user()->id))}}"> Click Here </a> to apply.
              </p>
    </div>
    @endif
@endif