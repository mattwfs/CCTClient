@extends('layouts.users')
@section('main-content')
<div class="panel panel-primary">
    <div class="panel-heading">Conversations</div>
    <div class="panel-body" id="messages">

        @if(count($conversations))
        <div class="list-group">

            @foreach($conversations as $c)
            <?php
            $class = '';
            $user = $c->user_a;
            if($c->user_a == auth()->user()->id){
                $user = $c->user_b;
            }

            if(convo_has_new_messages($c->id,$user)){
                $class = 'highlighted';
            }
            ?>
            <a
            @if($c->application_id)
            href="{{url('user/application/'.$c->application_id)}}"
            @else
            href="{{url('user/conversation/'.$c->id)}}"
            @endif
            class="list-group-item {{$class}}">
            @if(!$c->application_id)
                {{ get_clinic_name(auth()->user()->clinic_id) }}
            @endif
            @if($c->application_id)
                {{$c->application->trial->title}}
            @endif
            @if(convo_has_new_messages($c->id,$user))
          <span class="badge badge-danger badge-pill">
                {{convo_has_new_messages($c->id,$user)}}
          </span>
            @endif
            </a>

            @endforeach
        </div>
        @else
        <em class="text-danger">You dont have any conversation.</em>

        @endif

    </div>
</div>
@endsection