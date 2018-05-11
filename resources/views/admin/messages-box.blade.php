@extends('layouts.admin')
@section('main-content')
<form id="msg-form" method="post" action="{{url('admin/send-message')}}" enctype="multipart/form-data" class="form">
  <input type="hidden" name="conversation_id" value="{{$conversation_id}}"/>
      <input type="hidden" name="user_id" value="{{$user->id}}"/>
      {!! csrf_field() !!}
<div class="panel panel-primary chat-panel">
  <div class="panel-heading">{{$user->first_name}} {{$user->last_name}}</div>
  <div class="panel-body" style="max-height:400px;overflow-y:scroll;" id="messages">
    
    @yield('messages')
          
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
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/file-send.js')}}"></script>
@endpush
@section('page_title')
Message : {{$user->first_name}} {{$user->last_name}}
@endsection