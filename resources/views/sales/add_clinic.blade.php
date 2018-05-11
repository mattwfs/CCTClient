@extends('layouts.sales')
@section('main-content')
<div class="panel panel-primary">
      <div class="panel-heading"> Add New Clinic</div>
      <div class="panel-body">
        <form class="form" action="{{url('rep/add-clinic')}}" method="post">
            <span class="hidden"><input type="text" name="username" value=""/></span>
            {!! csrf_field() !!}

            <div class="row form-group">
              <br/>
              <p class="text-center text-info"><strong>Clinic information</strong></p>
                <table class="table table-striped table-bordered">

                    <tr><th colspan="2">Primary Location</th></tr>
                    <tr >
                        <th>Practice name</th>
                        <td><input type="text" name="clinic_name" class="form-control" value="{{auth()->user()->practise_name}}" required/></td>
                    </tr>
                    <tr>
                        <th><span class="primary_location" style="display:none;">Primary </span>Street address</th>
                        <td><input type="text" name="clinic_address" class="form-control" value="{{auth()->user()->street_address}}" required/></td>
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
                        <th><span class="primary_location" style="display:none;">Primary </span>Phone</th>
                        <td><input type="text" name="clinic_phone" class="form-control" value="{{auth()->user()->phone}}" required/></td>
                    </tr>

                    <tr id="last_location">
                        <th><span class="primary_location" style="display:none;">Primary </span>Fax</th>
                        <td><input type="text" name="clinic_fax" class="form-control" value="{{auth()->user()->fax}}"/></td>
                    </tr>
                    <tr>
                        <th># of Active Patients in Your Database</th>
                        <td><input type="text" name="estimated_patients" class="form-control" value="{{auth()->user()->estimated_patients}}"/></td>
                    </tr>
                    <tr>
                        <td><a href="#" id="add_location">Add new location</a></td>
                    </tr>

                </table>
            </div>

            <div class="row form-group">
              <br/>
              <p class="text-center text-info"><strong>User information</strong></p>

                <table class="table table-striped table-bordered">
                    <tr >
                        <th>First Name</th>
                        <td><input type="text" class="form-control" placeholder="First name" name="first_name" value="{{old('first_name')}}" required></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><input type="text" class="form-control" placeholder="Last name" name="last_name" value="{{old('last_name')}}" required></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}" required></td>
                    </tr>
                    <tr>
                        <th>Mobile (Not Office)</th>
                        <td><input type="text" name="user_phone" class="form-control" value="{{auth()->user()->phone}}"/></td>
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
                        <td colspan="2">
                        <button class="btn btn-primary btn-block" style="width:200px;" type="submit">Save</button> <button class="btn btn-primary btn-block"  style="display:inline-block; width:250px;" type="submit">Save and Add Study Staff</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
      </form>

      </div>
</div>


<div class="panel panel-primary">
    <div class="panel-heading"> Add Existing Clinic</div>
    <div class="panel-body">
        <form class="form" action="{{url('rep/associate-clinic')}}" method="post">

            {!! csrf_field() !!}
                <table class="table table-striped table-bordered">
                <tr>
                    <th>
                        Existing Doctor
                    </th>
                    <td>
                        <select name="id" class="form-control">
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->getFirstNameAttribute($user->first_name)}} {{$user->getLastNameAttribute($user->last_name)}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><button class="btn btn-primary btn-block" type="submit">Link Account</button></td>
                </tr>
                </table>
        </form>

    </div>
</div>
@endsection

@section('page_title')
        Add Clinic
@endsection