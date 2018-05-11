<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle-o" aria-hidden="true"></i>
</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
        <form class="modal-ajax-form" action="{{ url('user-login') }}" method="post">
                {!! csrf_field() !!}
                <div class="row">
                  <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control" placeholder="Email" name="user_email"/>
                      </div>
                  </div>
                  <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="user_password"/>
                      </div>
                  </div>
                  <div class="col-md-12 form-group">
                      <button class="btn btn-primary btn-block" type="submit">Log me in</button>
                  </div>
                </div>
        </form>
        <p><a href="{{url('forgot-password')}}">Forgot password ?</a></p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="registerModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle-o" aria-hidden="true"></i>
</button>
        <h4 class="modal-title">Create account</h4>
      </div>
      <div class="modal-body">
        <form  class="modal-ajax-form"action="{{url('create-account')}}" method="post">
                {!! csrf_field() !!}
                <div class="row form-group">
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="First name" name="first_name"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Last name" name="last_name"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control" placeholder="Email" name="email"/>
                      </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password"/>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <button class="btn btn-primary btn-block" type="submit">Create account</button>
                  </div>
                </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->