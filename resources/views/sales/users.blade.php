@extends('layouts.sales')
@section('main-content')
<div class="row">
    <div class="col-md-7"></div>
    <div class="col-md-3">
        <input type="text" class="form-control" data-filter="table" data-target="#users-table" placeholder="Filter Table"/>
    </div>
    <div class="col-md-2">
        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#users-crud-modal" data-modal-title="Add new user"><i class="fa fa-plus"></i> Add user</a>
    </div>
</div>
<div class="panel panel-primary">
        <div class="panel-heading">{{$clinic->name}}</div>

        <div class="panel-body">
                <table id="users-table" class="table table-bordered">
                        <thead>
                                   <tr>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Partner</th>
                                      <th>Specializations</th>
                                      <th>Applications</th>
                                      <th style="width:50px;">#</th>
                                    </tr>
                        </thead>
                        
                        <tbody>
                        @if(count($users))
                          @foreach($users as $user)
                            <tr @if($user->is_primary_contact)
                                {!! 'class="text-danger"' !!}
                                @endif>
                              <td>{{$user->first_name}} {{$user->last_name}}</td>
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
                              <td>{{count($user->applications)}}</td>
                              <td>
                                  <a class="modal-crud-edit btn btn-default" href="{{url('rep/users/'.$user->id)}}"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-info" href="{{url('rep/user/'.$user->id)}}"><i class="fa fa-eye"></i></a>
                              </td>
                            </tr>
                            @endforeach
                        @else
                                <tr>
                                <td colspan="6">
                                        <em>There are no users for this clinic.</em></td>
                                </tr>    
                        @endif
                        </tbody>
                </table>
        </div>
</div>
@if(count($applications)!=0)
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-9">
                Applications
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" data-filter="table" data-target="#applications-table" placeholder="Filter Table Data">
            </div>
        </div>
    </div>
    <div class="panel-body" style="max-height:400px;overflow-y:scroll;">
        <table id="applications-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Protocol Number & Title</th>
                <th>User Submitted</th>
                <th>Investigator</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applications as $application)
            <tr>
                <td>
                    <i class="fa fa-calendar text-danger"></i>
                    <small>
                        <em>
                            {{date("jS M, Y",strtotime($application->created_at))}}
                        </em>
                    </small>
                </td>
                <td>{{ $application->trial->title }}</td>
                <td>{{ ucfirst($application->user->first_name) }} {{ ucfirst($application->user->last_name) }}</td>
                <td>
                    @if($application->investigator)
                    {{ ucfirst($application->investigator->first_name) }} {{ ucfirst($application->investigator->last_name) }}
                    @endif
                </td>
                <td>
                    @if($application->status == 'accepted' || $application->status == 'selected')
                    <span class="label label-success">Awarded Study</span>

                    @elseif($application->status == 'rejected')
                    <span class="label label-danger">Rejected</span>

                    @elseif($application->status == 'pending_sponsor_approval')
                    <span class="label label-warning">Pending Sponsor Approval</span>

                    @elseif($application->status == 'sponsor_declined')
                    <span class="label label-danger">Sponsor Declined</span>

                    @elseif($application->status == 'md_declined')
                    <span class="label label-danger">MD Declined</span>

                    @elseif($application->status == 'delayed')
                    <span class="label label-warning">Delayed</span>

                    @elseif($application->status == 'review')
                    <span class="label label-warning">Under review</span>

                    @elseif($application->status == 'new')
                    <span class="label label-info">Applied</span>
                    @endif
                </td>
                <td>{{ $application->note }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div id="users-crud-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('rep/ajax/users/add')}}" class="ajax-crud-modal-form form">
                {!! csrf_field() !!}
                <input type="hidden" name="clinic_id" value="{{ $clinic->id }}">
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
                            Medical License #
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
        Sales Dashboard
@endsection