@extends('layouts.users')
@section('main-content')

@if($application->trial->deleted_at  != null)
<div class="alert alert-danger">
<strong>Trial this application was submitted to is already deleted.</strong>
</div>
@endif
<div class="row">

  <div class="col-md-8">

    <strong>Applications For : <a href="">{{ $application->trial->title }}</a></strong>
    <hr/>
    @if($application->investigator_id)
        <p>Applied on behalf of : {{ucfirst(investigator_detail($application->investigator_id,'first_name'))}} {{ucfirst(investigator_detail($application->investigator_id,'last_name'))}}</p>
        <p>Medical License : {{investigator_detail($application->investigator_id,'license_number')}}</p>
        <p>License expiry : {{investigator_detail($application->investigator_id,'expiry_date')}}</p>
        <hr/>
    @endif
 @if(count($questions))
    <div class="panel panel-info">
      <div class="panel-heading">Questions &amp; Answers</div>
      <div class="panel-body">
        @foreach($answers as $answer)
        <dl>
          <dt>{{ $answer->question->question }}</dt>
          <dd> - {{ $answer->answer }} </dd>
        </dl>
        @endforeach
      </div>
    </div>
@endif


@if(! $application->user->applied_as)
    <div class="panel panel-default">
      <div class="panel-heading">Investigator&apos;s Agreement <a target="_blank" href="{{ url('admin/application/'.$application->id.'/download') }}" class="btn btn-default" title="Download my application">
              <i class="fa fa-download" aria-hidden="true"></i>
          </a></div>
      <div class="panel-body" style="font-size:11px;line-height:16px;">
        {!! get_agreement_content($application->user_id) !!}
      </div>
      <div class="panel-footer">
      @if($application->signature)
        <img src="{{ $application->signature }}" width="350"/>
      @endif
      </div>
    </div>

     @if($conversation)
      <form id="msg-form" method="post" action="{{url('user/send-message')}}" enctype="multipart/form-data" class="form">
          <input type="hidden" name="conversation_id" value="{{$conversation->id}}"/>
          <input type="hidden" name="user_id" value="{{$application->user->id}}"/>
          {!! csrf_field() !!}
          <div class="panel panel-primary chat-panel">
              <div class="panel-heading">{{$application->user->first_name}} {{$application->user->last_name}}</div>
              <div class="panel-body" style="max-height:400px;overflow-y:scroll;" id="messages">

                  @if(count($messages))
                  <div id="user-messages">
                      @foreach($messages as $message)
                      {{mark_message_old($message->id)}}
                      @if($message->msg_from == auth()->user()->id)
                      <div class="row chat-message">
                          <div class="left">
                              {!! $message->message !!}
                          </div>
                          <small class="text-left">You: {{$message->created_at->diffForHumans()}}</small>
                      </div>
                      @else
                      <div class="row chat-message">
                          <div class="right">
                              {!! $message->message !!}
                          </div>
                          <div class="text-right">
                              <small>{{get_user_name($message->msg_from)}}:{{$message->created_at->diffForHumans()}}</small>
                          </div>
                      </div>
                      @endif


                      @endforeach
                  </div>
                  @else
                  <p><small><em>You have no messages</em></small></p>
                  @endif


              </div>
              <div class="panel-footer">
                  <div class="row">

                      <div class="col-md-1">
                          <a id="chat-attachment-trigger" href="#" class="btn btn-default">
                              <i class="fa fa-paperclip" aria-hidden="true"></i>
                          </a>
          <span class="hidden">
          <input type="file" name="attachment" id="chat-attachment" data-upload-url="{{url('ajax-upload-file')}}"/>
          </span>
                      </div>

                      <div class="col-md-9">
                          <input type="text" name="message" placeholder="Message" class="form-control" required/>
                      </div>

                      <div class="col-md-2">
                          <div>
                              Needs Response <input type="checkbox" name="needs_response">&nbsp;&nbsp;&nbsp;
                              Urgent <input type="checkbox" name="urgent">
                          </div>
                          <button type="submit" class="btn btn-block btn-primary">Send</button>
                      </div>
                  </div>
              </div>
          </div>
      </form>

     @else
      <div class="panel panel-primary">
          <div class="panel-heading">
              <strong>{{$application->user->first_name}} {{$application->user->last_name}}</strong></div>
          <div class="panel-body" style="height:100px;overflow-y:scroll;">
              <p class="text-danger-text-center">There are no messages.</p>
          </div>

          <div class="panel-footer">
              <form method="post" action="{{url('user/send-message')}}" class="form">
                  <input type="hidden" name="user_id" value="{{$application->user->id}}"/>
                  <input type="hidden" name="application_id" value="{{$application->id}}"/>
                  {!! csrf_field() !!}
                  <div class="form-group">
                      <textarea class="form-control" name="message" rows="2" placeholder="Type message here" required></textarea>
                  </div>
                  <p>
                      <a id="chat-attachment-trigger" href="#" class="btn btn-default">
                          <i class="fa fa-paperclip" aria-hidden="true"></i>
                      </a>
                <span class="hidden">
                <input type="file" name="attachment" id="chat-attachment" data-upload-url="{{url('ajax-upload-file')}}"/>
                </span>
                  <div>
                      Needs Response <input type="checkbox" name="needs_response"> &nbsp;&nbsp;&nbsp;
                      Urgent <input type="checkbox" name="urgent"><br/>
                      <button type="submit" class="btn btn-primary">Send</button>

                  </div>

                  </p>
              </form>
          </div>
      </div>

     @endif



@endif
  </div>
  <div class="col-md-4">

    <div class="panel panel-danger">
      <div class="panel-heading">Status</div>
      <div class="panel-body">
        <p>
            <input type="text" readonly="true" class="form-control" placeholder="Note" value="{{$application->note}}"/>
        </p>
        <p>            
            <?php $status = get_application_status_list(); ?>
            @foreach($status as $value => $text)
                @if($value == $application->status)
                    <input type="text" readonly="true" class="form-control" placeholder="Note" value="{{$text}}"/>
                @endif
            @endforeach
        </p>
      </div>
    </div>

@if($application->trial->requires_file && count($application->attachments))
    <div class="panel panel-warning">
      <div class="panel-heading">Attachments</div>
      <div class="panel-body">
        @foreach($application->attachments as $attachment)
        <a target="_blank" href="{{url('uploads/'.$attachment->file)}}" class="btn btn-default">{{ $attachment->title }}</a>
        @endforeach
      </div>
    </div>
@endif

</div>
<script type="text/javascript">
$(function(){

   $(".form").on("submit",function(e){
      $(this).find(".btn-primary").prop("disabled", true);
   });
});
</script>
@endsection

@section('page_title')
Application
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/file-send.js')}}"></script>
@endpush