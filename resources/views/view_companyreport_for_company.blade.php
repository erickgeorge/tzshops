@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<br>
<div class="container">
<h5 style="text-transform: capitalize;"><b>Trending Score For "{{$compa}}" With Different Months </B>
 </h5>
<hr>

<html lang="en">
<head>
<script src="https://unpkg.com/tlx/browser/tlx.js"></script>
<script src="https://unpkg.com/tlx-chart/browser/tlx-chart.js"></script>
</head>
<body >








                <div class="d-flex container">
                  <p class="d-flex flex-column">
                    <span>Percentages (%)</span>
                  </p>

                </div>
                <!-- graph -->

                <tlx-chart style="height: 500px" chart-type="LineChart"
  chart-columns="${['Element','Percentage']}"


  chart-data="${[


            <?php $i=0; $sumu = 0; ?>
          @foreach($crosscheckassessmmentactivity as $company)


                <?php $i++; $sumu += $company->erick; ?>
                
    

     [' {{ date('F Y', strtotime($company->month))}} ', <?php echo number_format($company->erick / count($crosscheckassessmmentactivitygroupbyarea) , 2) ?> ],

      

   @endforeach


 ]}" >


</tlx-chart>



               <!-- graph -->
                <div class="d-flex flex-row justify-content-end container">
                  <span class="mr-2">
                    </i> Months
                  </span>
                </div>


<br>




</body>
</div>
</html>






@endsection


