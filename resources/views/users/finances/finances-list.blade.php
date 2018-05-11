@extends('layouts.users')
@section('main-content')


@if(count($finances))
<div class="panel panel-info">
<div class="panel-heading">
  <div class="row">
    <div class="col-md-9">
    Finances
    </div>
    <div class="col-md-3">
    <input type="text" class="form-control" data-filter="table" data-target="#finances-table" placeholder="Filter Table Data">
    </div>
  </div>  
</div>
<div class="panel-body" style="max-height:400px;overflow-y:scroll;">
<table id="finances-table" class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Trial</th>
     <th>Amount</th>
   </tr>
 </thead>
  <tbody>
    @foreach($finances as $finance)
    <tr>
      <td>
        <i class="fa fa-calendar text-danger"></i> 
        <small>
          <em>
            {{date("jS M, Y",$finance->payment_date)}}
          </em>
        </small>
      </td>
      <td>{{ $finance->trial->title }}</td>
      <td>{{ $finance->earnings_amount }}</td> 
    </tr>
    @endforeach
   
  </tbody>
</table>  
</div>
</div>
@else
<p><em>There are no financial records for you.</em></p>
@endif



@endsection

@section('page_title')
 Finances
@endsection