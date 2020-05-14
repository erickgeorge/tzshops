@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<br>
@foreach($assessmmentcompany as $company)
@endforeach
<h5 style="text-transform: uppercase;">COMPANY SCORES(%) ACCORDING TO ASSESSMENT ON {{ date('F Y', strtotime($company->assessment_month))}}</h5>
<hr>

<html lang="en">
<head>
<script src="https://unpkg.com/tlx/browser/tlx.js"></script>
<script src="https://unpkg.com/tlx-chart/browser/tlx-chart.js"></script>
</head>
<body >


<tlx-chart style="height: 500px" chart-type="ColumnChart"
  chart-columns="${['Element','Percentage']}" 


  chart-data="${[
   @foreach($assessmmentcompany as $company)
     ['{{$company['companyname']->company_name}} , {{$company['areaname']->cleaning_name}} ', {{$company->score}} ],
   @endforeach 
 ]}" >


</tlx-chart>


</body>
</html>




@endsection


