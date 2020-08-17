@foreach($assessmmentcompany as $company)
@endforeach
<title>ASSESSMENT REPORT ON  {{ date('F Y', strtotime($company->assessment_month))}} </title>
<div style="margin-top: 20px" align="center">

    <p><h2>University of Dar es salaam</h2>
     <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">  <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>

    <p><b><u style="text-transform: uppercase;" >ASSESSMENT REPORT ON  {{ date('F Y', strtotime($company->assessment_month))}} </u></b></p>
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
    <?php use App\landcrosschecklandassessmentactivity;  ?>


          <table id="myTable" class="table table-striped">

            <thead style="background-color: #376ad3;">
              <tr style="color: white;">
                        <th scope="col">#</th>
                         <th scope="col">Tender Number</th>
                        <th scope="col">Company name</th>

                        <th scope="col">Area assessed</th>
                       <th scope="col">Assessment sheet</th>
                        <th scope="col">Scores(%)</th>
                         <th scope="col">Comment</th>

            </tr>
          </thead>
              <tbody>


<?php $i = 0; $sum = 0; $summ2= 0; ?>

           @foreach($assessmmentcompany as $company)
           <?php $i++;   ?>
     <?php
   //   $companypayment = company::where('tender', $company->company)->first();

     $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();
       $summ = 0;
     ?>


  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php  $summ += $assesment->score; $summ2 += $assesment->score; ?>
  @endforeach

  <?php  ?>

     <tr>
     <td >{{$i}}</td>
     <td >{{$assesment->company}}</td>
     <td >{{$assesment['assessmentid']['compantwo']->company_name}}</td>
     <td >{{$assesment['cleaningarea']->cleaning_name}}</td>
     <td >{{$assesment->assessment_sheet}}</td>
     <td align="center"><b><?php echo $summ ?></b></td>
     <td>{{$assesment->comment}}</td>



     </tr>




 @endforeach
   </tbody>
      <?php $erpnd = $summ2/count($assessmmentcompany);   ?>


                    <tr><td align="center" colspan="5" >AVERAGE SCORE</td><td align="center"> <?php   echo number_format((float)$erpnd, 2, '.', '')  ?>% </td></tr>

    </table>

<br><br>



       @if(count($crosscheckassessmmentactivity)>0)




                                             @if($company->status2 == 2)
                                              <b>Approved and fowarded to DVC by landscaping Supervisor : {{$company['assessorname']->fname .'   '. $company['assessorname']->lname}} on:  {{ date('d F Y', strtotime($company->assessordate))}}  </b>

                                             @endif









@endif


   </body>






<div id='footer'>
    <p class="page">page</p>
</div>
