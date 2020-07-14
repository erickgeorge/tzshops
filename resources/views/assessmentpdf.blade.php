<div style="margin-top: 20px" align="center">
    
    <p><h2>University of Dar es salaam</h2> <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm"> <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>
   
</div>
<style>
    body { background-image:  url('/images/estatfegrn.jpg');

    /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

    }
   
   .box{
    width:710px;
    height: 130px;
     border: 2px solid #b0aca0;
   }




   .container-name div {
  display: inline-block;
  width: 400px;
  min-height: 50px;
 
  height: auto;
  }


     
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>

   <body>



<?php 
    use App\User;
    use App\assessmentsheet;  
    use App\landassessmentactivityform; 
    use App\landcrosschecklandassessmentactivity;
    use App\company;
 ?>


    



<div class="container">


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
<div class="col"><h4 ><b>This assessment sheet with tender number: {{$assesment->company}} is initiated by:</b></h4></div>
<div class="col"><h4><b>
<table>
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
      <th>{{ $assesment->created_at }}</th> 
  </tr>
  
</table>
</b>
</h4>

</div>

</div>
</div>


      <?php $i = 0; ?>
 @foreach($assessmmentcompanyname as $company)
 <?php $i++ ?>
  <br>


    <div class="row container-fluid">
        <div class="col-lg-12">
          
            <p><h5><b><u>Sheet No:0{{$i}}</u></b></h5><h5 align="center" style="text-transform: uppercase; color: black;"><b><u>assessment Sheet details for {{$company->assessment_name}}</u></b></h5></u>
        </div>
    </div>
   <br>

    <div class="container-name">
     <div class="div1">Company Name:&nbsp;&nbsp;  &nbsp; <b>{{$company['companyname']['compantwo']->company_name}}</b></div>
    <div class="div2"> Area Name: &nbsp;&nbsp;  &nbsp; <b>{{$company['areaname']->cleaning_name}}</b> </div>
   </div>   
       <div class="container-name">
     <div class="div1">Assessment Month:&nbsp;&nbsp;  &nbsp; <b>    <?php  $dnext = strtotime($company->enddate); ?> {{ date('d F Y', strtotime($company->enddate))}} -  {{ date('d F Y', strtotime('+1 month', $dnext)) }}</b></div>
    <div class="div2">  </div>
   </div>  
<br>


    <?php 
      $companypayment = company::where('tender', $company->company)->first();
      $assessmentsheetview = assessmentsheet::where('name', $company->assessment_name)->get();
      $assessmmentactivity = landassessmentactivityform::where('companynew', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();
      $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();

      $sumscore = landcrosschecklandassessmentactivity::where('company', $company->company)->where('month',$company->assessment_month)->select(DB::raw('sum(score) as sum_score'))->first();
     ?>





   <table >

    <thead style=" background-color: #376ad3; color: white; ">
      <tr>
         <th style="width: 20px" ><b>#</b></th>
    <th ><b>Activity</b></th>
     <th style="width: 20px"><b>Percentage(%)</b></th>
    <th style="width: 20px"><b>Score(%)</b></th>
     <th ><b>Remark</b></th>
     </tr>
     </thead>
     
  <?php  
   $sum = 0;
   $summ = 0;
   $i = 0;
  
   ?>
  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php    $i++;   $sum += $assesment->percentage;  $summ += $assesment->score;?>
  <tbody>
  <tr>
    <td>{{$i}}</td>
   <td>{{$assesment->activity}}</td>
   <td style="text-align: center">{{$assesment->percentage}}</td>
    <td  style="text-align: center">{{$assesment->score}}</td>
    <td>{{$assesment->remark}}</td>
    
 </tr>
 </tbody>
  @endforeach
  <th><b>Tottal</b></th>
  <td style="text-align: center"><b><?php echo $sum ?>%</b></td>
  <td style="text-align: center"><b><?php echo $summ ?>%</b></td>
  </table>
   <br>

   <!--crosscheck-->

<table>
  <thead style=" background-color: #376ad3; color: white;">
  <tr style="color:white;"><th>Average score</th><th>Monthly payment</th><th>Payment according to average</th></tr>
 </thead>
 <tbody>
  <tr><td><?php $totalscore = $sumscore->sum_score; $countdata = count($assessmmentcompanyname); $percent = $totalscore/$countdata; echo number_format($percent , 2);  ?>%</td><td><?php $paym=$companypayment->payment; echo number_format($paym); ?> Tshs</td><td>@if($percent >= 90)
<?php $payall=$companypayment->payment; echo number_format($payall); ?> Tshs
@elseif($percent >= 80 )
<?php $pay9=$companypayment->payment*0.9;  echo number_format($pay9); ?> Tshs
@elseif($percent >= 70 )
<?php  $pay8=$companypayment->payment*0.8;  echo number_format($pay8);?> Tshs
@elseif($percent >= 65 )
<?php $pay7=$companypayment->payment*0.7;  echo number_format($pay7);?> Tshs
@elseif($percent >= 50 )
<?php $pay5=$companypayment->payment*0.5;  echo number_format($pay5);?>  Tshs
@elseif($percent < 50)
<?php $pay0=$companypayment->payment*0;  echo number_format($pay0);?> Tshs
@endif</td></tr>
   
 </tbody>
</table>

</br>
@endforeach

<br><br><br>


<table>
    @if(($assesment->a_rejected_by != null))
  <tr>
    <td>Rejected by </td>
     <td> Head PPU </td>
      <td> {{ $assesment['rejection']->fname .' ' . $assesment['rejection']->lname }}</td>
       <td>On: {{ date('d F Y', strtotime($assesment->rejected_on))}} </td>
          <td>Reason: {{$assesment->reason}}</td>
  </tr>
  @endif
     @if(($assesment->es_rejected_by != null))
   <tr>
     <td>Rejected by </td>
    <td>Estates Director</td>
     <td>{{ $assesment['rejectionestate']->fname .' ' . $assesment['rejectionestate']->lname }} </td>
      <td>On: {{ date('d F Y', strtotime($assesment->esrejected_on)) }}</td>
         <td>Reason: {{$assesment->reasonestate}}</td>
  </tr>
  @endif
  @if(($assesment->dvc_rejected_by != null))
   <tr>
     <td>Rejected by </td>
    <td> DVC Admin</td>
    <td>{{ $assesment['rejectiondvc']->fname .' ' . $assesment['rejectiondvc']->lname }}</td>
    <td>On: {{ date('d F Y', strtotime($assesment->dvcrejected_on)) }}</td>
    <td>Reason: {{$assesment->reasondvc}}</td>
  </tr>
  @endif
</table>





<br><br>



  @if($assesment->status == 1)
  <b>status:</b><b style="color: blue;">  Not Approved</b>
  @elseif(($assesment->status == 2)||($assesment->status == 3)||($assesment->status == 4)||($assesment->status == 5))



    <div class="container-name">
     <div class="div1">ASSESSED BY<u style="padding-left: 12px;">  </u></div>
    <div class="div2"> </div>
   </div>
     <br>

    <div class="container-name">
     <div class="div1">Name of Assessor:&nbsp;  &nbsp;<b>{{ $assesment['initiated']->fname .' ' . $assesment['initiated']->lname }}</b><u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Signature:  &nbsp;  .................................. <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date: &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;    <b>{{ date('d F Y', strtotime($assesment->created_at)) }}</b> <u style="padding-left: 40px;">   </u> </div>
   </div>    
<br>

       <div class="container-name">
     <div class="div1">Approved by Head PPU :&nbsp;  &nbsp;<b>{{ $assesment['approval']->fname .' ' . $assesment['approval']->lname }} </b><u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Signature:  &nbsp;  .................................. <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date: &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;    <b>{{ date('d F Y', strtotime($assesment->accepted_on)) }}</b> <u style="padding-left: 40px;">   </u> </div>
   </div>    
<br>
@endif
  
  @if(($assesment->status == 3)||($assesment->status == 4)||($assesment->status == 5))


         <div class="container-name">
     <div class="div1">Approved by Estate Director :&nbsp;  <b>{{ $assesment['approvalpayment']->fname .' ' . $assesment['approvalpayment']->lname }}  </b><u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Signature:  &nbsp;  .................................. <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date: &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;    <b>{{ date('d F Y', strtotime($assesment->approved_on))}}</b> <u style="padding-left: 40px;">   </u> </div>
   </div>    
<br>

 @endif 

 @if(($assesment->status == 4)||($assesment->status == 5))


      <div class="container-name">
     <div class="div1">Approved by DVC Admin :&nbsp;  <b>{{ $assesment['approvaldvc']->fname .' ' . $assesment['approvaldvc']->lname }}  </b><u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Signature:  &nbsp;  .................................. <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date: &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;    <b>{{ date('d F Y', strtotime($assesment->dvaccepted_on))}}</b> <u style="padding-left: 40px;">   </u> </div>
   </div>    
<br>


 @endif 


 @if($assesment->status == 5)




      <div class="container-name">
     <div class="div1">Company paid and verified by :&nbsp;  <b>{{ $assesment['paymentaccountant']->fname .' ' . $assesment['paymentaccountant']->lname }}</b><u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Signature:  &nbsp;  .................................. <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date: &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;    <b>{{ date('d F Y', strtotime($assesment->dvaccepted_on))}}</b> <u style="padding-left: 40px;">   </u> </div>
   </div>    
<br>


 @endif 



  <div class="container-name">
     <div class="div1">Name of company Supervisor: &nbsp;  &nbsp;&nbsp;..................................<u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Title: &nbsp;  &nbsp; ........................................  <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Signature: &nbsp;  &nbsp;   ................................  <u style="padding-left: 40px;">   </u> </div>
   </div>

<br>
   <div class="container-name">
     <div class="div1">Payment: &nbsp;  &nbsp;&nbsp;  &nbsp;..................................................................<u style="padding-left: 12px;"> </u></div>
     <div class="div2"> Signature:  .................................... <u style="padding-left: 40px;">   </u> </div>
    <div class="div2">Date: &nbsp;  &nbsp;  &nbsp;  &nbsp;   .................................... <u style="padding-left: 40px;"> </u> </div>
   
   </div>  

  
      
   </body>



             


<div id='footer'>
    <p class="page">page</p>
</div>   