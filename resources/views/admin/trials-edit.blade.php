@extends('layouts.admin')
@section('main-content')
  @if($trial->deleted_at)
  <div class="alert alert-danger">
    <strong>This Trial was deleted.</strong>
  </div>
  @else
  <h2>Edit Trial</h2>
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
                  <p><strong>{{session()->get('message')}}</strong></p>
              </div>
          @endif

  <form enctype="multipart/form-data" method="post" action="{{url('admin/trials/update')}}" class="form">

          <div class="row form-group">
            <div class="col-md-12">
              Title
              <input type="text" class="form-control" name="title" value="@if(old('title')) {{old('title')}} @else {{$trial->title}} @endif" required/>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              Description
              <textarea class="editor form-control" name="description" rows="10" required>@if(old('title')) {{old('description')}} @else {{$trial->description}} @endif</textarea>
            </div>
          </div>



        <hr/>
          <!--repeater-->
          @if(count($questions))
              <div>
                <h3 class="text-center">Feasibility Questionnaire</h3>
                    @foreach($questions as $question)
                        <div class="form-group">
                        <input type="text" class="form-control" name="questions[{{$question->id}}]" value="{{$question->question}}" required/>
                        </div>
                    @endforeach
              </div>
          @endif
          <p class="text-center">
              <a href="" data-toggle="modal" data-target="#add-question-modal" class="btn btn-success" style="margin-bottom:20px;">
                <i class="fa fa-plus"></i> Add Question
              </a>
          </p>
          <!--end repeater-->

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

              <input type="text" class="form-control date_picker" name="expires_on" 
                @if($trial->expires_on)    
                     value="{{ date("m/d/Y",$trial->expires_on) }}"
                @endif    
                     />
            </div>
            <div class="col-md-3">
                  Specialization

                  <div id="specialization_container">
                      @foreach(explode(",",$trial->specialization_id) as $trial_specialization)
                      <div class="row">
                          <div class="col-md-9">
                              <select style="width:100%;" name="specialization_id[]" class="form-control" required>
                                  <option value="">Specialization group</option>
                                  @foreach($specializations as $specialization)
                                  <option value="{{$specialization->id}}" @if($specialization->id == $trial_specialization) selected @endif>{{ucwords($specialization->name)}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-md-3">
                            <a href="#" class="btn btn-danger remove_specialization">X</a>
                          </div>
                      </div>
                      @endforeach
                      <a id="add_new_specialization" href="#">Add Additional Specialization</a>
                      <script type="text/javascript">
                          $(document).ready(function(){
                              $("#add_new_specialization").on("click",function(){
                                  $("#specialization_container").append('<div class="row"><div class="col-md-9"><select style="width:100%;" name="specialization_id[]" class="form-control new_specialization" required><option value="">Specialization group</option>@foreach($specializations as $specialization)<option value="{{$specialization->id}}">{{ucwords($specialization->name)}}</option>@endforeach</select></div><div class="col-md-3"><a href="#" class="btn btn-danger remove_specialization">X</a></div></div>');
                              });
                              $(".remove_specialization").on("click", function(){
                                  $(this).parent().parent().remove();
                              });
                          });
                      </script>
                  </div>





            </div>

            <div class="col-md-3">
                Attachment

                    <input type="file" class="form-control" name="attachment[]" multiple/>

                @if(count($attachments))
                <p style="margin-top:20px;">
                    @foreach($attachments as $attachment)
                    <a target="_blank" class="btn btn-default" href="{{url('uploads/'.$attachment->file)}}"><i class="fa fa-file"></i> {{ $attachment->title }}</a><br/>
                    @endforeach
                </p>
                @endif
            </div>

            <div class="col-md-3">
              Application Requires file
              <label class="btn btn-block btn-default">
                <input type="checkbox" name="requires_file" 
                @if($trial->requires_file)
                  {{'checked'}}
                @endif
                > Yes
              </label>
            </div>
          </div>
          <div class="row form-group">

            <div class="col-md-3">
                Source

                <input type="text" class="form-control" name="source"
                @if($trial->source)
                    value="{{ $trial->source }}"
                @endif
                       >
            </div>
          </div>



          <div class="row form-group">
              <div class="col-md-3" style="text-align:right;">
                  <button type="submit" class="btn btn-primary btn-block">Submit</button>
              </div>
          </div>

      {!! csrf_field() !!}
          <input type="hidden" name="id" value="{{$trial->id}}"/>
        </form>
  @endif




<!--modal start-->
<div id="add-question-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Question</h4>
      </div>
      <div class="modal-body">
          <form method="post" action="{{url('admin/trial/question/add')}}">
            <input type="hidden" name="trial_id" value="{{$trial->id}}"/>
            {!! csrf_field() !!}
              <div class="form-group">
                <input type="text" name="new_question" class="form-control" placeholder="Question" required/>
              </div>
              <button class="btn btn-primary" type="submit">Add</button>
          </form>
      </div>
    </div>
  </div>
</div>
<!--modal end-->



@endsection

@section('page_title')
Edit Trial
@endsection