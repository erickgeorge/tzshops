@extends('layouts.land')

@section('title')
    work order
    @endSection

@section('body')

<?php
    use App\User;



 ?>

 <style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>




<style type="text/css">
.label{
    width: 700px;
}
</style>
<div class="container">
<script>
var total=2;

</script>
    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h5 align="center" style="text-transform: capitalize;">assessment form details</h5>
        </div>
    </div>
    <hr>
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




  @foreach($assessmmentcompany as $company)

    <br>
     <div class="row">
    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Company name</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$company['companyname']->company_name}}"
               aria-describedby="emailHelp" value="" disabled>
    </div>



    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Cleaning area name</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$company['areaname']->cleaning_name}}"
               aria-describedby="emailHelp" value="" disabled>
    </div>

    </div>

    <br>

         <div class="row">
    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Assessment date</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$company->assessment_month}}"
               aria-describedby="emailHelp" value="" disabled>
    </div>



    <div class="input-group mb-3 col">

    </div>

    </div>

    @endforeach

<br>

 <!-- begin of assessment activity -->

<p><u>ACTIVITY FORM</u></p>

 @if(count($crosscheckassessmmentactivity) > 0)

 <table style="width:100%">
  <tr >
    <thead style="color: white;">
    <th style="width: 300px"><b>Activity</b></th>
     <th style="width: 150px"><b>Percentage(%)</b></th>
    <th style="width: 150px"><b>Score(%)</b></th>
     <th style="width: 300px"><b>Remark</b></th>
     </thead>



  </tr>
  <?php
   $sum = 0;
   $summ = 0;
   ?>
  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php   $sum += $assesment->percentage;  $summ += $assesment->score;?>
  <tbody>
  <tr>
   <td>{{$assesment->activity}}</td>
   <td align="center">{{$assesment->percentage}}</td>
    <td align="center">{{$assesment->score}}</td>
    <td>{{$assesment->remark}}</td>
 </tr>
 </tbody>
  @endforeach
  <th><b>Tottal</b></th>
  <td align="center"><b><?php echo $sum ?>%</b></td>
  <td align="center"><b><?php echo $summ ?>%</b></td>
  </table>
   <br>

  @if(($assesment->status == 4)||($assesment->status == 2)||($assesment->status == 3))
  <p><u>Payment description:  <?php echo number_format("$assesment->payment"); ?> Tshs</u><br>

  <u>According to the tottal score of <?php echo $summ ?>% on this month {{$company['companyname']->company_name}} should be payed: <?php $erickpnd = $summ * $assesment->payment * 0.01; echo number_format("$erickpnd"); ?> Tshs</u></p>
  <b>Payment updated by Landscaping Supervisor : {{ $assesment['paymentaccountant']->fname .' ' . $assesment['paymentaccountant']->lname }}  on: {{ $assesment->payment_on }}</b><br>
  @endif



  @if($assesment->status == 1)
  <b>status:</b><b style="color: blue;">  Not Approved</b>
  @elseif(($assesment->status == 2)||($assesment->status == 3))
  <b>Approved by Head PPU : {{ $assesment['approval']->fname .' ' . $assesment['approval']->lname }} on: {{ $assesment->accepted_on }}</b>
  @endif
  <br>

    @if($assesment->status == 3)
  <b>Approved by Estate Director : {{ $assesment['approvalpayment']->fname .' ' . $assesment['approvalpayment']->lname }}  on: {{ $assesment->approved_on }}</b>
  <br>
 @endif










 @else
     <br>
  <p style="color:blue;">No assessment activity form submitted yet</p>
  @endif
    <br><hr>













  @endSection

