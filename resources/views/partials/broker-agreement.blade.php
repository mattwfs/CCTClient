<div id="brokers-agreement-modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">InvestigatorAgreement</h4>
      </div>
      <div class="modal-body">
        {!! get_agreement_content() !!}
      </div>
      <div class="modal-footer">
        <p>
                Agreed to this date of: 
                <strong class="text-danger">{{date("jS M, Y")}}</strong><br/>
                Investor's name: 
                <strong class="text-danger">{{$user->first_name.' '.$user->last_name}}</strong>
            </p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->