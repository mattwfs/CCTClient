@extends('layouts.admin')
@section('main-content')
<div class="row">
  <div class="col-md-7">
  <h2>Specializations</h2>
  </div>
  <div class="col-md-3">
  <input type="text" class="form-control" data-filter="table" data-target="#specializatios-table" placeholder="Filter Table"/>
  </div>
  <div class="col-md-2">
  <a href="" class="btn btn-primary" data-toggle="modal" data-target="#specializations-crud-modal" data-modal-title="Add New"><i class="fa fa-plus"></i> Add new</a>
  </div>
</div>
<table id="specializatios-table" class="table table-bordered table-striped">
  <thead class="background-primary">
    <tr>
      <th>Name</th>
      <th>Clinics</th>
      <th>Users</th>
      <th>#</th>
    </tr>
  </thead>
  
  
  <tbody>
    @if(count($specializations))
    @foreach($specializations as $specialization)
    <tr>
      <td>{{$specialization->name}}</td>
        <td>
            @if(count($specialization->clinics))
        <span class="label label-success">
        <i class="fa fa-user"></i>
        &nbsp;&nbsp;{{count($specialization->clinics)}}
        </span>
            @endif
        </td>
        <td>
        @if(count($specialization->users))
        <span class="label label-success">
        <i class="fa fa-user"></i>
        &nbsp;&nbsp;{{count($specialization->users)}}
        </span>
        @endif
      </td>
      <td>
        <a class="btn btn-default" href="{{url('admin/specializations/'.$specialization->id)}}"><i class="fa fa-pencil"></i></a>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5">No specialization found.</td>
    </tr>
    @endif
  </tbody>

</table>




<div id="specializations-crud-modal" class="crud-modal modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form method="post" action="{{url('admin/ajax/specializations/add')}}" class="ajax-crud-modal-form form">
        {!! csrf_field() !!}
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Specialization</h4>
      </div>
      <div class="modal-body">
        <div class="row form-group">
          <div class="col-md-12">
            Name
            <input type="text" class="form-control" name="name" required/>
          </div>
        </div>
        
        <div class="row form-group">
            <div class="col-md-12">
            Description
            <textarea class="form-control" name="description"></textarea>
          </div>
        </div>
        
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection
@section('page_title')
Specializations list
@endsection