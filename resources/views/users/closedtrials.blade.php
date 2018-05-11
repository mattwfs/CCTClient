@extends('layouts.users')
@section('main-content')
<div class="row">
@if(count(auth()->user()->specializations))
<div class="col-md-12">
        <div class="panel panel-info">
                <div class="panel-heading">Closed Trials - {{count($trials)}} - <a href="{{ url('user/open-trials')}}">Click here to view Open Trials</a>

                    <span style="float:right">Filter by <select id="specialization-filter">
                            <option value="0">View All</option>
                            @foreach(auth()->user()->specializations as $group)
                            <option value="{{$group->id}}"
                                @if($group->id == $specialization)
                                    selected
                                @endif
                            >{{strtoupper($group->name)}}</option>
                            @endforeach
                        </select>
                    </span>

                </div>

                <div class="panel-body">
                        <div id="user-update">
                        <ul class="trials-list">
                                @foreach($trials as $trial)
                                <li><a href="{{url('user/trial/'.$trial->id)}}">{{$trial->title}}</a></li>
                                @endforeach
                        </ul>
                        </div>
                </div>
        </div>
@else
  <div class="alert alert-danger">
          <h4><strong>looks like you have not joined any group yet.</strong></h4>
          <p>Click on menu at top right, from the dropdown select "Edit Profile" and join group from the field named <strong>"Specialization"</strong></p>
          <p><small><em>Note : You can join multiple groups too</em></small></p>
  </div>
@endif
</div>
</div>

<script type="text/javascript">
    $("#specialization-filter").on('change',function(){
        if($(this).val()==0){
            window.location.href = "{{ url('user/closed-trials')}}";
        } else {
            window.location.href = "{{url('user/specialization/')}}"+"/"+$(this).val();
        }
    });
</script>

@endsection

@section('page_title')
        Open Trials
@endsection
