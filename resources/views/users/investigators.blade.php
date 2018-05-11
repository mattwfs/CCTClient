@extends('layouts.users')
@section('main-content')
<div class="panel panel-default">
        <div class="panel-heading"><strong>Additional Investigators</strong></div>
        <div class="panel panel-body">
                <table class="table table-bordered table-striped">
                  <thead>
                   <tr>
                     <th>Name</th>
                     <th>Medical License</th>
                     <th>License expiry</th>
                       <th>License</th>
                     <th style="width:20%;">Action</th>        
                   </tr>
                  </thead>
                        
             <tbody>
                <?php $investigators = get_investigators_list(); ?>
                @if($investigators)
                @foreach($investigators as $inv)
                <form method="post" action="{{url('user/investigator/update')}}" class="form">
                <tr>
                  <td>
                     {!! csrf_field() !!}
                     <input type="hidden" name="id" value="{{$inv->id}}"/>
<input type="text" name="name" class="form-control" placeholder="Name" value ="{{$inv->name}}" required>
                  </td>
                    <td>
<input type="text" name="license" class="form-control" placeholder="License" value ="{{$inv->license}}" required> 
                    </td>
                    <td>
<input type="text" name="license_expiry" class="form-control date_picker" placeholder="License expiry" value ="{{$inv->license_expiry}}" required> 
                    </td>
                    <td>
                        <input type="file" name="license_upload" class="form-control" placeholder="Upload File">
                    </td>
                  <td style="width:20%;">
<button type="submit" class="btn btn-primary btn-block">Update</button>
                  </td>          
                        
                </tr>
               </form>
                @endforeach
                @endif
             </tbody>
              <form class="" action="{{url('user/investigator/add')}}" method="post">
                   {!! csrf_field() !!}          
             <tfooter>
                <tr>
                <td colspan="2">&nbsp;</td>
                </tr>
                <tr style="background:#333;">
                   
                <th>
                   <input class="form-control" type="text" name="name" placeholder="Name" required>      
                </th>
                <th>
                   <input type="text" name="license" class="form-control" placeholder="License" value ="" required>       
                </th>
                <th>
                   <input type="text" name="license_expiry" class="form-control date_picker" placeholder="License expiry" value ="" required>       
                </th>
                <th>
                    <input type="file" name="license_upload" class="form-control" placeholder="Upload File">
                </th>
                <th with="20%">
                   <button type="submit" class="btn btn-danger btn-block">Add</button>      
                </th>
                   
                </tr>
              </tfooter>
                 </form>
         </table>
        </div>
</div>
@endsection

@section('page_title')
        Investigators
@endsection

@push('scripts')
<script>
$(function(){
   
});
</script>
@endpush