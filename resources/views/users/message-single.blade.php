@extends('layouts.users')
@section('main-content')
<div id="user-messages">
    <div class="panel panel-default">
      <div class="panel-heading"><small><em>Received on : {{$message->created_at}}</em></small></div>
      <div class="panel-body">
          {{$message->message}}
      </div>
    </div>
</div>
@endsection

@section('page_title')
Message
@endsection