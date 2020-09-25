

 <?php
 use App\User;
 use App\assessmentsheet;
 use App\landassessmentactivityform;
 use App\landassessmentbeforesignature;
 use App\landcrosschecklandassessmentactivity;
 use App\company;

?>
<title>assessment Sheet details</title>
<div style="margin-top: 20px" align="center">

    <p><h2>University of Dar es salaam</h2> <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm"> <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>

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


<body class="container">





   @foreach($company as $companyiii)
   @endforeach

<div class="container">



    <div class="row container-fluid">
        <div class="col-lg-12">

           <u> <h5 align="center" style="text-transform: capitalize; color: black;"><b>  assessment Sheet details</b></h5></u>
        </div>
    </div>


<br>


   <div class="container-name">
     <div class="div1">Company Name:&nbsp;&nbsp;  &nbsp; <b>{{$companyname['compantwo']->company_name}}</b></div>
    <div class="div2"> Assessment Period:<b> <?php  $dnext = strtotime($companyiii->nextmonth); ?> {{ date('d F Y', strtotime($companyiii->nextmonth))}} -  {{ date('d F Y', strtotime('+1 month', $dnext)) }}</b></div>
   </div>
    <hr>









 <br>


 <?php  $ii = 0; ?>
   @foreach($company as $companyiii)
   <?php $ii++; ?>

    <div class="row container-fluid">
        <div class="col-lg-12">

            <h5><b>Sheet No: {{$ii}}</b></h5><h5 align="center" style="text-transform: capitalize; color: black;"><b> <u> Sheet name: &nbsp; {{ $companyiii->sheet  }}</u></b></h5>
        </div>
    </div>





    <br>
     <div class="row">




    <div class="input-group mb-3 col">

     Area Name:<b><u> {{$companyiii['are_a']->cleaning_name }}</u> </b>

    </div>

    </div>

    <br>



   <div class="row">



    </div>

     <?php
    $assessmentsheetview = assessmentsheet::where('name', $companyiii->sheet)->get();

    $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $companyiii->tender)->where('area', $companyiii['are_a']->cleaning_name)->where('assessment_sheet', $companyiii->sheet)->where('month',date('Y-m', strtotime($companyiii->nextmonth)))->get();

     $assessmmentactivity = landassessmentactivityform::where('companynew', $companyiii->tender)->where('area', $companyiii['are_a']->cleaning_name)->where('assessment_sheet',  $companyiii->sheet)->where('month',date('Y-m', strtotime($companyiii->nextmonth)))->get();

       $assessmmentsignature = landassessmentbeforesignature::where('companynew', $companyiii->tender)->where('area', $companyiii['are_a']->cleaning_name)->where('assessment_sheet',  $companyiii->sheet)->where('month',date('Y-m', strtotime($companyiii->nextmonth)))->get();
    ?>


    <table class="table table-striped">


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
   $summ = 0;
   $summm = 0;
   $i=0;
   ?>


  <tbody>
  @foreach($assessmmentactivity as $assesment)
   <?php  $i++;  $summ += $assesment->percentage;  $summm += $assesment->score;?>

  <tr>



      <td>{{$i}}</td>
      <TD  >{{$assesment->activity}} </TD>

      <TD>{{$assesment->percentage}} </TD>

      <TD>{{$assesment->percentage}} </TD>

      <TD>{{$assesment->remark}} </TD>



 </tr>

  @endforeach
   </tbody>

 <th><b>Tottal</b></th>
 <td></td>
  <td align="center" ><b><?php echo $summ ?>%</b></td>
  <td align="center"><b><?php echo $summm ?>%</b></td>



  </table>



    <br>
    <br>



<br>


  @endforeach



</div>




<br>
<br>



<p>ASSESSED BY</p>
<br>
   <div class="container-name">
     <div class="div1">Name of assessor: &nbsp;  &nbsp;&nbsp;  &nbsp;......................................................<u style="padding-left: 12px;"> </u></div>
     <div class="div2"> Signature:  .................................... <u style="padding-left: 40px;">   </u> </div>
    <div class="div2">Date: &nbsp;  &nbsp;  &nbsp;  &nbsp;   .................................... <u style="padding-left: 40px;"> </u> </div>

   </div>
<br>

  <div class="container-name">
     <div class="div1">Name of company Supervisor: &nbsp;  &nbsp;&nbsp;..................................<u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Title: &nbsp;  &nbsp; ........................................  <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Signature: &nbsp;  &nbsp;   ................................  <u style="padding-left: 40px;">   </u> </div>
   </div>

<br>




   </body>






<div id='footer'>
    <p class="page">Page-</p>
</div>
