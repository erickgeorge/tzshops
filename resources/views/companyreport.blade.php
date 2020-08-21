@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<br>
@foreach($assessmmentcompany as $company)
@endforeach
<h5><b>Companies Scores(%) For {{ date('F Y', strtotime($company->assessment_month))}}</b></h5>
<hr>

<html lang="en">
<head>
<script src="https://unpkg.com/tlx/browser/tlx.js"></script>
<script src="https://unpkg.com/tlx-chart/browser/tlx-chart.js"></script>
</head>
<body >



<?php
    use App\User;
    use App\assessmentsheet;
    use App\landassessmentactivityform;
    use App\landcrosschecklandassessmentactivity;
    use App\company;

 ?>






                <div class="d-flex container">
                  <p class="d-flex flex-column">
                    <span>Percentages (%)</span>
                  </p>

                </div>
                <!-- graph -->

                <tlx-chart style="height: 500px" chart-type="ColumnChart"
  chart-columns="${['Element','Percentage']}"


  chart-data="${[

    [, 0],

   @foreach($assessmmentcompany as $company)

     <?php
      $companypayment = company::where('tender', $company->company)->first();
     $crosscheckassessmmentactivity = landcrosschecklandassessmentactivity::where('company', $company->company)->where('area', $company['areaname']->cleaning_name)->where('assessment_sheet', $company->assessment_name)->where('month',$company->assessment_month)->get();
       $summ = 0;
     ?>

    @if(count($crosscheckassessmmentactivity)>0)


  

  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php  $summ += $assesment->score;  ?>
  @endforeach

     [' {{$assesment['assessmentid']['compantwo']->company_name}} , {{$assesment['cleaningarea']->cleaning_name}} ', <?php echo $summ ?> ],

        @endif

   @endforeach


 ]}" >


</tlx-chart>



               <!-- graph -->
                <div class="d-flex flex-row justify-content-end container">
                  <span class="mr-2">
                    </i> Companies, Area
                  </span>
                </div>


<br>




</body>
</html>






@endsection


