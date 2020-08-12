<div style="margin-top: 20px" align="center">

    <p><h2>University of Dar es salaam</h2>
     <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">  <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>

@foreach($assessmmentcompany as $company)
@endforeach

<p style="text-transform: uppercase; text-align: center;"><B><u>TRENDING SCORE FOR "{{$company['companyname']['compantwo']->company_name}}" ON {{ date('F Y', strtotime($company->assessment_month))}}  </u></B>
 </p>
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






<div class="container">




<?php
    use App\User;
    use App\assessmentsheet;
    use App\landassessmentactivityform;
    use App\landcrosschecklandassessmentactivity;
    use App\company;

 ?>





          <table id="myTable" class="table table-striped">

              <thead style="background-color: #376ad3;">
              <tr style="color: white;">
                        <th scope="col">#</th>
                         <th scope="col">Tender Number</th>


                        <th scope="col">Area assessed</th>
                       <th scope="col">Assessment sheet</th>
                        <th scope="col">Scores(%)</th>

            </tr>
          </thead>
              <tbody>


<?php $i = 0; $sum = 0; $summ2= 0; ?>

           @foreach($assessmmentcompanyname as $company)
           <?php $i++;   ?>
     <?php

     $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();
       $summ = 0;
     ?>
     @if(count($crosscheckassessmmentactivity)>0)

  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php  $summ += $assesment->score; $summ2 += $assesment->score; ?>
  @endforeach

  <?php  ?>

     <tr>
     <td >{{$i}}</td>
     <td >{{$assesment->company}}</td>
     <td >{{$assesment['cleaningarea']->cleaning_name}}</td>
     <td >{{$assesment->assessment_sheet}}</td>
     <td align="center"><b><?php echo $summ ?></b></td>


     </tr>


 @endif

 @endforeach
   </tbody>
   <?php $erpnd = $summ2/count($assessmmentcompanyname);   ?>


                    <tr><td align="center" colspan="4" ><b>AVERAGE SCORE</b></td><td align="center"> <b><?php   echo number_format((float)$erpnd, 2, '.', '')  ?></b> </td></tr>


    </table>

<br><br>










</div>









   </body>






<div id='footer'>
    <p class="page">page</p>
</div>
