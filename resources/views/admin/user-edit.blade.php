@extends('layouts.admin')
@section('main-content')
<h2>{{'Edit : '. $user->first_name.' '.$user->last_name}}</h2>
<a href="{{str_replace(url('/'), '', url()->previous())}}">Back to List</a>
<form method="post" action="{{url('admin/users/update')}}" class="form">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(Session::has('message'))
    <div class="alert alert-success">
        <p><strong>{{session('message')}}</strong></p>
    </div>
    @endif

    <div class="modal-body">
        <div class="row form-group">
            <div class="col-md-3">
                First name
                <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" required/>
            </div>
            <div class="col-md-3">
                Last name
                <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" required/>
            </div>
            <div class="col-md-3">
                Email
                <input type="email" class="form-control" name="email" value="{{$user->email}}" required/>
            </div>
            <div class="col-md-3">
                Source
                <input type="source" class="form-control" name="source" value="{{$user->source}}"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                Mobile Phone
                <input type="phone" class="form-control" name="source" value="{{$user->phone}}"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                Role
                <select name="user_type" id="user_type" class="form-control">
                    <option value="" selected disabled>User type</option>
                    <option value="clinic" @if($user->user_type == "clinic") selected @endif>Investigator</option>
                    <option value="point_of_contact" @if($user->user_type == "point_of_contact") selected @endif>Point of Contact</option>
                    <option value="study_coordinator" @if($user->user_type == "study_coordinator") selected @endif>Study Coordinator</option>
                </select>
            </div>
            <div class="col-md-3">
                Status
                <select name="is_active" class="form-control">
                    <option value="0" @if($user->is_active == 0) selected @endif>Inactive</option>
                    <option value="1" @if($user->is_active == 1) selected @endif>Active</option>
                </select>
            </div>
            <div class="col-md-3">
                Approved
                <select name="is_approved" class="form-control">
                    <option value="0" @if($user->is_approved == 0) selected @endif>Not approved</option>
                    <option value="1" @if($user->is_approved == 1) selected @endif>Approved</option>
                </select>
            </div>
            <div class="col-md-3">
                User type
                <select name="is_partner" class="form-control">
                    <option value="0" @if($user->is_partner == 0) selected @endif>Non partner</option>
                    <option value="1" @if($user->is_partner == 1) selected @endif>Partner</option>
                    <option value="2" @if($user->is_partner == 2) selected @endif>Special</option>
                </select>
            </div>

        </div>

        <div class="row form-group">
        <div class="col-md-12 investigator-fields">Specializations

                <select style="width:100%;" class="select2-field form-control" name="specializations[]" multiple required>
                    @foreach($specializations as $specialization)

                    <option value="{{$specialization->id}}"
                    @foreach($user->specializations as $user_spe)
                    @if($specialization->id == $user_spe->id)
                    selected
                    @endif
                    @endforeach
                    >{{$specialization->name}}</option>
                    @endforeach
                </select>
            <br/><br/>
        </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">Clinic
                <select style="width:100%;" class="form-control" name="clinic_id" required>
                    @foreach($clinics as  $clinic)

                    <option value="{{$clinic->id}}"
                    @if($user->clinic_id == $clinic->id)
                    selected
                    @endif>{{$clinic->name}}</option>

                    @endforeach
                </select>
            </div>
            <div class="col-md-6">Location
                <select style="width:100%;" class="form-control" name="location_id" required>
                    <option value="0">Main Location</option>
                    @foreach($user->clinic->locations as $location)

                    <option value="{{$location->id}}"
                    @if($user->location_id == $location->id)
                    selected
                    @endif>{{$location->address}}</option>

                    @endforeach
                </select>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-3 investigator-fields">
                Medical License Number
                <input type="text" name="license_number" class="form-control" value="{{$user->license_number}}"/>
            </div>
            <div class="col-md-3 investigator-fields">
                Expiry Date
                <input type="text" name="expiry_date" class="form-control date_picker" value="{{$user->expiry_date}}"/>
            </div>
            <div class="col-md-3 investigator-fields">
                NPI
                <input type="text" name="npi" class="form-control" value="{{$user->npi}}"/>
            </div>


            <div class="col-md-3">
                Timezone
                <?php $timezones = get_timezones(); ?>
                <select name="time_zone" class="form-control">
                    @foreach($timezones as $key => $value)
                    <option value="{{$key}}"
                    @if($user->time_zone == $key)
                    selected
                    @endif
                    >{{$value}}</option>
                    @endforeach
                </select>

            </div>
        </div>

    </div>
    <p>
        <label>
            <input type="checkbox" name="new_password" value="yes"/>
            Send a new password for this user
        </label>
    </p>
    @if($user->is_partner == 2)
    <p><a href="{{url('admin/user/agreement/'.$user->id)}}" class="btn btn-info">User Specific Agreement</a></p>
    @endif
    <p>
        <a href="{{url('admin/users')}}" class="btn btn-default">Cancel</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </p>
    {!! csrf_field() !!}
    <input type="hidden" name="id" value="{{$user->id}}"/>
</form>
<script type="text/javascript">
    $(function(){
        if($("#user_type").val()=="study_coordinator"){
            $(".investigator-fields").hide();
        }
        $('#user_type').on("change",function(){
            if($(this).val()=="clinic"){
                $(".investigator-fields").show();
            } else {
                $(".investigator-fields").hide();
            }
        });
    });
</script>

@endsection
@section('page_title')
{{'Edit : '. $user->first_name.' '.$user->last_name}}
@endsection