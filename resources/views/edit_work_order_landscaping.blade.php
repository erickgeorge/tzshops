@extends('layouts.land')

@section('title')
    Assessment form
    @endSection

@section('body')

<?php
    use App\User;
    use App\assessmentsheet;
    use App\landassessmentactivityform;
    use App\landcrosschecklandassessmentactivity;
    use App\company;
 ?>


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

 @foreach($assessmmentcompanyname as $company)
 @endforeach



     <?php
    $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();
     ?>
      @foreach($crosscheckassessmmentactivity as $assesment)
      @endforeach
 <br>
<div class="jumbotron">
  <div class="row">
<div class="col"><h6 ><b>Assessment sheet for tender number: {{$assesment->company}} is initiated by:</b></h6></div>
<div class="col"><h6 >
 <table class="table table-striped  display" style="width:100%">
  <tr>
    <th>Full name</th>
      <th>{{ $assesment['initiated']->fname .' ' . $assesment['initiated']->lname }}</th>
  </tr>

    <tr>
    <th>Phone</th>
      <th>{{ $assesment['initiated']->phone }}</th>
  </tr>

    <tr>
    <th>Email</th>
      <th> {{ $assesment['initiated']->email}}</th>
  </tr>

    <tr>
    <th>Initiated on </th>
      <th>{{ date('d F Y', strtotime($assesment->created_at))}}</th>
  </tr>

</table>

</h6>

</div>

</div>
</div>





<div class="container">

  <div class="row container-fluid">
        <div class="col-lg-12">

            <h5 align="center" style="text-transform: capitalize; color: black;"><b>  assessment Sheet details</b></h5>
        </div>
    </div>
    <hr>

   <div class="row">
     <div class="col">


    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Company name</label>
        </div>
        <input  required class="form-control" placeholder="{{$company['companyname']['compantwo']->company_name}} "
               aria-describedby="emailHelp" disabled="disabled" >
    </div>

     </div>
     <div class="col">

   <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Assessment period</label>
        </div>
        <?php  $dnext = strtotime($company->enddate); ?>
        <input style="color: black" type="text" required class="form-control" placeholder=" {{ date('d F Y', strtotime($company->enddate))}} -  {{ date('d F Y', strtotime('+1 month', $dnext)) }} "
               aria-describedby="emailHelp" value="" disabled>
    </div>

     </div>



   </div>


 <br>






<?php   $ii = 0; ?>
 @foreach($assessmmentcompanyname as $company)
 <?php $ii++;  ?>


<br>


    <div class="row container-fluid">
        <div class="col-lg-12">

            <h5><b><!--Sheet No:0{{$ii}}--></b></h5><h5 align="center" style="text-transform: capitalize; color: black;"><b>  sheet name: {{$company->assessment_name}}</b></h5>
        </div>
    </div>
    <hr>





    <br>
     <div class="row">




    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Area name</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$company['areaname']->cleaning_name}}"
               aria-describedby="emailHelp" value="" disabled>
    </div>

    </div>

    <br>



    <?php
      $companypayment = company::where('tender', $company->company)->first();
      $assessmentsheetview = assessmentsheet::where('name', $company->assessment_name)->get();
      $assessmmentactivity = landassessmentactivityform::where('companynew', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();
      $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();

      $sumscore = landcrosschecklandassessmentactivity::where('company', $company->company)->where('month',$company->assessment_month)->where('area', $company['areaname']->cleaning_name)->select(DB::raw('sum(score) as sum_score'))->first();
     ?>



  <br>

     @foreach($crosscheckassessmmentactivity as $statuscheck)
     @endforeach


  @if(count($crosscheckassessmmentactivity) == 0)


  @if(count($assessmmentactivity) == 0)

      <table class="table table-striped">
      <tr>
         <thead style="color: white;">
        <th style="width:20px" >#</th>
        <th style="width:400px" >Activity</th>
        <th style="width:40px">Percentage(%)</th>
        <th style="width:110px">Score(%)</th>
        <th>Remark</th>
      </thead>
      </tr>

     <tbody>

      @foreach($assessmentsheetview as $assess)

       <?php $cmp = Crypt::encrypt($company->company); ?>
       <form method="POST" action="{{ route('work.assessment.activity.landscaping', [$company->id , $cmp , $company->assessment_month]) }}">
                    @csrf

    <TABLE >

        <TR>

            <input  name="assessment_sheet[]" value="{{$assess->name}}"  hidden >
              <input  name="area[]" value="{{$company['areaname']->cleaning_name}}"  hidden >

             <TD><input   style="width: 559px; height: 65px;" class="form-control" type="text" name="activity[]" placeholder="{{$assess->activity}}" value="{{$assess->activity}}"  readonly="readonly" ></TD>



             <TD><input style="width: 112px; text-align: center;" class="form-control" type="number"   name="percentage[]" placeholder="{{$assess->percentage}}" value="{{$assess->percentage}}" readonly="readonly"></TD>


            <TD><input style="width: 112px; text-align: center;" class="form-control" type="number" id="tstock"   name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" min="0" max="{{$assess->percentage}}"></TD>


           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD>

        </TR>


    @endforeach
          </tbody>


    </TABLE>

    @else


<div>
    <table class="table table-striped">
      <tr>
         <thead style="color: white;">
        <th style="width:20px" >#</th>
        <th style="width:400px" >Activity</th>
        <th style="width:40px">Percentage(%)</th>
        <th style="width:110px">Score(%)</th>
        <th>Remark</th>
      </thead>
      </tr>

     <tbody>

   <?php $cmp = Crypt::encrypt($company->company); ?>
     <form method="POST" action="{{ route('croscheck.assessment.activity.landscapingsecond', [$company->id  , $cmp , $company->assessment_month]) }}">
                    @csrf

   <?php
   $summ = 0;
   $summm = 0;
   ?>


  @foreach($assessmmentactivity as $assesment)
   <?php   $summ += $assesment->percentage;  $summm += $assesment->score;?>


  <tr>
      <input  name="assessment_sheet[]" value ="{{$assesment->assessment_sheet}}" hidden="hidden">
      <input  name="areaid[]" value ="{{$company->area_id}}" hidden="hidden">
      <input  name="area[]" value="{{$company['areaname']->cleaning_name}}"  hidden >

      <TD  ><input  style="width: 559px;" class="form-control" type="text" name="activity[]" placeholder="activity..." value="{{$assesment->activity}}" required="required" readonly="readonly" ></TD>

      <TD><input style="width: 112px; text-align: center;"    min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="{{$assesment->percentage}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="{{$assesment->percentage}}" required="required" readonly="readonly">    </TD>

      <TD><input style="width: 112px; text-align: center;" class="form-control" type="number"  name="score[]" placeholder="{{$assesment->score}}" value="{{$assesment->score}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required" min="0" max="{{$assesment->percentage}}" ></TD>

       <TD><input  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="{{$assesment->remark}}" value="{{$assesment->remark}}" ></TD>

 </tr>

  @endforeach
   </tbody>

 <th><b>Total</b></th>
  <td align="center" ><b><?php echo $summ ?>%</b></td>
  <td align="center"><b><?php echo $summm ?>%</b></td>



  </table>



    <br>
    <br>
 @endif





 @elseif(($statuscheck->status == 10)||($statuscheck->status == 11)||($statuscheck->status == 12)||($statuscheck->status == 30))

 <!--rejection-->



   <table class="table table-striped">
      <tr>
         <thead style="color: white;">
        <th style="width:20px" >#</th>
        <th style="width:400px" >Activity</th>
        <th style="width:40px">Percentage(%)</th>
        <th style="width:110px">Score(%)</th>
        <th>Remark</th>
      </thead>
      </tr>

     <tbody>


   <?php $i=0;

   $summ = 0;

  ?>
  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php $i++; $summ += $assesment->score; ?>

   <?php $tender = Crypt::encrypt($company->company); ?>
     <form method="POST" action="{{ route('edited.assessment.activity.landscaping', [$assesment->assessment_id , $tender , $company->assessment_month]) }}">
                    @csrf


  <tr>
    <td>{{$i}}</td>
        <input  name="assessment_sheet[]" value ="{{$assesment->assessment_sheet}}" hidden="hidden">
         <input  name="areaid[]" value ="{{$company->area_id}}" hidden="hidden">
        <input  name="area[]" value="{{$company['areaname']->cleaning_name}}"  hidden >
        <input  name="activity[]" value="{{$assesment->activity}}"  hidden >


      <TD  ><textarea class="form-control" type="text"  placeholder="{{$assesment->activity}}" required="required" readonly="readonly"></textarea> </TD>

      <TD><input oninput="totalitem()"  id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="{{$assesment->percentage}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="{{$assesment->percentage}}" required="required" readonly="readonly">    </TD>




        <TD>  <input style=" text-align: center;" required class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  name="score[]" id="txthour{{$i}}" onkeypress="return isNumberKey(event);  function isNumberKey(e)
                        {
                            var exString = $('#txthour{{$i}}').val();
                            var newString = exString + String.fromCharCode(e.keyCode);

                            if (isNaN(newString))
                            {

                            }

                            if (newString > {{$assesment->percentage}})
                            {
                                e.preventDefault();
                            }
                        }"  placeholder="{{$assesment->score}}"  value="{{$assesment->score}}" ></TD>

       <TD><input class="form-control" type="text" name="remark[]" placeholder="{{$assesment->remark}}" value="{{$assesment->remark}}" ></TD>



 </tr>



  @endforeach

 </tbody>

  </table>






 <!--rejection-->

 @else
 <!--crosscheck-->


 <table class="table table-striped  display" style="width:100%">
      <tr>
         <thead style="color: white;">
        <th style="width:20px" >#</th>
        <th style="width:400px" >Activity</th>
        <th style="width:40px">Percentage(%)</th>
        <th style="width:110px">Score(%)</th>
        <th>Remark</th>
      </thead>
      </tr>

     <tbody>



  </tr>
  <?php
   $sum = 0;
   $summ = 0;
    $i = 0;

   ?>
   <tbody>
  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php  $i++;   $sum += $assesment->percentage;  $summ += $assesment->score;?>

  <tr>
    <td>{{$i}}</td>
   <td>{{$assesment->activity}}</td>
   <td align="center">{{$assesment->percentage}}</td>
    <td align="center">{{$assesment->score}}</td>
    <td>{{$assesment->remark}}</td>

 </tr>

  @endforeach
   </tbody>
  <td align="center" colspan="2"><b>Total</b></td>
  <td align="center"><b><?php echo $sum ?>%</b></td>
  <td align="center"><b><?php echo $summ ?>%</b></td>
  </table>
   <br>

   <!--crosscheck-->



 @endif



 <table class="table table-striped  display" style="width:100%">
  <thead>
  <tr style="color:white;"><th>Area name</th><th>Total score</th><th>Monthly payment</th><th>Ammount to be paid</th></tr>
 </thead>


 <tbody>
  <tr>
<td>{{$company['areaname']->cleaning_name}}</td><td><?php echo $summ ?>%</td><td><?php $paym=$company->paymentone; echo number_format($paym); ?>
 Tshs</td>

<td>@if($summ >= 90)
<?php $payall=$company->paymentone; echo number_format($payall); ?> Tshs
@elseif($summ >= 80 )
<?php $pay9=$company->paymentone*0.9;  echo number_format($pay9); ?> Tshs
@elseif($summ >= 70 )
<?php  $pay8=$company->paymentone*0.8;  echo number_format($pay8);?> Tshs
@elseif($summ >= 65 )
<?php $pay7=$company->paymentone*0.7;  echo number_format($pay7);?> Tshs
@elseif($summ >= 50 )
<?php $pay5=$company->paymentone*0.5;  echo number_format($pay5);?>  Tshs
@elseif($summ < 50)
<?php $pay0=$company->paymentone*0;  echo number_format($pay0);?> Tshs
@endif</td>




</tr>

 </tbody>

</table>

<br>
<hr>




 @endforeach





<br>

    @foreach($assessmmentactivity as $assesmentstatus)
    @endforeach
      @if((auth()->user()->type == 'Supervisor Landscaping')||(auth()->user()->type == 'USAB') || (auth()->user()->type == 'Administrative officer'))
      @if(count($assessmmentactivity) == 0) <button id="bt" type="submit" class="btn btn-primary">Save</button>
      @elseif($assesmentstatus->status == 1)
       <button id="bt" type="submit" class="btn btn-primary" title="You will not able to edit after final save">Final save</button>
       @elseif(($statuscheck->status == 10)||($statuscheck->status == 11)||($statuscheck->status == 12)||($statuscheck->status == 30))
           <button id="bt" type="submit" class="btn btn-primary">Save</button> @endif @endif

   @if(count($crosscheckassessmmentactivity) > 0)
<!--avarage-->
</br>



</br>

<!--avarage-->
@endif

 <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-warning">Back to Top</button></a>


</form>

<br>







 <!-- begin of assessment activity -->


 @if(count($crosscheckassessmmentactivity) > 0)


  @if(($assesment->a_rejected_by != null))
  <b>Rejected by Estates Officer : {{ $assesment['rejection']->fname .' ' . $assesment['rejection']->lname }}  on:  {{ date('d F Y', strtotime($assesment->rejected_on))}}   <td> <a onclick="myfunc5('{{$assesment->reason}}')"><span data-toggle="modal" data-target="#viewreason"
                                                                         class="badge badge-danger">View Reason</span></a></td></b><br>@endif

   @if(($assesment->es_rejected_by != null))

  <b>Rejected by Estates Director : {{ $assesment['rejectionestate']->fname .' ' . $assesment['rejectionestate']->lname }}  on: {{ date('d F Y', strtotime($assesment->esrejected_on)) }}     <td> <a onclick="myfunc6('{{$assesment->reasonestate}}')"><span data-toggle="modal" data-target="#viewreasonestate"
                                                                         class="badge badge-danger">View Reason</span></a></td></b> @endif


  <br>



   @if(($assesment->dvc_rejected_by != null))

  <b>Rejected by {{$assesment['rejectiondvc']->type}} : {{ $assesment['rejectiondvc']->fname .' ' . $assesment['rejectiondvc']->lname }}  on: {{ date('d F Y', strtotime($assesment->dvcrejected_on)) }}     <td> <a onclick="myfunc7('{{$assesment->reasondvc}}')"><span data-toggle="modal" data-target="#viewreasondean"
                                                                         class="badge badge-danger">View Reason</span></a></td></b> @endif


  <br>
  <br>


     @if(($assesment->dean_rejected_by != null))

  <b>Rejected by {{$assesment['deanreject']->type}} : {{ $assesment['deanreject']->fname .' ' . $assesment['deanreject']->lname }}  on: {{ date('d F Y', strtotime($assesment->deanrejected_on)) }}     <td> <a onclick="myfunc8('{{$assesment->reasondean}}')"><span data-toggle="modal" data-target="#viewreasondeanonly"
                                                                         class="badge badge-danger">View Reason</span></a></td></b> @endif


<br>
<br>


  @if(($assesment->status == 1)||($assesment->status == 2)||($assesment->status == 3)||($assesment->status == 4)||($assesment->status == 5) and ($assesment->status2 == 2))

  <b>Approved by Dean of Student : {{ $assesment['deanstudent']->fname .' ' . $assesment['deanstudent']->lname }} on:  {{ date('d F Y', strtotime($assesment->dean_date))}}  </b> <br>

   @elseif(($assesment->status == 1)||($assesment->status == 2)||($assesment->status == 3)||($assesment->status == 4)||($assesment->status == 5) and ($assesment->status2 == 4))

  <b>Approved by {{ $assesment['principles']->type }} : {{ $assesment['principles']->fname .' ' . $assesment['principles']->lname }} on:  {{ date('d F Y', strtotime($assesment->principle_date))}}  </b> <br>

  @else
   @if((auth()->user()->type == 'Supervisor Landscaping')||(auth()->user()->type == 'USAB') || (auth()->user()->type == 'Administrative officer'))
  <!--<b>status:</b><b style="color: blue;">  Not yet approved.</b>-->
  @endif
  @endif


  @if(($assesment->status == 2)||($assesment->status == 3)||($assesment->status == 4)||($assesment->status == 5))
  <b>Approved by Estates Officer : {{ $assesment['approval']->fname .' ' . $assesment['approval']->lname }} on:  {{ date('d F Y', strtotime($assesment->accepted_on))}}  </b>
  @endif
  <br>


  @if(auth()->user()->type == 'Dean of Student')
  @if(($assesment->status == 1) and ($assesment->status2 == 1) )
  <?php $tender = Crypt::encrypt($assesment->company); ?>
  <b style="padding-left: 800px;">Approve <a href="{{route('approveassessmentdean', [$assesment->assessment_id , $tender , $assesment->month])}}" title="Approve assessment form  "><i style="color: blue;" class="far fa-check-circle"></i> </a></b> <br>
     <b style="padding-left: 800px;">Reject <a data-toggle="modal" data-target="#deanonly"
                                                            style="color: green;"
                                           data-toggle="tooltip" title="Reject assessment form with reason "><i  class="fas fa-times-circle" style="color: red" ></i></a> </b>
 @endif
 @endif


 @if((auth()->user()->type == 'Principal') || (auth()->user()->type == 'Directorate Director') || (auth()->user()->type == 'Dean of Student'))
  @if(($assesment->status == 1) and ($assesment->status2 == 3) )
  <?php $tender = Crypt::encrypt($assesment->company); ?>
  <b style="padding-left: 800px;">Approve <a href="{{route('approveassessmentprinciple', [$assesment->assessment_id , $tender , $assesment->month])}}" title="Approve assessment form  "><i style="color: blue;" class="far fa-check-circle"></i> </a></b> <br>
     <b style="padding-left: 800px;">Reject <a data-toggle="modal" data-target="#rejectdean"
                                                            style="color: green;"
                                           data-toggle="tooltip" title="Reject assessment form with reason "><i  class="fas fa-times-circle" style="color: red" ></i></a> </b>
 @endif
 @endif


  @if(auth()->user()->type == 'Estates officer')
  @if($assesment->status == 1)
  <?php $tender = Crypt::encrypt($assesment->company); ?>
  <b style="padding-left: 800px;">Approve <a href="{{route('approveassessment', [$assesment->assessment_id , $tender , $assesment->month])}}" title="Approve assessment form  "><i style="color: blue;" class="far fa-check-circle"></i> </a></b> <br>
     <b style="padding-left: 800px;">Reject <a data-toggle="modal" data-target="#rejectppu"
                                                            style="color: green;"
                                           data-toggle="tooltip" title="Reject assessment form with reason "><i  class="fas fa-times-circle" style="color: red" ></i></a> </b>
  @endif
  @endif


  @if(auth()->user()->type == 'Estates Director')
   @if($assesment->status == 2)
    <?php $tender = Crypt::encrypt($assesment->company); ?>
  <b style="padding-left: 800px;">Approve<a href="{{route('approveassessmentforpayment', [$assesment->assessment_id , $tender  , $assesment->month])}}" title="Approve assessment form "><i style="color: blue;" class="far fa-check-circle"></i> </a></b><br> <b style="padding-left: 800px;">Reject <a data-toggle="modal" data-target="#rejectestate"
                                                            style="color: green;"
                                           data-toggle="tooltip" title="Reject assessment form with reason "><i  class="fas fa-times-circle" style="color: red" ></i></a> </b>
   @endif
   @endif

  @if(($assesment->status == 3)||($assesment->status == 4)||($assesment->status == 5))
  <b>Approved by Estates Director : {{ $assesment['approvalpayment']->fname .' ' . $assesment['approvalpayment']->lname }}  on: {{ date('d F Y', strtotime($assesment->approved_on))}}</b>
  <br>
 @endif





 @if($assesment->status == 5)
  <b>Company paid and updated by : {{ $assesment['paymentaccountant']->fname .' ' . $assesment['paymentaccountant']->lname }}  on: {{ date('d F Y', strtotime($assesment->payment_on))}}</b>
  <br>
 @endif



     @if(auth()->user()->type == 'Supervisor Landscaping')
   @if($assesment->status == 1)
  <!--<b style="padding-left: 800px;">Update payment <a data-toggle="modal" data-target="#payment"
                                                            style="color: green;"
                                           data-toggle="tooltip" title="Update payment"><i class="fas fa-edit"></i></a> </b>-->
   @endif
   @endif

<br>
   @if(auth()->user()->type == 'Dvc Accountant')
          @if($assesment->status == 5)
    <?php $tender = Crypt::encrypt($assesment->company); ?>

      <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" >
                 <a style="color: white;" href="{{route('assessmentpdfform', [$assesment->id,$tender, $assesment->month ])}}" title="Assessment sheet pdf">Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                </button>
           @else
  <?php $tender = Crypt::encrypt($assesment->company); ?>

      <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" >
                 <a style="color: white;" href="{{route('assessmentpdfform', [$assesment->id,$tender, $assesment->month ])}}" title="Assessment sheet pdf"> Download for Signature <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                </button>
            @endif
   @endif

 <br>
 <br>
  <br>
     @if(auth()->user()->type == 'Dvc Accountant')
     @if($assesment->status == 3)
           <?php $tender = Crypt::encrypt($assesment->company); ?>
             <form method="GET"
                    onsubmit="return confirm('Are you sure company is paid? ')"
                    action="{{route('approveassessmentifpaid', [$assesment->assessment_id , $tender , $assesment->month])}}">
                  {{csrf_field()}}
                  Company is Paid
                  <button style="width:20px;height:20px;padding:0px;" type="submit"
                          title="Tick if Company is Paid" style="color: blue;" data-toggle="tooltip">
                        <i style="color: blue;" class="far fa-check-circle"></i> </button>
              </form>
     @endif
     @endif

<br>

@if(auth()->user()->type != 'Dvc Accountant')
 <?php $tender = Crypt::encrypt($assesment->company); ?>
                <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" >
                 <a style="color: white;" href="{{route('assessmentpdfform', [$assesment->id,$tender, $assesment->month ])}}" title="Assessment sheet pdf"> Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                </button>

                <br>
                <br>
@endif







    <!--Update Payment-->
    <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>UPDATE PAYMENT</b></h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <form method="POST" action="{{route('updatepayment', [$assesment->assessment_id])}}">
                             @csrf

                        <input style="color: black" type="number" required class="form-control"   maxlength = "30"
                               name="payment" placeholder="Update Payment ..." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                               <br>


                               <button type="submit" class="btn btn-primary">Save</button>
                    </form>


                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




    <!--reject by Estates officer-->
    <div class="modal fade" id="rejectppu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>REJECT ASSESSMENT FORM</b></h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <?php $tender = Crypt::encrypt($assesment->company); ?>
                   <form method="POST" action="{{route('rejectwithreasonassessment', [$assesment->assessment_id , $tender , $assesment->month])}}">
                             @csrf

                        <textarea style="color: black" type="number" required class="form-control"
                               name="reason" placeholder="Give reason ..."  required></textarea>
                               <br>


                               <button type="submit" class="btn btn-danger">Reject</button>
                    </form>


                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



     <!-- Modal for view Reason -->
    <div class="modal fade" id="viewreason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red;"><b></b> Rejection reason from Estate Officer .</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h5 id="reason"><b> </b></h5>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




    <!--reject by ESTATE DIRECTOR-->
    <div class="modal fade" id="rejectestate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>REJECT ASSESSMENT FORM</b></h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $tender = Crypt::encrypt($assesment->company); ?>
                   <form method="POST" action="{{route('rejectwithreasonassessmentestate', [$assesment->assessment_id , $tender , $assesment->month])}}">
                             @csrf

                        <textarea style="color: black" type="number" required class="form-control"
                               name="reason" placeholder="Give reason ..."  required></textarea>
                               <br>


                               <button type="submit" class="btn btn-danger">Reject</button>
                    </form>


                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



         <!-- Modal for view Reason dean/principle-->
    <div class="modal fade" id="viewreasondean" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red;"><b></b> Rejection reason from Dean/Principal/Directorates Director.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h5 id="resondvc"><b> </b></h5>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


             <!-- Modal for view Reason deanonly-->
    <div class="modal fade" id="viewreasondeanonly" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red;"><b></b> Rejection reason from Dean of student.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h5 id="resondeanonly"><b> </b></h5>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



     <!-- Modal for view Reason ESTATE-->
    <div class="modal fade" id="viewreasonestate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red;"><b></b> Rejection reason from Estate Director.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h5 id="resonestates"><b> </b></h5>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>





    <!--reject by dean only-->
    <div class="modal fade" id="deanonly" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>REJECT ASSESSMENT FORM</b></h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <?php $tender = Crypt::encrypt($assesment->company); ?>
                   <form method="POST" action="{{route('rejectwithreasonassessmentdeanonly', [$assesment->assessment_id , $tender , $assesment->month])}}">
                             @csrf

                        <textarea style="color: black" type="number" required class="form-control"
                               name="reason" placeholder="Give reason ..."  required></textarea>
                               <br>


                               <button type="submit" class="btn btn-danger">Reject</button>
                    </form>


                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



    <!--reject by DVC-->
    <div class="modal fade" id="rejectdean" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>REJECT ASSESSMENT FORM</b></h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <?php $tender = Crypt::encrypt($assesment->company); ?>
                   <form method="POST" action="{{route('rejectwithreasonassessmentdean', [$assesment->assessment_id , $tender , $assesment->month])}}">
                             @csrf

                        <textarea style="color: black" type="number" required class="form-control"
                               name="reason" placeholder="Give reason ..."  required></textarea>
                               <br>


                               <button type="submit" class="btn btn-danger">Reject</button>
                    </form>


                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>









 @else
    @if(auth()->user()->type != 'Supervisor Landscaping')
<p style="color: red;">No assessment form submitted yet</p>
     @endif
  @endif
    <br>














<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>


<SCRIPT language="javascript">
        function addRow(tableID) {

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;



            for(var i=0; i<colCount; i++)
             {

                var newcell = row.insertCell(i);

                newcell.innerHTML = table.rows[0].cells[i].innerHTML;

                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;


                }



            }


        }



        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>


        <script type="text/javascript">

   function myfunc5(x) {
            document.getElementById("reason").innerHTML = x;
        }

         function myfunc6(x) {
            document.getElementById("resonestates").innerHTML = x;
  }


        function myfunc7(x) {
            document.getElementById("resondvc").innerHTML = x;
  }

          function myfunc8(x) {
            document.getElementById("resondeanonly").innerHTML = x;
  }

   </script>


      <script>
function totalitem() {
  var x = 0;
  var y = document.getElementById("istock").value;
  var z  = parseInt(x) + parseInt(y);
  document.getElementById("tstock").value=z;
  document.getElementById("tstock").innerHTML = z;
}
</script>












  @endSection

