@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<br>
<div class="container">

<h5 style="text-transform: capitalize;"><B>TRENDING SCORE FOR "{{$compa}}" WITH DIFFERENT MONTHS </B>
 </h5>
<hr>

  <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger" style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><?php echo $error; ?></li>
                @endforeach
            </ul>
        </div>
    @endif

    </div>
                 <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </button>



                <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
        <?php $tenders = Crypt::encrypt($tender); ?>
    <form method="POST" action="{{route('trendingscore_report' , [ $tenders , $compa])}}">
             @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To  PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">




        <div class="row">


               <div class="col"> From <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>"  class="form-control mr-sm-2"type="month" placeholder="Start Month"
                               max="<?php echo date('Y-m'); ?>">
                </div>

                <div class="col">
                To <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end"  class="form-control mr-sm-2" type="month" placeholder="End Month"
                             max="<?php echo date('Y-m'); ?>">
                </div>
       </div>
<br>








      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>










      <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
          <tr style="color: white;">
               <th >#</th>
                <th >Month</th>
                <th >Percentage(%)</th>
                 <th >Action</th>

            </tr>
            </thead>

            <tbody>

            <?php $i=0; $sumu = 0; ?>
          @foreach($crosscheckassessmmentactivity as $company)


                <?php $i++; $sumu += $company->erick; ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ date('F Y', strtotime($company->month))}}</td>
                    <td > <?php echo number_format($company->erick / count($crosscheckassessmmentactivitygroupbyarea) , 2) ?> </td>


                   <?php $tenderencrypt = Crypt::encrypt($tender); ?>
                   <td><a style="color: green;"  href="{{route('companywithmothtenderreport' , [$company->month , $tenderencrypt])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fas fa-eye"></i></a></td>

                    </tr>
          @endforeach

            </tbody>
             <td align="center" colspan="2">OVERALL COMPANY AVARAGE SCORE</td>
              <td><?php echo number_format($sumu/$i/count($crosscheckassessmmentactivitygroupbyarea),2) ?></td>
        </table>

</div>




@endsection


