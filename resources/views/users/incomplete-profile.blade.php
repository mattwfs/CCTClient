<div class="inner-content pad">
  <div class="container">
    <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <p><strong>Looks like you have not completed your profile.</strong></p>
      <p>Please take some time to complete your profile.</p>
    </div>
    <div class="clearfix"></div>
     <form class="form" action="{{url('user/complete-profile')}}" method="post">
        {!! csrf_field() !!}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
       
       <div class="panel panel-primary">
        <div class="panel-heading">We have</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                   First name
                <input type="text" class="form-control" name="first_name" value="{{ucfirst(auth()->user()->first_name)}}" required/>
                </div>
              
                <div class="col-md-3">
                   Last name
                <input type="text" class="form-control" name="last_name" value="{{ucfirst(auth()->user()->last_name)}}" required/>
                </div>
              
                
                <div class="col-md-3">
                   Email
                <input type="email" class="form-control" name="email" value="{{auth()->user()->email}}" readonly required/>
                </div>
                
                <div class="col-md-3">
                Clinic Name
                <input type="text" class="form-control" name="practise_name" placeholder="Your clinic name" value="{{auth()->user()->clinic->name}}" readonly required/>
                </div>
            
            </div>
            <div class="row form-group" style="margin-top:20px">
                <div class="col-md-3">
                    Clinic Street address
                    <input type="text" class="form-control" name="street_address" placeholder="Street address, APT no." value="{{ auth()->user()->clinic->address }}" required/>
                </div>

                <div class="col-md-3">
                    Clinic City
                    <input type="text" class="form-control" name="city" placeholder="City" value="{{ auth()->user()->clinic->city }}" required/>
                </div>

                <div class="col-md-3">
                    Clinic Zip Code
                    <input type="text" class="form-control" name="postcode" placeholder="Postcode / Zip code" value="{{ auth()->user()->clinic->postcode }}" required/>
                </div>

                <div class="col-md-3">
                    Clinic State
                    <select id="states" class="form-control select2-field" name="state" required>
                        <option selected disabled>Select state</option>
                        <?php
                        $states = get_states();
                        foreach($states as $code => $name):
                            $selected = auth()->user()->clinic->state == $code?" selected":"";
                            echo '<option value="'.$code.'"'.$selected.'>'.$name.'</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>

            <div class="row form-group">

                <div class="col-md-3">
                    Clinic Phone Number
                    <input type="tel" class="form-control" name="phone" maxlength="10" minlength="10" value="{{ auth()->user()->clinic->phone }}"required/>
                </div>

            </div>
        </div>
      </div>
       
      <div class="panel panel-primary">
        <div class="panel-heading">You need to add</div>
        <div class="panel-body">
            <div class="row form-group">
                <div class="col-md-3">
                    Specializations<br/><span style="font-size:12px">(At least one)</span>

                        <select class="select2-field form-control" name="specializations[]" multiple required>
                            <option value="">Select Specialization</option>
                            @foreach($specializations as $specialization)
                            <option value="{{$specialization->id}}">{{$specialization->name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-3">
                    Medical License Number<br/><br/>
                    <input type="text" name="license_number" class="form-control" value="{{auth()->user()->license_number}}"/>
                </div>
                <div class="col-md-3">
                    Medical License Upload (Optional)
                    <input type="file" name="license_upload" class="form-control"/>
                </div>
                <div class="col-md-3">
                    Expiry Date<br/><br/>
                    <input type="text" name="expiry_date" class="form-control date_picker" value="{{auth()->user()->expiry_date}}"/>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-3">
                    NPI
                    <input type="text" name="npi" class="form-control" value="{{auth()->user()->npi}}"/>
                </div>


                <div class="col-md-3">
                    Timezone

                        <?php $timezones = get_timezones(); ?>
                        <select name="time_zone" class="form-control">
                            @foreach($timezones as $key => $value)
                            <option value="{{$key}}"
                            @if(auth()->user()->time_zone == $key)
                            selected
                            @endif
                            >{{$value}}</option>
                            @endforeach
                        </select>
                </div>
            </div>

            
        </div>
      </div>
         <p>
         <button type="submit" class="btn btn-primary">Update my profile</button>
         </p>
       
       
    </form>
    
  </div>
</div>