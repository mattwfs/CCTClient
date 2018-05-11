<div id="add-finance-modal" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <form method="post" action="{{url('admin/add-finance')}}" class="form ajax-crud-modal-form">
    <input type="hidden" name="user_id" value="{{$user->id}}"/>
    {!! csrf_field() !!}
  
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Finance</h4>
      </div>
      <div class="modal-body">
        
          <div class="row form-group">
            
              <div class="col-md-6">
                Payment Date : 
                <input type="text" name="date" class="form-control date_picker" required/>
              </div>
            
              <div class="col-md-6">
                Study Title :
                  <select class="form-control" name="trial_id">
                @foreach($trials as $trial)
                      <option value="{{ $trial->id }}">{{ $trial->title }}</option>
                @endforeach
                  </select>
              </div>
            
          </div>
          
          <div class="row form-group">

            
              <div class="col-md-6">
                Amount Received :
                <input type="text" name="earning_amount" class="form-control" required/>
              </div>


              <div class="col-md-6">
                Attach File (optional) :
                  <input type="file" name="attachment" id="finance-attachment" data-upload-url="{{url('ajax-upload-file')}}"/>

              </div>
            
          </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
    
    </form>
</div>