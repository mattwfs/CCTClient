@extends('layouts.admin')
@section('main-content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <strong>Settings</strong></div>

    <div class="panel-footer">
        <form method="post" action="{{url('admin/settings')}}" class="form">
            <h3>Default Agreement</h3>
            <div class="form-group">
                <textarea class="editor form-control" name="editor" rows="2" style="height:200px" required>{{ $agreement->value }}</textarea>
            </div>
            <p>
                <button type="submit" class="btn btn-primary">Save</button>
            </p>
        </form>
    </div>
</div>
@endsection
@section('page_title')
Settings
@endsection