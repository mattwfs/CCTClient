@extends('layouts.sales')
@section('main-content')

    <div class="panel panel-primary">



        <div class="panel-heading">
                <div class="row">
                        <div class="col-md-5">Clinics</div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" data-filter="table" data-target="#clinics-table" placeholder="Filter Table"/>
                    </div>
                    <div class="col-md-2">
                        <a href="" class="btn btn-default" data-toggle="modal" data-target="#clinics-crud-modal" data-modal-title="Add new clinic" style="width:100%;"><i class="fa fa-plus"></i> Add clinic</a>
                    </div>

                </div>
        </div>

        <div class="panel-body">
                <table id="clinics-table" class="table table-bordered">
                        <thead>
                                <tr>
                                        <th class="text-info">Clinic name</th>
                                        <th class="text-info">Clinic phone</th>
                                        <th class="text-info">Primary contact</th>
                                        <th class="text-info">Users</th>
                                        <th class="text-info">Applications</th>
                                        <th>Action</th>
                                </tr>
                        </thead>

                        <tbody>
                        @if(count($clinics))
                              @foreach($clinics as $clinic)
                                <tr>
                                <td>{{$clinic->name}}</td>
                                <td>{{$clinic->phone}}</td>
                                <td>{{get_clinic_primary_contact($clinic->id)}}</td>
                                <td>{{count($clinic->users)}}</td>
                                    <td>{{count($clinic->applications)}}</td>
                                <td><a href="{{url('rep/clinics/'.$clinic->id)}}" class="btn btn-default"><i class="fa fa-pencil"></i></a> <a href="{{url('rep/clinic/'.$clinic->id)}}" class="btn btn-default"><i class="fa fa-eye"></i> </a></td>
                                </tr>
                                @endforeach
                        @else
                                <tr>
                                <td colspan="6"><em>You have not added any clinics yet.</em></td>
                                </tr>
                        @endif
                        </tbody>
                </table>
        </div>
</div>

<div id="clinics-crud-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('rep/ajax/clinics/add')}}" class="ajax-crud-modal-form form">
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

    <div id="clinics-existing-crud-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="post" action="{{url('rep/ajax/clinics/associate-clinic')}}" class="ajax-crud-modal-form form">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add existing clinic</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group" style="margin-top:20px">
                            <div class="col-md-3">
                                Clinic Name<br/>
                                <select id="clinic" class="form-control select2-field" name="clinic_id" style="width:200px;" required>
                                    <option selected disabled>Select Clinic</option>
                                    <?php
                                    foreach($all_clinics as $clinic):
                                        echo '<option value="'.$clinic->id.'">'.$clinic->name.'</option>';
                                    endforeach;
                                    ?>
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
        Sales Dashboard
@endsection
