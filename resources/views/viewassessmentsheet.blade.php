@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<br>


 @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
 

<h5 align="center" style="text-transform: uppercase;">
 ASSESSMENT SHEET DETAILS </h5>
<hr>
<div class="container">
<div class="row">
	<div class="col">
   <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Name</label>
        </div>
        <input style="color: black; width: 34px;" type="text" required class="form-control" placeholder="{{$assessmmentcompany->name}}" name="problem"
               aria-describedby="emailHelp"  disabled>
    </div>
      </div>


 

<div class="col">
     <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type</label>
        </div>


        <input style="color: black" type="text" required class="form-control" placeholder="{{$assessmmentcompany->type}}" name="location"
               aria-describedby="emailHelp"  disabled>
    </div>
 </div>   


 </div>

</div>


<div class="container">

   <table class="table table-striped" id="myTable">
       
         <thead style="color: white;">
            <tr>
             <th >#</th>
        <th style="width: 950px">Activity</th>
        <th style="width: 200px">Percentage(%)</th>
         </tr>
      </thead>
    


       <?php  
   $summ = 0;
   $summm = 0;
   $i = 0;
   ?>
    <tbody>
  @foreach($assessmmentactivity as $assesment)
   <?php $i++;   $summ += $assesment->percentage; ?>

 
  <tr>
       <TD>{{$i}}</TD>

      <TD  >{{$assesment->activity}}</TD> 
           
      <TD align="center"  >{{$assesment->percentage}}</TD> 
          
 </tr>

  @endforeach
   </tbody>

     <tr><td  align="center" colspan="2" >TOTAL PERCENTAGE</td><td  align="center">{{ $summ}}% </td></tr>  


     </table>




 <!--<form method="POST"  action="{{ route('edit.assessment.sheet', [$assessmmentcompany->name]) }}" >
                    @csrf

</form>-->

  </div>




@endsection


