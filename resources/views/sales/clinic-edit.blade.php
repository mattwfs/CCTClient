@extends('layouts.sales')
@section('main-content')
<h3>Edit Profile</h3>
<form class="form" action="{{url('rep/clinic/update')}}" method="post">
        {!! csrf_field() !!}
<table class="table table-striped table-bordered">
    <tr >
        <th>Practice Name</th>
        <td><input type="text" name="practice_name" class="form-control" value="{{$clinic->name}}" required/></td>
    </tr>

    <tr><th>Primary Location</th></tr>


        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>Street address</th>
                <td><input type="text" name="address" class="form-control" value="{{$clinic->address}}" required/></td>
        </tr>
        
        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>City</th>
                <td><input type="text" name="city" class="form-control" value="{{$clinic->city}}" required/></td>
        </tr>
        
        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>State</th>
                <td>
                <select class="form-control select2-field" name="state" required>
                    <?php
                        $attr ='';
                        $old_state = $clinic->state;
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
                <td><input type="text" name="postcode" class="form-control" value="{{$clinic->postcode}}" required/></td>
        </tr>
        
        <tr>
                <th><span class="primary_location" style="display:none;">Primary </span>Mobile</th>
                <td><input type="text" name="phone" class="form-control" value="{{$clinic->phone}}" required/></td>
        </tr>

    <tr id="last_location">
        <th><span class="primary_location" style="display:none;">Primary </span>Fax</th>
        <td><input type="text" name="fax" class="form-control" value="{{$clinic->fax}}"/></td>
    </tr>

        
        <tr>
                <th></th>
                <td>
                    <input type="hidden" name="clinic_id" value="{{$clinic->id}}">
                <button type="submit" class="btn btn-primary">Update profile</button>
                        <a href="{{url('rep/clinic/'.$clinic->id)}}" class="btn btn-default">Additional Investigators</a>
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
