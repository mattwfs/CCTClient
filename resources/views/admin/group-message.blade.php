@extends('layouts.admin')
@section('main-content')
@if(count($applications))
@include('partials.message-display')
<form id="msg-form" method="post" action="{{url('admin/group-message')}}" class="form" enctype="multipart/form-data">
      {!! csrf_field() !!}
<div class="panel panel-primary chat-panel">
  <div class="panel-heading">Trail Participants message</div>
  <div class="panel-body" style="max-height:400px;overflow-y:scroll;" id="messages">
    
    @foreach($applications as $application)
      @if($application->user->is_active && $application->user->deleted_at==null)
      <p><label>
        <input type="checkbox" name="users[]" value="{{$application->user_id}}"/>
         {{get_user_name($application->user_id)}}
        </label></p>
      @endif
    @endforeach
    
          
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
          <textarea name="message" placeholder="Message" class="form-control" rows="10" required>{{old('message')}}</textarea>
        </div>
        
        <div class="col-md-2">
          <button type="submit" class="btn btn-block btn-primary">Send</button>
        </div>
      </div>
    
  </div>
</div>
</form>
@else
<p class="text-center text-danger">There are no applications for this trial.</p>
@endif
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/file-send.js')}}"></script>
@endpush
@section('page_title')
Message : Group Message
@endsection