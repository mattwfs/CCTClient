@extends('layouts.users')
@section('main-content')
    @if($trial->deleted_at)
        <div class="alert alert-danger">
            <strong>This trial is no longer available.</strong>
        </div>
    @else
        
<a class="text-danger" href="{{url('user/specialization/'.$trial->specialization->id)}}">
    <i class="fa fa-tags"></i> 
    {{ strtoupper($trial->specialization->name )}}
</a>


<div class="panel panel-primary">
    <div class="panel-heading">{{ ucwords($trial->title) }}</div>
    
    <div class="panel-body">
        @if($trial->expires_on)
        <p class="text-danger">
            <small>
            @if(is_trial_expired($trial->id) && $trial->no_waitlist==0)
        Trial Expired : Please note, trial is waitlisted, however we do encourage you to apply in case it opens.
            @elseif(is_trial_expired($trial->id) && $trial->no_waitlist==1)
                Trial Expired: No longer looking for sites
            @else
        Accepting Applications Until : {{date("jS M Y",$trial->expires_on)}}                         
            @endif
            </small>
        </p>
        <hr/>
        @endif
        
        @if(count($attachments))
<p>
@foreach($attachments as $attachment)
<a target="_blank" class="btn btn-default" href="{{url('uploads/'.$attachment->file)}}"><i class="fa fa-file"></i> {{ $attachment->title }}</a>
@endforeach
</p>
<hr/>
@endif
        
        
    {!! $trial->description !!}
    </div>

    <div class="panel-footer">

        <p class="text-danger" id="ajax-message"></p>
        <form method="post" action="{{url('user/apply')}}" class="text-center">
            {!! csrf_field() !!}
            <input type="hidden" name="trial" value="{{$trial->id}}"/>
            @if(!is_trial_expired($trial->id) || $trial->no_waitlist==0)
            <?php $investigators = get_investigators_list(auth()->user()->clinic_id); ?>
            <div class="row">
                <div class="col-md-6">
                <select id="select-investigator" name="investigator" class="form-control select2-field" data-trial_id="{{$trial->id}}" data-user_id="{{auth()->user()->id}}" data-url="{{url('user-has-applied')}}" data-token="{{csrf_token()}}">
                    <option value="0">No Investigator</option>
                    @foreach($investigators as $inv)
                    <option value="{{$inv->id}}">{{$inv->first_name}} {{$inv->last_name}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <br/>
            @endif
            @if(can_apply($trial->id))
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-sm btn-block" style="border:2px solid black; font-size:16px;">Apply</button>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-sm btn-block btn-warning" style="font-size:16px;">Decline</button>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-6">
                </div>
            </div>
            @endif

        </form>

    </div>
</div>

<p class="text-center">

@if(can_referr($trial->id))
<a data-toggle="modal" data-target="#referral-modal" href="#" class="btn btn-success btn-lg">
    <i class="fa fa-user" aria-hidden="true"></i>
    Refer a Colleague
</a>
@endif

@if(can_apply($trial->id) && can_set_reminder($trial->id))
<a data-toggle="modal" data-target="#reminder-modal" href="#" class="btn btn-warning btn-lg">
    <i class="fa fa-clock-o" aria-hidden="true"></i> 
    Remind me Later
</a>
@endif
    
</p>


@if(can_referr($trial->id))
<div id="referral-modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Refer a colleague</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{url('user/referral/colleague')}}" class="form modal-ajax-form">
          {!! csrf_field() !!}
            <input type="hidden" name="trial_id" value="{{$trial->id}}"/>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Colleague&apos;s Email" required/>
            </div>
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Colleague&apos;s name" required/>
            </div>
            <p><button type="submit" class="btn btn-primary">Submit</button></p>
        </form>
      </div>
    </div>
  </div>
</div>
@endif

@if(can_apply($trial->id) && can_set_reminder($trial->id))
<div id="reminder-modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remind me later</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('user/set-reminder') }}" class="form modal-ajax-form">
          {!! csrf_field() !!}
            <input type="hidden" name="trial_id" value="{{$trial->id}}"/>
            <p><label><input type="radio" name="remind_after" value="1"/>&nbsp;&nbsp;In 1 Hour</label></p>
            <p><label><input type="radio" name="remind_after" value="2"/>&nbsp;&nbsp;In 2 Hours</label></p>
            <p><label><input type="radio" name="remind_after" value="3"/>&nbsp;&nbsp;In 3 Hours</label></p>
            <p><label><input type="radio" name="remind_after" value="5"/>&nbsp;&nbsp;In 5 Hours</label></p>
            <p><label><input type="radio" name="remind_after" value="12"/>&nbsp;&nbsp;In 12 Hours</label></p>
            <p><label><input type="radio" name="remind_after" value="24"/>&nbsp;&nbsp;In 24 Hours</label></p>
            <p><button type="submit" class="btn btn-primary">Submit</button></p>
        </form>
      </div>
    </div>
  </div>
</div>
@endif
    @endif
@endsection

@section('page_title')
    {{ ucwords($trial->title) }}
@endsection

@push('scripts')
<script>
$(function(){
    var investigator_field = $("#select-investigator");
    if(investigator_field.length==1){
        var investigator = investigator_field.find("option:selected").val();
        var user_id = investigator_field.attr("data-user_id");
        var trial_id = investigator_field.attr("data-trial_id");
        var submit_btn = $("#trial-apply-btn");
        var message = $("#ajax-message");
        var url = $("#select-investigator").attr("data-url");
        var token = $("#select-investigator").attr("data-token");
        message_text = 'You have already applied for this trial for selected Investigator.';
        var message_text;
        submit_btn.hide();
        
        $.post(
        url,
        {
            _token:token,
            investigator_id:investigator,
            trial_id:trial_id,
            user_id:user_id
        },
            function(data){
                if(data==0){
                    submit_btn.show();
                }
                else{
                    if(investigator == 0){
                        message_text = 'You have already applied for this trial.';
                    }
                    message.text(message_text);
                }
            }
        );
        
        
        
        $("#select-investigator").on("change",function(e){
                submit_btn.hide();
                message.text('');
                investigator = investigator_field.find("option:selected").val();
                
                $.post(
                url,
                {
                    _token:token,
                    investigator_id:investigator,
                    trial_id:trial_id,
                    user_id:user_id
                },
                    function(data){
                        if(data==0){
                            submit_btn.show();
                        }
                        else{
                            if(investigator == 0){
                                message_text = 'You have already applied for this trial.';
                            }
                            message.text(message_text);
                        }
                    }
                );
        });
        
        
        
            
        }
});

</script>
@endpush