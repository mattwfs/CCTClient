<div id="admin_confirmation" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Admin Confirmation</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post" class="form">
          <div class="form_response"></div>
          <input type="hidden" name="delete_id" value="" required/>
          <input type="hidden" name="redirect" value="{{url()->current()}}" required/>
        {!! csrf_field() !!}
          <div class="form-group">
            <input type="password" class="form-control" name="admin_password" placeholder="Password"/>
          </div>
          <button id="admin_confirmation_btn" type="submit" class="btn btn-primary">Confirm Delete</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->