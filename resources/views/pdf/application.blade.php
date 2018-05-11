<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<table style="border:1px solid #ccc;padding:10px;width:600px;margin:0 auto;">
  <thead>
    <tr>
      <td style="padding:10px 0;">
        
      </td>
      <td style="text-align:right;">
        <small>www.conductclinicaltrials.com</small><br/>
        <small>info@conductclinicaltrials.com</small>
      </td>
    </tr>
    <tr style="background:#eee;border:1px solid #ccc;padding:10px;">
      <td style="padding:10px;">Agreement signed on: : {{$application->created_at}}</td>
      <td style="padding:10px;text-align:right;">Applied by : {{$application->user->first_name}} {{$application->user->last_name}}</td>
    </tr>
  </thead>
  
  <tbody>
    @if(count($answers))
    @foreach($answers as $answer)
    <tr>
      <td colspan="2" style="padding:15px 0;border-bottom:1px solid #ccc;">
        <p><strong>{{ $answer->question->question }}</strong></p>
        <p>{{ $answer->answer }}</p>
      </td>
    </tr>
    @endforeach
    @endif
    @if(count($application->attachments))
    <tr style="border-top:1px solid #ccc;padding:20px 0;">
      <td style="background:#eee;padding:10px;" colspan="2">
        Files attached : 
        @foreach($application->attachments as $attachment)
          {{$attachment->title}}, 
        @endforeach
      </td>
    </tr>
    @endif
    
    @if($application->investigator_id)
    <tr style="border-top:1px solid #ccc;padding:20px 0;">
      <td style="background:#eee;padding:10px;" colspan="2">
        Applied on behalf of : {{investigator_name($application->investigator_id)}}
      </td>
    </tr>
    @endif
    
    
    <tr style="padding:20px 0;">
      <td style="padding:10px;" colspan="2">
        @if($application->user->applied_as)
          Applied as Partner
        @else
          <span style="font-size:11px;line-height:16px;">
              {!! get_agreement_content($application->user_id) !!}
          </span>
          @if($application->signature)
          <hr/>
          @if(! file_exists(base_path('uploads/signature-'.$application->id.'.png')))
            <?php
              $rawData = $application->signature;
              $filteredData = explode(',', $rawData);
              $unencoded = base64_decode($filteredData[1]);
              $filename = 'uploads/signature-'.$application->id.'.png';
              $fp = fopen(base_path($filename), 'w+');
              fwrite($fp, $unencoded);
              fclose($fp);
            ?>
          @endif
          <img src="{{base_path().'/uploads/signature-'.$application->id.'.png'}}" width="300"/>
          @endif
        @endif
      </td>
    </tr>
    
  </tbody>
</table></body>
</html>