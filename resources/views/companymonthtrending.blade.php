@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<div class="container">
<br>
@foreach($assessmmentcompany as $company)
@endforeach
<h5 style="text-transform: capitalize;"><B>SCORES FOR {{$company->month}}'{{$company['companyname']['compantwo']->company_name}}' ON {{ date('F Y', strtotime($company->assessment_month))}}</B></h5>
<hr>

<div class="container">
	 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
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
    @endif</div>


<?php
    use App\User;
    use App\assessmentsheet;
    use App\landassessmentactivityform;
    use App\landcrosschecklandassessmentactivity;
    use App\company;

 ?>



  <?php $tenders = Crypt::encrypt($company->company); ?>

                       <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" >
               <a  href="{{route('trendingscore_report_company' , [ $tenders , $company->assessment_month])}}"
                                                           
                                          style="color: white;" data-toggle="tooltip" title="Print report"> PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                </button>


          <table id="myTable" class="table table-striped">

            <thead>
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
   //   $companypayment = company::where('tender', $company->company)->first();

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
    <!-- <td >{{$assesment['assessmentid']['compantwo']->company_name}}</td>-->
     <td >{{$assesment['cleaningarea']->cleaning_name}}</td>
     <td >{{$assesment->assessment_sheet}}</td>
     <td align="center"><b><?php echo $summ ?></b></td>


     </tr>


 @endif

 @endforeach
   </tbody>
      <?php $erpnd = $summ2/count($assessmmentcompanyname);   ?>


                    <tr><td align="center" colspan="4" >AVERAGE SCORE</td><td align="center"> <?php   echo number_format((float)$erpnd, 2, '.', '')  ?>% </td></tr>

    </table>

<br><br>










@endsection


