@extends('layouts.users')
@section('main-content')
<form method="post" action="{{url('user/post-application')}}" class="form" enctype="multipart/form-data">
<input type="hidden" name="trial_id" value="{{ $trial->id }}"/>
@if($investigator !='')
<input type="hidden" name="investigator_id" value="{{ $investigator->id }}"/>
@else
<input type="hidden" name="investigator_id" value="0"/>
@endif
{!! csrf_field() !!}
<h4>
<strong>You are applying for : </strong>
<small class="text-danger">{{ ucfirst($trial->title) }}</small>
</h4>
    

<h4>
<strong>Applying on behalf of : </strong>
<small class="text-danger">{{ ucfirst($investigator->first_name) }} {{ ucfirst($investigator->last_name) }}</small>
</h4>

@include('partials.questions')

@if($trial->requires_file)
<hr/>
Attach File:<br/>
<input type="file" name="application_attachment[]" required multiple/>
<hr/>
@endif


@if($user->is_partner == 0 || $user->is_partner==2)
@if(! is_first_referral_application($user->id))
<div class="panel panel-primary">
    <div class="panel-heading">Agreement</div>
    <div class="panel-body" style="font-size:13px;line-height:18px;">
        {!! get_agreement_content() !!}
    </div>
    
    <div class="panel-footer">
        <div class="signature-holder">
            <p><strong>Sign on the space below:</strong></p>
        </div>
        
        <div id="signature"></div>
        <input type="hidden" id="signature_data" name="signature_data" value="{{old('signature_data')}}" required/>
        <button type="button" class="reset-sign">Reset signature</button>
    </div>
</div>
    
<label>
<input id="accept_agreement" type="checkbox" name="broker_agreement" required/> I accept to Investigators' terms &amp; conditions and agree that I have signatory rights to sign this legally binding document on behalf of the clinic..
</label>  

    
    @push('scripts')
    <script type="text/javascript" src="{{asset('assets/js/flashcanvas.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jSignature.js')}}"></script>
    <script>
    $(function(){
        $("#apply-btn").hide();
        
        $("#signature").jSignature({color:"#000",lineWidth:2});
     
         //reset signature div
        $(".reset-sign").on("click",function(){
          $("#signature").jSignature("clear");  
        });
        
        
        
        $("#accept_agreement").on("click",function(){
         if ($(this).is(':checked')) {
                $('#apply-btn').show();
            }else{
                $('#apply-btn').hide();  
            }
        });
        
        
        $("#apply-btn").on("click",function(e){
         e.preventDefault();
         
             var datapair = $("#signature").jSignature("getData");

             if(!$("#signature").jSignature('getData', 'native').length == 0){
                 $("#signature_data").val(datapair);
                 $(this).parents("form").submit();
                }
            else{
             alert('You must provide your signature.');
         }
        });
        
    });
    </script>
    @endpush
@endif
@endif
    
<p>
<button id="apply-btn" type="submit" class="btn btn-primary btn-lg">
    <i class="fa fa-check"></i> 
     Submit Application
</button>    
</p>
</form>

@endsection




@section('css_link')
<style>
    #signature{background:#fff;}
</style>
@endsection

@section('page_title')
    Application : {{ ucwords($trial->title) }}
@endsection