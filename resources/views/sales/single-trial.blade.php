@extends('layouts.sales')
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
            @if(is_trial_expired($trial->id))
        Trial Expired : Contact Us at hello@cctclient.com to be put on the wait list for this trial
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

</div>

<p class="text-center">

@if(can_apply($trial->id) && can_set_reminder($trial->id))
<a data-toggle="modal" data-target="#reminder-modal" href="#" class="btn btn-warning btn-lg">
    <i class="fa fa-clock-o" aria-hidden="true"></i> 
    Remind me Later
</a>
@endif
    
</p>


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