<div id="call-me-back" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Callback Request</h4>
      </div>
      <div class="modal-body">
        <form id="call-me-back-form" method="post" action="{{url('user/callback-request')}}">
          {!! csrf_field() !!}
          <p>Enter the time and phone number you will can be reached at and an admin will give you a call back.</p>
          <p>
          <p><b>Times Available</b></p>
            <p><input type="text" placeholder="&nbsp;Enter times available"></text></p>
            <p><b>Cell Number:</b></p>
            <p><input type="text" placeholder="&nbsp;Enter phone number"></text></p>
          <button type="submit" class="btn btn-primary">Yes, I am reachable</button>
          </p>
        </form>
      </div>
      
    </div>
  </div>
</div>