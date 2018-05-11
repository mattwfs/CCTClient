@extends('layouts.admin')
@section('main-content')
<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2">
        <a href="" class="btn btn-default" data-toggle="modal" data-target="#sales-rep-existing-crud-modal" data-modal-title="Add sales rep"><i class="fa fa-plus"></i> Add sales rep</a>
    </div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">Sales Representatives for {{ucfirst($sales_manager->first_name) }} {{ucfirst($sales_manager->last_name) }} </div>
  <div class="panel-body">
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>Joined on</th>
            <th>Name</th>
            <th>Email</th>
            <th>Clinics</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{$user->created_at}}</td>
            <td>{{$user->first_name}} {{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            <td><span class="label label-default">{{count($user->clinics)}}</span></td>
            <td><a href="{{url('admin/sales-rep/'.$user->id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
          </tr>
          @endforeach
        </tbody>
    </table>

  </div>
</div>

<div id="sales-rep-existing-crud-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/ajax/associate-sales-rep')}}" class="ajax-crud-modal-form form">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add sales rep</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group" style="margin-top:20px">
                        <div class="col-md-3">
                            Sales Rep Name<br/>
                            <select id="clinic" class="form-control select2-field" name="sales_rep_id" style="width:200px;" required>
                                <option selected disabled>Select Sales Rep</option>
                                <?php
                                foreach($sales_reps as $rep):
                                    echo '<option value="'.$rep->id.'">'.ucfirst($rep->first_name).' '. ucfirst($rep->last_name).'</option>';
                                endforeach;
                                ?>
                                <input type="hidden" name="sales_manager_id" value="{{ $sales_manager->id }}">
                            </select>
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
Sales Representatives
@endsection