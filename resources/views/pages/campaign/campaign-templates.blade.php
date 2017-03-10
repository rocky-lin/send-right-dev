@extends('layouts.app')
@section('content')



{{-- <br><br>
@include('pages.include.other.campaign-header-steps',  ['currentStep' => 'Select Template'])
<br>
 --}}

 <br><br><br>

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Basic</a></li>
    <li><a data-toggle="tab" href="#menu1">Theme</a></li>
    <li><a data-toggle="tab" href="#menu2">Code your own</a></li> 
  </ul>

  <div >
    <div id="home" class="tab-pane fade in active">
      @include('pages/include/template/template-basic') 
    </div>
    <div id="menu1" class="tab-pane fade"> 
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div> 
  </div>
</div>



 
@endsection
