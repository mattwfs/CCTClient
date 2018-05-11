@extends('layouts.admin')
@section('main-content')
<div class="row">
  <div class="col-md-7">
  <h2>Sites</h2>
  </div>
  <div class="col-md-3">
  <input type="text" class="form-control" data-filter="table" data-target="#users-table" placeholder="Filter Table"/>
  </div>
  <div class="col-md-2">
  <a href="" class="btn btn-primary" data-toggle="modal" data-target="#users-crud-modal" data-modal-title="Add new user"><i class="fa fa-plus"></i> Add user</a>
  </div>
</div>
<table id="users-table" class="table table-bordered table-striped">
  <thead class="background-primary">
    <tr>
      <th>User Name</th>
      <th>Clinic</th>
      <th>Email</th>
      <th>Partner</th>
      <th>Specializations</th>
        <th>Receive Clinic Emails</th>
        <th>View Financials</th>
        <th>Approved</th>

      <th style="width:190px;">#</th>
    </tr>
  </thead>
  
  
  <tbody>
    @if($users->isEmpty())
        <tr><td colspan="6">No users for this clinic</td></tr>
    @else
    @foreach($users as $user)
    <tr style="
    @if(!$user->is_active)
    color:red;
    @endif
    background-color:#fff">
        <td>
            {{$user->first_name}} {{$user->last_name}}
            @if($user->is_primary_contact)
            <sup><small class="text-danger">Primary contact</small></sup>
            @endif
        </td>
        <td>
            @if(!empty($user->clinic))
            {{$user->clinic->name }}
            @endif
        </td>
        <td>{{$user->email}}</td>
        <td>
            @if($user->is_partner==1)
            <span class="fa fa-check text-success"></span> Partner
            @elseif($user->is_partner==2)
            <span class="fa fa-check text-success"></span> Special
            @endif
        </td>
        <td>
            @foreach($user->specializations as $specialization)
            <span style="margin-bottom:2px;display:inline-block;" class="label label-default">{{$specialization->name}}</span>&nbsp;&nbsp;
            @endforeach
        </td>
        <td>
            <input type="checkbox" class="receive_emails" data-id="{{$user->id}}" @if($user->receive_emails==1)checked @endif>
        </td>
        <td>
            <input type="checkbox" class="receive_financials" data-id="{{$user->id}}" @if($user->receive_financials==1)checked @endif>
        </td>
        <td>
            @if(empty($user->clinic) || $user->clinic->is_approved==0)
            <span class="fa fa-exclamation text-danger"></span> Site Not Approved
            <br/>
            @endif

            @if($user->is_approved==1)
            <span class="fa fa-check text-success"></span> Approved
            @elseif($user->is_approved==0)
            <span class="fa fa-exclamation text-danger"></span> Not Approved
            @endif
        </td>
        <td>
            <a class="modal-crud-edit btn btn-default" href="{{url('admin/users/'.$user->id)}}"><i class="fa fa-pencil"></i></a>
            <a class="btn btn-primary" href="{{url('admin/message/'.$user->id)}}"><i class="fa fa-envelope"></i></a>
            <a class="btn btn-info" href="{{url('admin/user/'.$user->id)}}"><i class="fa fa-eye"></i></a>
            <a class="btn btn-danger delete-admin-confirmation" href="#" data-url="{{url('admin/user/delete')}}" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$user->id}}"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
    @endforeach
    @endif
  </tbody>

</table>

@if(!empty($sales_rep))
<div class="panel panel-primary">

    <div class="panel-heading">Sales Rep</div>
    <div class="panel-body">
        <table id="clinics-table" class="table table-bordered">
            <thead>
            <tr>
                <th>Rep Name</th>
                <th>Rep Email</th>
            </tr>
            </thead>

            <tbody>
                <td>{{ ucfirst($sales_rep->first_name) }} {{ ucfirst($sales_rep->last_name) }}</td>
                <td>{{ $sales_rep->email }}</td>
            </tbody>
        </table>
    </div>
</div>
@endif
<div id="users-crud-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="post" action="{{url('admin/ajax/users/add')}}" class="ajax-crud-modal-form form">
        {!! csrf_field() !!}
          <input type="hidden" name="clinic_id" value="{{ $clinic_id }}">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add user</h4>
      </div>
      <div class="modal-body">
          <div class="row form-group">
              <div class="col-md-3">
                  First name
                  <input type="text" class="form-control" name="first_name" required/>
              </div>
              <div class="col-md-3">
                  Last name
                  <input type="text" class="form-control" name="last_name" required/>
              </div>
              <div class="col-md-3">
                  Email
                  <input type="email" class="form-control" name="email" required/>
              </div>
              @if(auth()->user()->role_id == get_role_id("admin"))
              <div class="col-md-3">
                  Source
                  <input type="source" class="form-control" name="source"/>
              </div>
              @endif
          </div>
          <div class="row form-group">
              <div class="col-md-3">
                  Role
                  <select name="user_type" id="user_type" class="form-control">
                      <option value="" selected disabled>User type</option>
                      <option value="clinic">Investigator</option>
                      <option value="point_of_contact">Point of Contact</option>
                      <option value="study_coordinator">Study Coordinator</option>
                  </select>
              </div>
              <div class="col-md-3">
                  User type
                  <select name="is_partner" class="form-control">
                      <option value="0">Non partner</option>
                      <option value="1">Partner</option>
                      <option value="2">Special</option>
                  </select>
              </div>

          </div>
          <div class="row form-group investigator-fields">
              <div class="col-md-12">
                  Specializations<br/>
                  <select style="width:100%;" class="select2-field form-control" name="specializations[]" multiple required>
                      @foreach($specializations as $specialization)
                          <option value="{{$specialization->id}}">{{$specialization->name}}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="row form-group investigator-fields">
              <div class="col-md-3">
                  Medical License Number
                  <input type="text" name="license_number" class="form-control"/>
              </div>
              <div class="col-md-3">
                  Expiry Date
                  <input type="text" name="expiry_date" class="form-control date_picker"/>
              </div>
              <div class="col-md-3">
                  NPI
                  <input type="text" name="npi" class="form-control"/>
              </div>


              <div class="col-md-3">
                  Timezone
                  <?php $timezones = get_timezones(); ?>
                  <select name="time_zone" class="form-control">
                      @foreach($timezones as $key => $value)
                          <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                  </select>

              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(function(){
        if($("#user_type").val()=="study_coordinator"){
            $(".investigator-fields").show();
        }
        $('#user_type').on("change",function(){
            if($(this).val()=="clinic"){
                $(".investigator-fields").show();
            } else {
                $(".investigator-fields").hide();
            }
        });
    });
    $(".receive_emails").on("click",function(){
        var base_url = $("#baseurl").attr("content");
        $.ajax({
            type : 'post',
            url : base_url+'/admin/ajax/update_receive_emails',
            data: {_token:"{{ csrf_token() }}",id:$(this).attr("data-id"),receive_emails:$(this).is(":checked")},
            success:function(response){
                update_div.html(response);
            }
        });
    });
    $(".receive_financials").on("click",function(){
        var base_url = $("#baseurl").attr("content");
            $.ajax({
                type : 'post',
                url : base_url+'/admin/ajax/update_receive_financials',
                data: {_token:"{{ csrf_token() }}",id:$(this).attr("data-id"),receive_financials:$(this).is(":checked")},
                success:function(response){
                    update_div.html(response);
                }
            });
    });
</script>
@include('partials.admin.admin_confirmation')
@endsection
@section('page_title')
Users list
@endsection