@extends('layouts.admin')
@section('main-content')
<div class="row">
  <div class="col-md-6">
  <h2>Trials</h2>
  </div>
  <div class="col-md-3">
  <input type="text" class="form-control" data-filter="table" data-target="#trials-table" placeholder="Filter Table"/>
  </div>
  
  <div class="col-md-3 text-right">
    <a href="" class="btn btn-default" data-toggle="modal" data-target="#trials-search-modal" ><i class="fa fa-search"></i></a>
  <a href="" class="btn btn-primary" data-toggle="modal" data-target="#trials-crud-modal" ><i class="fa fa-plus"></i> Add new</a>
      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#trials-historical-crud-modal" ><i class="fa fa-plus"></i> Add historical</a>
  </div>
</div>
<table id="trials-table" class="table table-bordered table-striped">
  
  <thead class="background-primary">
    <tr>
      <th>Title</th>
      <th>Status</th>
        <th>Open/Closed</th>
      <th>Applications</th>
      <th width="150px">#</th>
    </tr>
  </thead>
  
  <tbody>
    @if(count($trials))
      @foreach($trials as $trial)
      <tr>
        <td>{{$trial->title}}</td>
        <td>
        @if($trial->status)
          <p class="text-center"><i class="fa fa-check text-success"></i></p>
        @endif
        </td>
          <td>
              @if(is_null($trial->expires_on))
                <span style="color:green">Open</span>
              @else
                @if($trial->expires_on >= time() || ($trial->expires_on <= time() && $trial->no_waitlist==0))
                    <span style="color:green">Open</span>
                @else
                    <span style="color:red">Closed</span>
                @endif
              @endif
          </td>
        <td>
          <a class="btn btn-default" href="{{url('admin/trial/'.$trial->id.'/applications')}}">
            <i class="fa fa-user"></i> 
            {{count($trial->applications)}}
          </a>
        </td>
        <td>
          <a href="{{url('admin/trials/'.$trial->id)}}" class="btn btn-default">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{url('admin/group-message/'.$trial->id)}}" class="btn btn-default">
            <i class="fa fa-envelope"></i>
          </a>
          <a href="#" data-url="{{url('admin/trail/delete')}}" class="btn btn-danger delete-admin-confirmation" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$trial->id}}">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
      @endforeach
    @else
    <tr>
    <td colspan="3"><em>Trails not found.</em></td>
    </tr>
    @endif
  
  </tbody>
</table>

<?php /*{!! $trials->links() !!} */ ?>


<div id="trials-historical-crud-modal" class="crud-modal modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post" action="{{url('admin/ajax/trials/add-historical')}}" class="form">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Historical Trial</h4>
                </div>
                <div class="modal-body">

                    <div class="row form-group">
                        <div class="col-md-12">
                            Title
                            <input type="text" class="form-control" name="title" required/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            Description
                            <textarea class="editor form-control" name="description" rows="5" required></textarea>
                        </div>
                    </div>
                    <hr/>
                    <!--repeater-->
                    <div class="repeater">
                        <div class="row form-group">
                            <h3 class="text-center">Feasibility Questionnaire</h3>
                            <div data-repeater-list="historical_questionner">

                                <!--repeatable-->
                                <div data-repeater-item class="form-group">
                                    <div class="col-md-11">
                                        <input type="text" class="form-control" placeholder="Question" name="historical_question">
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="clearfix"><br/></div>
                                </div>
                                <!--end repeatable item-->

                                <div data-repeater-item class="form-group">
                                    <div class="col-md-11">
                                        <input type="text" class="form-control" placeholder="Question" name="historical_question">
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="clearfix"><br/></div>
                                </div>
                                <!--end repeatable item-->

                            </div>
                            <p class="text-center"><button type="button" class="btn btn-default" data-repeater-create href="#"><i class="fa fa-plus"></i> Add historical question</button></p>

                        </div>
                    </div>
                    <!--end repeater-->
                    <hr/>
                    <div id="doctor_container">
                        <div class="row">
                            <div class="col-md-3">
                                Doctor
                            </div>
                            <div class="col-md-3">
                                Status
                            </div>
                            <div class="col-md-3">
                                Note
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                            <select class="form-control" name="application_doctor[]">
                                <option value="" selected disabled>Select Doctor</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->last_name}}, {{$user->first_name}}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="col-md-3">
                                <select class="form-control new_status" name="application_status[]" id="application_status_change">
                                    <option value="new" selected="">No Action</option>
                                    <option value="review">Under Review</option>
                                    <option value="selected">Awarded Study</option>
                                    <option value="delayed">Delayed</option>
                                    <option value="pending_sponsor_approval">Pending Sponsor Approval</option>
                                    <option value="sponsor_declined">Sponsor Declined</option>
                                    <option value="md_declined">MD Declined</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <input type="input" class="form-control" name="application_note[]">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        <a id="add_doctor" href="#">Add Additional Doctor</a>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#add_doctor").on("click",function(){
                                    $("#doctor_container").append('<div class="row form-group"><div class="col-md-3"><select class="form-control" name="application_doctor[]"><option value="" selected disabled>Select Doctor</option>@foreach($users as $user)<option value="{{$user->id}}">{{$user->last_name}}, {{$user->first_name}}</option>@endforeach</select></div><div class="col-md-3"><select class="form-control " name="application_status[]" tabindex="-1" aria-hidden="true"><option value="new" selected="">No Action</option><option value="review">Under Review</option><option value="selected">Awarded Study</option><option value="delayed">Delayed</option><option value="pending_sponsor_approval">Pending Sponsor Approval</option><option value="sponsor_declined">Sponsor Declined</option><option value="md_declined">MD Declined</option></select></div><div class="col-md-3"><input type="input" class="form-control" name="application_note[]"></div></div>');

                                });
                            });
                        </script>
                        </div>
                    </div>

                    <div class="row form-group">

                        <div class="col-md-3">
                            Expires on
                            <input type="text" class="form-control date_picker" name="expires_on"/>
                        </div>

                        <div class="col-md-3">
                            Specialization
                            <div id="historical_specialization_container">
                                <select style="width:100%;" name="specialization_id[]" class="form-control" required>
                                    <option value="">Specialization group</option>
                                    @foreach($specializations as $specialization)
                                    <option value="{{$specialization->id}}">{{ucwords($specialization->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <a id="historical_add_specialization" href="#">Add Additional Specialization</a>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("#historical_add_specialization").on("click",function(){
                                            $("#historical_specialization_container").append('<select style="width:100%;" name="specialization_id[]" class="form-control" required><option value="">Specialization group</option>@foreach($specializations as $specialization)<option value="{{$specialization->id}}">{{ucwords($specialization->name)}}</option>@endforeach</select>');
                                        });
                                    });
                                </script>
                        </div>

                        <div class="col-md-3" >
                            Attachment
                            <div id="historical_file_container">
                                <input type="file" class="form-control" name="attachment[]" multiple/>
                            </div>
                            <!--<a id="historical_add_file" href="#">Add Additional File</a>-->
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#historical_add_file").on("click",function(){
                                        $("#historical_file_container").append('<input type="file" class="form-control new_status" name="attachment[]" multiple/>');

                                    });
                                });
                            </script>
                        </div>

                        <div class="col-md-3">
                            Application requires file
                            <label class="btn btn-block btn-default">
                                <input name="requires_file" type="checkbox"/>&nbsp;YES
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            Source

                            <input type="text" class="form-control" name="source">
                        </div>
                        <div class="col-md-3">
                            No Waitlist
                            <label class="btn btn-block btn-default">
                                <input name="no_waitlist" type="checkbox"/>&nbsp;YES
                            </label>
                        </div>
                    </div>

                    <hr/>


                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fa fa-check"></i> Submit
                    </button>

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="trials-crud-modal" class="crud-modal modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form enctype="multipart/form-data" method="post" action="{{url('admin/ajax/trials/add')}}" class="form">
        {!! csrf_field() !!}
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New Trial</h4>
      </div>
      <div class="modal-body">
        
        <div class="row form-group">
          <div class="col-md-12">
            Title
            <input type="text" class="form-control" name="title" required/>
          </div>
        </div>
        
        <div class="row form-group">
          <div class="col-md-12">
            Description
            <textarea class="editor form-control" name="description" rows="5" required></textarea>
          </div>
        </div>
        <hr/>
        <!--repeater-->
        <div class="repeater">
            <div class="row form-group">
              <h3 class="text-center">Feasibility Questionnaire</h3>
              <div data-repeater-list="questionner">

                <!--repeatable-->
                  <div data-repeater-item class="form-group">
                    <div class="col-md-11">
                      <input type="text" class="form-control" placeholder="Question" name="question">
                    </div>
                    <div class="col-md-1">
                      <button data-repeater-delete type="button" class="btn btn-danger">
                      <i class="fa fa-times"></i>
                      </button>
                    </div>
                    <div class="clearfix"><br/></div>
                  </div>
                <!--end repeatable item-->
                
                  <div data-repeater-item class="form-group">
                    <div class="col-md-11">
                      <input type="text" class="form-control" placeholder="Question" name="question">
                    </div>
                    <div class="col-md-1">
                      <button data-repeater-delete type="button" class="btn btn-danger">
                      <i class="fa fa-times"></i>
                      </button>
                    </div>
                    <div class="clearfix"><br/></div>
                  </div>
                <!--end repeatable item-->
                
              </div>
              <p class="text-center"><button type="button" class="btn btn-default" data-repeater-create href="#"><i class="fa fa-plus"></i> Add question</button></p>
                  
            </div>
        </div>
        <!--end repeater-->
        <hr/>
        <div class="row form-group">
          
          <div class="col-md-3">
            Expires on
            <input type="text" class="form-control date_picker" name="expires_on"/>
          </div>
          
          <div class="col-md-3">
            Specialization
              <div id="specialization_container">
                <select style="width:100%;" name="specialization_id[]" class="form-control" required>
                  <option value="">Specialization group</option>
                  @foreach($specializations as $specialization)
                  <option value="{{$specialization->id}}">{{ucwords($specialization->name)}}</option>
                  @endforeach

                </select>
              </div>

            <a id="add_new_specialization" href="#">Add Additional Specialization</a>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#add_new_specialization").on("click",function(){
                        $("#specialization_container").append('<select style="width:100%;" name="specialization_id[]" class="form-control new_specialization" required><option value="">Specialization group</option>@foreach($specializations as $specialization)<option value="{{$specialization->id}}">{{ucwords($specialization->name)}}</option>@endforeach</select>');
                    });
                });
            </script>
          </div>
          <div class="col-md-3" >
            Attachment
              <div id="file_container">
                  <input type="file" class="form-control" name="attachment[]" multiple/>
              </div>
              <!--<a id="add_file" href="#">Add Additional File</a>-->
              <script type="text/javascript">
                  $(document).ready(function(){
                      $("#add_file").on("click",function(){
                          $("#file_container").append('<input type="file" class="form-control" name="attachment[]" multiple/>');
                      });
                  });
              </script>
          </div>
          
          <div class="col-md-3">
            Application requires file
            <label class="btn btn-block btn-default">
              <input name="requires_file" type="checkbox"/>&nbsp;YES
            </label>
          </div>
        </div>
          <div class="row">
              <div class="col-md-3">
                  Source

                  <input type="text" class="form-control" name="source">
              </div>
              <div class="col-md-3">
                  No Waitlist
                  <label class="btn btn-block btn-default">
                      <input name="no_waitlist" type="checkbox"/>&nbsp;YES
                  </label>
              </div>
          </div>
            <hr/>
            <button type="submit" class="btn btn-primary btn-block btn-lg">
              <i class="fa fa-check"></i> Submit
            </button>
        
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
$(function(){
   $(".form").on("submit",function(e){
      $(this).find(".btn-primary").prop("disabled", true);
   });
});
</script>


@include('partials.admin.admin_confirmation')

@endsection
@section('page_title')
Trials list
@endsection