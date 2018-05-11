@extends('layouts.users')
@section('main-content')
<h3>Edit Profile</h3>
<form class="form" action="{{url('user/update-profile')}}" method="post">
        {!! csrf_field() !!}
<table class="table table-striped table-bordered">
        <tr>
                <th>First name</th>
                <td><input type="text" name="first_name" class="form-control" value="{{auth()->user()->first_name}}" required/></td>
        </tr>
        
        <tr>
                <th>Last name</th>
                <td><input type="text" name="last_name" class="form-control" value="{{auth()->user()->last_name}}" required/></td>
        </tr>
        
        <tr>
                <th>Email</th>
                <td><input type="email" name="email" class="form-control" value="{{auth()->user()->email}}" required/></td>
        </tr>
        <tr><th>Primary Location</th></tr>
        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>Street address</th>
                <td><input type="text" name="street_address" class="form-control" value="{{auth()->user()->street_address}}" required/></td>
        </tr>
        
        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>City</th>
                <td><input type="text" name="city" class="form-control" value="{{auth()->user()->city}}" required/></td>
        </tr>
        
        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>State</th>
                <td>
                <select class="form-control select2-field" name="state" required>
                    <?php
                        $attr ='';
                        $old_state = auth()->user()->state;
                    foreach($states as $code => $name):
                        if($code ==  $old_state){
                                $attr = 'selected';
                        }
                        echo '<option value="'.$code.'" '.$attr.'>'.$name.'</option>';
                        $attr ='';
                    endforeach;
                    ?>
                </select>
                </td>
        </tr>

        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>Postal code</th>
                <td><input type="text" name="postcode" class="form-control" value="{{auth()->user()->postcode}}" required/></td>
        </tr>
        
        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>Mobile</th>
                <td><input type="text" name="phone" class="form-control" value="{{auth()->user()->phone}}" required/></td>
        </tr>
        
        <tr id="last_location">
                <th><span class="primary_location" style="display:none;">Primary </span>Practice name</th>
                <td><input type="text" name="practise_name" class="form-control" value="{{auth()->user()->practise_name}}" required/></td>
        </tr>

        <tr>
                <th>Specialization<br/>(Primary & Secondary)</th>
                <td>
                        <select class="select2-field form-control" name="specializations[]" multiple required>
                                <option value="">Select Specialization</option>
                                @foreach($specializations as $specialization)
                                <option value="{{$specialization->id}}"
                                        @foreach(auth()->user()->specializations as $user_spe)
                                        @if($specialization->id == $user_spe->id)
                                        selected
                                        @endif
                                        @endforeach
                                        >{{$specialization->name}}</option>
                                @endforeach
                        </select>
                </td>
        </tr>
        <tr>
            <th>Medical License Number</th>
            <td><input type="text" name="license_number" class="form-control" value="{{auth()->user()->license_number}}"/></td>
        </tr>
    <tr>
        <th>Medical License Upload (Optional)</th>
        <td><input type="file" name="license_upload" class="form-control"/></td>
    </tr>
        <tr>
            <th>Expiry Date</th>
            <td><input type="text" name="expiry_date" class="form-control date_picker" value="{{auth()->user()->expiry_date}}"/></td>
        </tr>
        <tr>
            <th>NPI</th>
            <td><input type="text" name="npi" class="form-control" value="{{auth()->user()->npi}}"/></td>
        </tr>
       
        
        <tr>
                <th>Timezone</th>
                <td>
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
                </td>
        </tr>
        <tr>
            <th>Please Upload W9 (Form may be found <a target="_blank" href="https://www.irs.gov/pub/irs-pdf/fw9.pdf">here</a>)</th>
            <td><input type="file"></td>
        </tr>

        <tr>
                <th></th>
                <td>
                <button type="submit" class="btn btn-primary">Update profile</button>
                        <a href="{{url('user/clinic/users')}}" class="btn btn-default">Additional Study Staff</a>
                </td>
        </tr>


    <tr>
        <td><a href="#" id="add_location">Add new location</a></td>
    </tr>
        
</table>
</form>
@endsection

@section('page_title')
        Edit Profile
@endsection

@section('css_link')
       <style>
        th
               {
                       width:30%;
               }
        </style>
@endsection
