@extends('layouts.wrapper')
@section('main-layout')

 <!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <div>
      <div class="text-center alert alert-danger">
        
          <h2>{{$title}} !</h2>
        <p>{{ $message }}</p>
        
      </div>
    </div>
    
    <div>
    </div>
   
  </div>
</div>
 <!--end #main-content-->
@endsection
@section('page_title')
{{$title}}
@endsection