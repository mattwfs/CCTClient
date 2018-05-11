@extends('layouts.users')
@section('main-content')
<form id="msg-form" method="post" action="{{url('user/send-message')}}" enctype="multipart/form-data" class="form">
      {!! csrf_field() !!}
<div class="panel panel-info chat-panel">
  <div class="panel-heading">Messages</div>
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
            <div style="font-size:10px">(Only PDF, JPG, or PNG files)</div>
        </div>
        
        <div class="col-md-9">
          <input type="text" name="message" placeholder="Message" class="form-control" required/>
        </div>
        
        <div class="col-md-2">
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
 My Messages
@endsection