@extends('layouts.sales')
@section('main-content')
<div class="row">
@if(count($specializations))
<div class="col-md-12">
        <div class="panel panel-info">
                <div class="panel-heading">Open Trials - {{count($trials)}}

                    <span style="float:right">Filter by <select id="specialization-filter">
                            <option value="0">View All</option>
                            @foreach($specializations as $group)
                            <option value="{{$group->id}}">{{strtoupper($group->name)}}</option>
                            @endforeach
                        </select>
                    </span>

                </div>

                <div class="panel-body">
                        <div id="user-update">
                        <ul class="trials-list">
                                @foreach($trials as $trial)
                                <li><a href="{{url('rep/trial/'.$trial->id)}}">{{$trial->title}}</a></li>
                                @endforeach
                        </ul>
                        </div>
                </div>
        </div>
@else
  <div class="alert alert-danger">
          <h4><strong>It looks like your clinics have not joined any group yet.</strong></h4>
  </div>
@endif
</div>
</div>

<script type="text/javascript">
    $("#specialization-filter").on('change',function(){
        if($(this).val()==0){
            window.location.href = "{{ url('rep/open-trials')}}";
        } else {
            window.location.href = "{{url('rep/specialization/')}}"+"/"+$(this).val();
        }
    });
</script>



@endsection

@section('page_title')
        Open Trials
@endsection
@push('scripts')
@endpush