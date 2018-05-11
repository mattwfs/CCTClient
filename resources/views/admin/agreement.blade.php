@extends('layouts.admin')
@section('main-content')
@include('partials.message-display')
<form method="post" action="{{url('admin/user/agreement')}}" class="form">
    {!! csrf_field() !!}
    <input type="hidden" name="user_id" value="{{$user->id}}"/>
<div class="panel panel-primary">
    <div class="panel-heading"><strong>Agreement for: {{$user->first_name}} {{$user->last_name}}</strong></div>
    <div class="panel-body">
        <div class="form-group">
 <textarea 
           name="content" 
           class="form-control editor"
           placeholder="Content">{!! $agreement !!}</textarea>
            
        </div>
        <p>
        <button type="submit" class="btn btn-primary">Submit</button>
        </p>
    </div>
</div>
</form>
@endsection
@section('page_title')
Agreement
@endsection