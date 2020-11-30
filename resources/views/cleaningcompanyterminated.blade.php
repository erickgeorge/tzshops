@extends('layouts.land')

@section('title')
Companies
    @endSection

@section('body')
    <br>
   <?php use Carbon\Carbon;?>

<div class="container">


       <div >

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

                  <h4 ><b >Companies with Terminated Contracts</b></h4>

                  <hr>

                       <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" >
                <a href="{{route('landscapingcleaningcompanyreportterminated')}}"
                target="_blank" 
                                         style="color: white;"  data-toggle="tooltip" title="Print report"> Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i> </a>
                </button>

                     @if((auth()->user()->type == 'Supervisor Landscaping')||($role['user_role']['role_id'] == 1))
                   <div class="row"><div class="col">
                  <!--<a href="{{ route('renew_company_contract') }}"
                   class="btn btn-primary" >Add new company</a> -->@endif <a href="{{ route('cleaning_company') }}"
                   class="btn btn-primary" >Active Companies</a> </div>



                   </div><br>
                   <div  class="container">

                <table id="myTableee" id="myTable" class="table table-striped">

                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Company Name</th>
                       <!-- <th scope="col">Monthly Payment (Tshs)</th>-->
                        <th scope="col">Contract Type</th>
                        <th scope="col">Contract Duration</th>
                       
                        <th scope="col">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php $i = 0; ?>

      @if(auth()->user()->type == 'Supervisor Landscaping')

                    @foreach($cleangcompany as $house)

                      @if( $house['tendercompany']->type == 'Exterior')

                        <?php $i++; ?>


                 <?php $date = Carbon::parse($house->datecontract);
                 $now = Carbon::parse($house->endcontract);
                 $diff = $date->diffInDays($now);

                 $now1 =  Carbon::now();

                 $endcont = Carbon::parse($house->endcontract);?>



                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['tendercompany']->company_name }}</td>
                              <td>{{ $house['tendercompany']->type }}</td>
                            @if($house->status == 1)
                           <!-- <td align="right"><?php echo number_format($house->payment) ?></td>-->
                            @else
                            <!--<td> <span class="badge badge-warning"> Not yet Updated</span> </td>-->
                            @endif



                            @if($house->status == 1)



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





                            @else
                            <td> <span class="badge badge-warning"> Not yet Updated</span> </td>
                            @endif
                

                           <td><?php $tender = Crypt::encrypt($house->tender ); ?>
                          <a style="color: green;"  href="{{route('view_company_report_for_company' , [ $tender,  $house['tendercompany']->company_name ])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fa fa-bar-chart"></i></a>&nbsp;&nbsp;
                          <a style="color: green;"
                                       onclick="myfunc('{{ $house->id }}','{{ $house->ter_reason }}','{{ $house['tendercompany']->company_name }}' )"
                                       data-toggle="modal" data-target="#editHouse" title="Reason For Termination"><i
                                                class="fas fa-eye"></i></a>
                          </td>
                          


                         



                        </tr>




                @endif

                    @endforeach

 @endif




@if((auth()->user()->type == 'Administrative officer')||(auth()->user()->type == 'Warden')||(auth()->user()->type == 'Principal'))

                    @foreach($cleangcompany as $house)

                       @if( $house['tendercompany']->type == 'Interior')

                        <?php $i++; ?>


                 <?php $date = Carbon::parse($house->datecontract);
                 $now = Carbon::parse($house->endcontract);
                 $diff = $date->diffInDays($now);

                 $now1 =  Carbon::now();

                 $endcont = Carbon::parse($house->endcontract);?>

 


                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['tendercompany']->company_name }}</td>
                              <td>{{ $house['tendercompany']->type }}</td>
                            @if($house->status == 1)
                           <!-- <td align="right"><?php echo number_format($house->payment) ?></td>-->
                            @else
                            <!--<td> <span class="badge badge-warning"> Not yet Updated</span> </td>-->
                            @endif



                            @if($house->status == 1)



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





                            @else
                            <td> <span class="badge badge-warning"> Not yet Updated</span> </td>
                            @endif


                           <td><?php $tender = Crypt::encrypt($house->tender ); ?>
                          <a style="color: green;"  href="{{route('view_company_report_for_company' , [ $tender,  $house['tendercompany']->company_name ])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fa fa-bar-chart"></i></a>&nbsp;&nbsp;
                          <a style="color: green;"
                                       onclick="myfunc('{{ $house->id }}','{{ $house->ter_reason }}','{{ $house['tendercompany']->company_name }}' )"
                                       data-toggle="modal" data-target="#editHouse" title="Reason For Termination"><i
                                                class="fas fa-eye"></i></a>
                          </td>
                          



                         </tr>
                @endif

                    @endforeach

 @endif




  @if((auth()->user()->type != 'Supervisor Landscaping') and (auth()->user()->type != 'Administrative officer') and (auth()->user()->type != 'Warden') and (auth()->user()->type != 'Principal'))

                    @foreach($cleangcompany as $house)


                        <?php $i++; ?>


                 <?php $date = Carbon::parse($house->datecontract);
                 $now = Carbon::parse($house->endcontract);
                 $diff = $date->diffInDays($now);

                 $now1 =  Carbon::now();

                 $endcont = Carbon::parse($house->endcontract);?>




                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['tendercompany']->company_name }}</td>
                              <td>{{ $house['tendercompany']->type }}</td>
                            @if($house->status == 1)
                           <!-- <td align="right"><?php echo number_format($house->payment) ?></td>-->
                            @else
                            <!--<td> <span class="badge badge-warning"> Not yet Updated</span> </td>-->
                            @endif



                            @if($house->status == 1)



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


                            @else
                            <td> <span class="badge badge-warning"> Not yet Updated</span> </td>
                            @endif

                          
                     
                          
                           <td><?php $tender = Crypt::encrypt($house->tender ); ?>
                          <a style="color: green;"  href="{{route('view_company_report_for_company' , [ $tender,  $house['tendercompany']->company_name ])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fa fa-bar-chart"></i></a>&nbsp;&nbsp;
                          <a style="color: green;"
                                       onclick="myfunc('{{ $house->id }}','{{ $house->ter_reason }}','{{ $house['tendercompany']->company_name }}' )"
                                       data-toggle="modal" data-target="#editHouse" title="Reason For Termination"><i
                                                class="fas fa-eye"></i></a>
                          </td>
                          


                        </tr>

                    @endforeach

 @endif


                    </tbody>

                </table>
                <br>



         </div>


            </div>




 <div class="modal fade" id="editHouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reason for Termination</h5>
                </div>

               
                    <div class="modal-body">

                  
                        <div class="form-group">
                            <label for="name_of_house">Reason </label>
                            <textarea disabled style="color: black;width:430px" type="text" required class="form-control"
                                   id="edit_name"
                                   name="tender" placeholder="Enter Company tender number"></textarea>
                            <input id="edit_id" name="edit_id" hidden>
                        </div>
                                               &nbsp;
                                               <div">


                                                 <a class="btn btn-danger" style="color: white;" role="button"  data-dismiss="modal" aria-label="Close" >Cancel </a>

                </div>                          
    
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>





  <div class="modal fade" id="viewarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 align="center" class="modal-title" id="exampleModalLabel">AREA ASSIGNED</h5>
                </div>


                    <div class="modal-body">

                    </div>



                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>





    <script>
        window.onload = function () {
            //write your function code here.

            document.getElementById("modal").click();
        };

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });

            $('#myTablee').DataTable();
            $('#myTableee').DataTable();
                $('#myTable5').DataTable();


        });


        function myfunc(A, B, C, D, E , F , G, H) {

            document.getElementById("edit_id").value = A;

            document.getElementById("edit_name").value = B;

           document.getElementById("edit_type").value = C;


       }




    </script>


     @endSection
