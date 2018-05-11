@extends('layouts.admin')
@section('main-content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <strong>{{$user->first_name}} {{$user->last_name}}</strong></div>
    <div class="panel-body" style="height:100px;overflow-y:scroll;">
        <p class="text-danger-text-center">There are no messages.</p>
    </div>

    <div class="panel-footer">
        <form method="post" action="{{url('admin/post-message')}}" class="form">
            <input type="hidden" name="user_id" value="{{$user->id}}"/>
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
@endsection
@section('page_title')
Message : {{$user->first_name}} {{$user->last_name}}
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/file-send.js')}}"></script>
@endpush
