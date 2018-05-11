@extends('layouts.admin')
@section('main-content')
<div class="row">
  <div class="col-md-6">
  <h2>Awarded Trials</h2>
  </div>
  <div class="col-md-3">
  <input type="text" class="form-control" data-filter="table" data-target="#trials-table" placeholder="Filter Table"/>
  </div>
  
  <div class="col-md-3 text-right">
    <a href="" class="btn btn-default" data-toggle="modal" data-target="#trials-search-modal" ><i class="fa fa-search"></i></a>
  </div>
</div>
<table id="trials-table" class="table table-bordered table-striped">
  
  <thead class="background-primary">
    <tr>
      <th>Title</th>
      <th>Status</th>
      <th width="150px">#</th>
    </tr>
  </thead>
  
  <tbody>
    @if(count($trials))
      @foreach($trials as $trial)
      <tr>
        <td>{{$trial->title}}</td>
        <td>
        @if($trial->status)
          <p class="text-center"><i class="fa fa-check text-success"></i></p>
        @endif
        </td>
        <td>
          <a href="{{url('admin/trials/'.$trial->id)}}" class="btn btn-default">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="{{url('admin/group-message/'.$trial->id)}}" class="btn btn-default">
            <i class="fa fa-envelope"></i>
          </a>
          <a href="#" data-url="{{url('admin/trail/delete')}}" class="btn btn-danger delete-admin-confirmation" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$trial->id}}">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
      <tr>
          <td colspan="4">
              <table class="table table-bordered table-striped">
                  <thead>
                  <tr style="background:#53d359;">
                      <th>Application Date</th>
                      <th>User</th>
                      <th>Partner</th>
                      <th>Budget</th>
                      <th>#</th>
                  </tr>
                  </thead>

                  <tbody>
                  @foreach($trial->applications as $application)
                  @if ($application->status == "selected")
                  <tr class="{{$application->status}}">
                      <td>{{ $application->created_at }}</td>
                      <td>{{ $application->user->first_name.' '.$application->user->last_name }}</td>
                      <td>
                          @if($application->user->is_partner)
                          <i class="text-success fa fa-check"></i>
                          @else
                          <i class="text-danger fa fa-times"></i>
                          @endif
                      </td>
                      <td>
                          {{$application->budget}}
                      </td>
                      <td>
                          <a href="{{url('admin/application/'.$application->id)}}" class="btn btn-default">
                              <i class="fa fa-eye"></i>
                          </a>
                      </td>
                  </tr>
                  @endif
                  @endforeach
                  </tbody>

              </table>
          </td>
      </tr>
      @endforeach
    @else
    <tr>
    <td colspan="3"><em>Trails not found.</em></td>
    </tr>
    @endif
  
  </tbody>
</table>

@endsection
@section('page_title')
Awarded Trials List list
@endsection