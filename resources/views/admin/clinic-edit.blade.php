@extends('layouts.admin')
@section('main-content')
<h3>Edit Profile</h3>
<form class="form" action="{{url('admin/clinic/update')}}" method="post">
    {!! csrf_field() !!}
    <table class="table table-striped table-bordered">
        <tr >
            <th>Clinic Name</th>
            <td><input type="text" name="practice_name" class="form-control" value="{{$clinic->name}}" required/></td>
        </tr>
        <tr><th>Approved</th>
        <td>
            <select name="is_approved" class="form-control">
                <option value="0" @if($clinic->is_approved == 0) selected @endif>Not approved</option>
                <option value="1" @if($clinic->is_approved == 1) selected @endif>Approved</option>
            </select>
        </td>
        </tr>
        <tr><th>Active</th>
            <td>
                <select name="is_active" class="form-control">
                    <option value="0" @if($clinic->is_active == 0) selected @endif>Not active</option>
                    <option value="1" @if($clinic->is_active == 1) selected @endif>Active</option>
                </select>
            </td>
        </tr>
        <tr><th>Specializations</th>
            <td>
                <select style="width:100%;" class="select2-field form-control" name="specializations[]" multiple required>
                    @foreach($specializations as $specialization)

                    <option value="{{$specialization->id}}"
                    @foreach($clinic->specializations as $user_spe)
                    @if($specialization->id == $user_spe->id)
                    selected
                    @endif
                    @endforeach
                    >{{$specialization->name}}</option>
                    @endforeach
                </select>
            </td>
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
            <th><span class="primary_location" style="display:none;">Primary </span>Zip code</th>
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
                <a href="{{url('admin/clinic/'.$clinic->id)}}" class="btn btn-default">Additional Investigators</a>
            </td>
        </tr>

        <tr>
            <td>
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#location-crud-modal" data-modal-title="Add new location"><i class="fa fa-plus"></i> Add new location</a>
            </td>
            <?php //<td><a href="#" id="add_location">Add new location</a></td>?>
        </tr>

    </table>
</form>


<div id="location-crud-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/location/add')}}" class="form">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add location</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group" style="margin-top:20px">
                        <div class="col-md-3">
                            Location Address
                            <input type="text" class="form-control" name="location_address" placeholder="Street address, APT no." required/>
                        </div>

                        <div class="col-md-3">
                            Location City
                            <input type="text" class="form-control" name="location_city" placeholder="City" required/>
                        </div>

                        <div class="col-md-3">
                            Location Zip Code
                            <input type="text" class="form-control" name="location_zipcode" placeholder="Zip code" required/>
                        </div>

                        <div class="col-md-3">
                            Location State<br/>
                            <select id="states" class="form-control select2-field" name="location_state" required>
                                <option selected disabled>Select state</option>
                                <?php
                                $states = get_states();
                                foreach($states as $code => $name):
                                    echo '<option value="'.$code.'">'.$name.'</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">

                        <div class="col-md-3">
                            Location Phone #
                            <input type="tel" class="form-control" name="location_phone" maxlength="10" minlength="10"/>
                        </div>
                        <div class="col-md-3">
                            Location Fax #
                            <input type="tel" class="form-control" name="location_fax" maxlength="10" minlength="10" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="clinic_id" value="{{$clinic->id}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@if(count($clinic->locations)>0)
<div class="panel panel-primary">
    <div class="panel-heading">Locations</div>
    <div class="panel-body">
        <table id="sales-managers-table" class="table table-bordered">
            <thead>
            <tr>
                <th class="col-md-2">Address</th>
                <th class="col-md-2">City</th>
                <th class="col-md-2">State</th>
                <th class="col-md-2">Zip Code</th>
                <th class="col-md-2">Phone</th>
                <th class="col-md-2">Fax</th>
                <th class="col-md-2"></th>
            </tr>
            </thead>

            <tbody>
            @foreach($clinic->locations as $location)
            <tr>
                <td>{{$location->address}}</td>
                <td>{{$location->city}}</td>
                <td>{{$location->state}}</td>
                <td>{{$location->postcode}}</td>
                <td>{{$location->phone}}</td>
                <td>{{$location->fax}}</td>
                <td><a class="btn btn-danger delete-admin-confirmation" href="#" data-url="{{url('admin/location/delete')}}" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$location->id}}"><i class="fa fa-trash"></i></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>

    </div></div>
@endif

@include('partials.admin.admin_confirmation')

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
