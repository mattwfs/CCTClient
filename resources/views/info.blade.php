@extends('layouts.wrapper')
@section('main-layout')

 <!--start #main-content-->
<div class="inner-content pad">
  <div class="container">
    <?php
    if(! isset($label)){
      $label = 'warning';
    }
    if(! isset($message)){
      $message = 'We could not process your request.';
    }
    if(! isset($title)){
      $title = 'Something went wrong';
    }
    ?>
    <div>
      <div class="text-center alert alert-{{ $label }}">
        
          <h4>{{ $title}} !</h4>
          <p>{{ $message }}</p>
        
      </div>
    </div>
    
    <div>
    </div>
   
  </div>
</div>
 <!--end #main-content-->
@endsection