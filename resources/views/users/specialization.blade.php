@extends('layouts.users')
@section('main-content')
<h2>{{ ucwords($specialization->name) }}</h2>
<p>
<strong>
<i>
{{$specialization->description}}
</i>
</strong>
</p>
<hr/>
<div class="trials">
    
    @if(count($trials))
        <ul class="trials-list">
        @foreach($trials as $trial)
        <li>
            <a href="{{url('user/trial/'.$trial->id)}}">{{ $trial->title }}</a>
        </li>
        @endforeach
        </ul>
    @else
        No Trail has been added in this specialization group.
    @endif

</div>
{{ $trials->links() }}
@endsection

@section('page_title')
    {{ ucwords($specialization->name) }}
@endsection