<title>tenders Details</title>
<div style="margin-top: 20px" align="center">


    <p><h2>University of Dar es salaam</h2>  <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <div style="background-image: url('img_girl.jpg');"> <h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;">tenders Details</b></p>
</div><br>

<style>
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
.nameee{
    text-transform:uppercase;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>


 <?php use Carbon\Carbon;?>


                <table id="myTableee" id="myTable" class="table table-striped">

                    <thead style="  background-color: #376ad3;">
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Area Name</th>
                        <th scope="col">Company Name</th>
                         <th scope="col">Contract type</th>
                        <th scope="col">Starting of Tender</th>
                        <th scope="col">Ending of Tender</th>

                      <!--  <th scope="col">Next Assessment</th>-->
                        <th scope="col">Contract Duration</th>

                    </tr>
                    </thead>


                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($tenderpdf as $house)
                        <?php $i++; ?>

                <?php $now1 =  Carbon::now();

                $next30day = strtotime($house->datecontract);
                $next30days = date("Y-m-d", strtotime("+1 month", $next30day));

                $dcont = Carbon::parse($house->datecontract);
                $dnext = Carbon::parse($house->nextmonth);
                $endcont = Carbon::parse($house->endcontract);

                $date_left = $now1->diffInDays($next30days);
                $date_next = $now1->diffInDays($dnext); ?>


                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['are_a']->cleaning_name }}</td>
                            <td>{{ $house['compantwo']->company_name }}</td>
                             <td>{{ $house->type }}</td>
                            <td>{{ $house->datecontract }}</td>
                             <td>{{ $house->endcontract }}</td>






                <?php $date = Carbon::parse($house->datecontract);
                 $now = Carbon::parse($house->endcontract);
                 $diff = $date->diffInDays($now); ?>



        @if($now1 > $endcont)
                           <td><span class="badge badge-danger">Contract expired </span></td>
        @else

                 @if($diff >= 365)

                           <td><?php


                             $start_date = new DateTime();
                             $end_date = (new $start_date)->add(new DateInterval("P{$diff}D") );
                             $dd = date_diff($start_date,$end_date);
                             echo $dd->y." years ".$dd->m." months ".$dd->d." days"; ?></td>




                   @else

                           <td><?php


                             $start_date = new DateTime();
                             $end_date = (new $start_date)->add(new DateInterval("P{$diff}D") );
                             $dd = date_diff($start_date,$end_date);
                             echo $dd->m." months ".$dd->d." days"; ?></td>




                  @endif
               @endif






                        </tr>
                    @endforeach
                    </tbody>

                </table>



                <div id='footer'>
                    <p class="page">Page-</p>
                </div>
