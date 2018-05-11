@extends('layouts.admin')
@section('main-content')
<div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-3">
        <input type="text" class="form-control" data-filter="table" data-target="#clinics-table" placeholder="Filter Table"/>
    </div>
    <div class="col-md-3">
        @if(!empty($sales_rep))
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#clinics-crud-modal" data-modal-title="Add new clinic"><i class="fa fa-plus"></i> Add existing clinic</a>
        @else
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#clinics-crud-modal" data-modal-title="Add new clinic"><i class="fa fa-plus"></i> Add clinic</a>
        @endif
    </div>
</div>
<div class="panel panel-primary">

  <div class="panel-heading">Clinics
  @if(!empty($sales_rep))
      for {{ ucfirst($sales_rep->first_name) }} {{ ucfirst($sales_rep->last_name) }}
  @endif
  </div>
  <div class="panel-body">
    <table id="clinics-table" class="table table-bordered">
        <thead>
          <tr>
            <th>Clinic Name</th>
            <th>Clinic Phone</th>
            <th>Clinic Address</th>
              <th>Specializations</th>
              <td>Approved</td>
            <th>Users</th>
          </tr>
        </thead>
      
        <tbody>
          @foreach($clinics as $clinic)
          <tr
          @if(!$clinic->is_active)
            style="color:red;"
          @endif
          >
            <td>{{$clinic->name}}</td>
            <td>{{$clinic->phone}}</td>
            <td>{{$clinic->address}}</td>
              <td class="col-md-4">
                  @foreach($clinic->specializations as $specialization)
                  <span style="margin-bottom:2px;display:inline-block;" class="label label-default">{{$specialization->name}}</span>&nbsp;&nbsp;
                  @endforeach
              </td>
              <td>
                  @if($clinic->is_approved==1)
                  <span class="fa fa-check text-success"></span> Approved
                  @elseif($clinic->is_approved==0)
                  <span class="fa fa-exclamation text-danger"></span> Not Approved
                  @endif
              </td>
            <td>

                <a class="btn btn-default" href="{{url('admin/clinics/'.$clinic->id)}}"><i class="fa fa-pencil"></i></a>
              <a href="{{url('admin/clinic/'.$clinic->id)}}" class="btn btn-danger">
              <i class="fa fa-users"></i> {{count($clinic->users)}}
              </a>
                <a class="btn btn-danger delete-admin-confirmation" href="#" data-url="{{url('admin/clinic/delete')}}" data-toggle="modal" data-target="#admin_confirmation" data-id="{{$clinic->id}}"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
  </div>
</div>



<div id="clinics-crud-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/ajax/clinics/add')}}" class="ajax-crud-modal-form form">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add clinic</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group" style="margin-top:20px">
                        <div class="col-md-3">
                            Clinic Name
                            <input type="text" class="form-control" name="clinic_name" placeholder="Your clinic name" required/>
                        </div>
                    </div>
                    <div class="row form-group" style="margin-top:20px">
                        <div class="col-md-3">
                            Clinic Street address
                            <input type="text" class="form-control" name="clinic_address" placeholder="Street address, APT no." required/>
                        </div>

                        <div class="col-md-3">
                            Clinic City
                            <input type="text" class="form-control" name="clinic_city" placeholder="City" required/>
                        </div>

                        <div class="col-md-3">
                            Clinic Zip Code
                            <input type="text" class="form-control" name="clinic_zipcode" placeholder="Zip code" required/>
                        </div>

                        <div class="col-md-3">
                            Clinic State<br/>
                            <select id="states" class="form-control select2-field" name="clinic_state" required>
                                <option selected disabled>Select state</option>
                                <?php
                                $states = get_states();
                                foreach($states as $code => $name):
                                    echo '<option value="'.$code.'">'.$name.'</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">

                        <div class="col-md-3">
                            Clinic Phone Number
                            <input type="tel" class="form-control" name="clinic_phone" maxlength="10" minlength="10" required/>
                        </div>
                        <div class="col-md-3">
                            Clinic Fax Number
                            <input type="tel" class="form-control" name="clinic_fax" maxlength="10" minlength="10" />
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

@include('partials.admin.admin_confirmation')

@endsection
@section('page_title')
Sales Representatives
@endsection