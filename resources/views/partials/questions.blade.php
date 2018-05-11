<div id="application-question-list">
@if(count($questions))
<div class="panel panel-primary">
    
    <div class="panel-heading">Answer following questions</div>
    
    <div class="panel-body">
    @foreach($questions as $question)
    <div class="form-group">
    <label>{{$question->question}}</label>
    <input type="text" name="answer[{{$question->id}}]" class="form-control" required/>      
    </div>
    @endforeach
    <div class="clearfix"></div>
    </div>
    
    
</div>
@endif
</div>