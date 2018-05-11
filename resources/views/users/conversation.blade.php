@extends('users.messages-box')
@section('messages')
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
@endsection