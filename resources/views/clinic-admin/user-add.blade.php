@extends('layouts.users')
@section('main-content')
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
                <div class="panel-heading">Add User</div> 
                <div class="panel-body">
                        <form method="post" action="{{url('user/clinic/create-user')}}" class="form">
                                {!! csrf_field() !!}
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{old('first_name')}}" required/>   
                                    </div> 
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{old('last_name')}}" required/>   
                                    </div> 
                                    <div class="col-md-3">
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}" required/>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="user_type" required>
                                            <option value="" selected disabled>User type</option>
                                            <option value="0">Investigator</option>
                                            <option value="1">Study Coordinator</option>
                                            <option value="2">Point of Contact</option>
                                        </select>
                                    </div>
                                    <!--<div class="col-md-3">
                                        <select class="form-control" name="is_partner" required>
                                                <option value="" selected disabled>User type</option>    
                                                <option value="0">Broker</option>    
                                                <option value="1">Partner</option>    
                                                <option value="2">Special user</option>    
                                        </select>
                                    </div>-->
                                </div>
                                <button type="submit" class="btn btn-primary">Add user</button>
                        </form>
                </div>
        </div>  
     </div>
</div>

@endsection

@section('page_title')
        Add user to clinic
@endsection