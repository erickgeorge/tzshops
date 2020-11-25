@extends('layouts.land')

@section('title')
  Expired Tenders
    @endSection

@section('body')
    <br>
   <?php use Carbon\Carbon;?>

<div class="container">

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

       <div class="row">
      <div class="col">

            <h5 ><b > Expired/Terminated Tenders Contracts </b></h5>

        </div>

        <div>
            <form method="GET" action="{{route('cleaningcompany')}}" class="form-inline my-2 my-lg-0">
                From <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>

     </div>
     <br>
     <hr>


                 <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                   Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </button>



                <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('tendersreport')}}">
             @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">



        <div class="row">


               <div class="col">   From <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>"  class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="col">
                To<input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end"  class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                </div>
       </div>
<br>


        <div class="row">
          <div class="col">
              <select name="tender" class="form-control mr-sm-2">
                <option value='' selected="selected">Select tender number</option>
                @foreach($assessmmenttender as $astender)
                <option value="{{$astender->tender }}">{{ $astender->tender }}</option>
                @endforeach

              </select>
          </div>
      </div>

      <br>

              <div class="row">
          <div class="col">
              <select name="company" class="form-control mr-sm-2">
                <option value='' selected="selected">Select company name</option>
                 @foreach($assessmmentcompany as $ascompany)
                <option value="{{ $ascompany->company_name }}">{{ $ascompany['compantwo']->company_name }}</option>
                @endforeach

              </select>
          </div>
      </div>

      <br>

              <div class="row">
          <div class="col">
              <select name="area" class="form-control mr-sm-2">
                <option value='' selected="selected">Select area name</option>
                 @foreach($assessmmentareas as $asarea)
                <option value="{{ $asarea->area }}">{{ $asarea['are_a']->cleaning_name }}</option>
                @endforeach

              </select>
          </div>
      </div>

      <br>







      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Export</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
</form>
  </div>
</div>




       <div >

                   <a href="{{ route('cleaningcompany') }}"
                   class="btn btn-outline-primary" >All Tenders</a>

                   <br>
                   <br>


                <table id="myTableee" id="myTable" class="table table-striped">

                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Area Name</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Assessment sheet</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>


                    <tbody>


                    <?php $i = 0;  $ii = 0;  $iii = 0;?>

               @if(auth()->user()->type == 'Supervisor Landscaping')
                    @foreach($cleangcompanylandscaping as $house)
                        <?php $i++;?>

                <?php $now1 =  Carbon::now();

                $next30day = strtotime($house->datecontract);
                $next30days = date("Y-m-d", strtotime("+1 month", $next30day));

                $dcont = Carbon::parse($house->datecontract);
                $dnext = Carbon::parse($house->nextmonth);
                $endcont = Carbon::parse($house->endcontract);

                $date_left = $now1->diffInDays($next30days);
                $date_next = $now1->diffInDays($dnext); ?>


                    <!--expiredcontract-->
                @if($now1 > $endcont)
                 <!--expiredcontract-->

                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->tender }} </td>
                            <td>{{ $house['are_a']->cleaning_name }}</td>
                            <td>{{ $house['compantwo']->company_name }}</td>
                            <td>{{ $house->sheet }}</td>

           <td>
             
               <div>
                        <?php $tender = Crypt::encrypt($house->tender ); ?>
                          <a style="color: green;"  href="{{route('view_company_report' , [ $tender,  $house['compantwo']->company_name , $house['are_a']->cleaning_name])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fas fa-eye"></i></a>  &nbsp;&nbsp;
                        <a style="color: green;"  href="{{route('renew_contract' , [$house->id])}}" data-toggle="tooltip" title="Renew tender contract"><i class="fas fa-arrow-alt-circle-right"></i></a>
      
               </div>
          </td>




                        </tr>

                            <!--expiredcontract-->
                @endif
                 <!--expiredcontract-->

   @endforeach
   @endif




   @if(auth()->user()->type == 'Warden')
   @foreach($cleangcompanyusab as $house)

   @if((auth()->user()->hostel == $house['are_a']->cleaning_name ) and (auth()->user()->block == $house['are_a']->block))

                        <?php $ii++;?>

                <?php $now1 =  Carbon::now();

                $next30day = strtotime($house->datecontract);
                $next30days = date("Y-m-d", strtotime("+1 month", $next30day));

                $dcont = Carbon::parse($house->datecontract);
                $dnext = Carbon::parse($house->nextmonth);
                $endcont = Carbon::parse($house->endcontract);

                $date_left = $now1->diffInDays($next30days);
                $date_next = $now1->diffInDays($dnext); ?>


                    <!--expiredcontract-->
                @if($now1 > $endcont)
                 <!--expiredcontract-->
      
                        <tr>
                            <th scope="row">{{ $ii }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['are_a']->cleaning_name }}</td>
                            <td>{{ $house['compantwo']->company_name }}</td>
                            <td>{{ $house->sheet }}</td>
            <td>
              <div>
                        <?php $tender = Crypt::encrypt($house->tender ); ?>
                          <a style="color: green;"  href="{{route('view_company_report' , [ $tender,  $house['compantwo']->company_name , $house['are_a']->cleaning_name])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fas fa-eye"></i></a>  &nbsp;&nbsp;
                        <a style="color: green;"  href="{{route('renew_contract' , [$house->id])}}" data-toggle="tooltip" title="Renew tender contract"><i class="fas fa-arrow-alt-circle-right"></i></a>
       
               </div>
          </td>




                        </tr>

                            <!--expiredcontract-->
               @endif
                 <!--expiredcontract-->
 @endif

   @endforeach

   @endif





   
  @if(auth()->user()->type == 'Administrative officer')
   @foreach($cleangcompanyusab as $house)

   @if((auth()->user()->college == $house['are_a']->college ) and ($house['are_a']->hostel == 2))

                        <?php $ii++;?>

                <?php $now1 =  Carbon::now();

                $next30day = strtotime($house->datecontract);
                $next30days = date("Y-m-d", strtotime("+1 month", $next30day));

                $dcont = Carbon::parse($house->datecontract);
                $dnext = Carbon::parse($house->nextmonth);
                $endcont = Carbon::parse($house->endcontract);

                $date_left = $now1->diffInDays($next30days);
                $date_next = $now1->diffInDays($dnext); ?>


                    <!--expiredcontract-->
                @if($now1 > $endcont)
                 <!--expiredcontract-->

                        <tr>
                            <th scope="row">{{ $ii }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['are_a']->cleaning_name }}</td>
                            <td>{{ $house['compantwo']->company_name }}</td>
                            <td>{{ $house->sheet }}</td>

             <td>

              <div class="row">   &nbsp;&nbsp;&nbsp;
       
                        <?php $tender = Crypt::encrypt($house->tender ); ?>
                          <a style="color: green;"  href="{{route('view_company_report' , [ $tender,  $house['compantwo']->company_name , $house['are_a']->cleaning_name])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fas fa-eye"></i></a> &nbsp;&nbsp;
                        <a style="color: green;"  href="{{route('renew_contract' , [$house->id])}}" data-toggle="tooltip" title="Renew tender contract"><i class="fas fa-arrow-alt-circle-right"></i></a>
    
               </div>
          </td>




                        </tr>

                            <!--expiredcontract-->
               @endif
                 <!--expiredcontract-->
 @endif

   @endforeach

   @endif

 

     @if((auth()->user()->type != 'Warden') and (auth()->user()->type != 'Supervisor Landscaping') and  (auth()->user()->type != 'Administrative officer') )
   @foreach($cleangcompanyadmin as $house)
                        <?php $iii++;?>

                <?php $now1 =  Carbon::now();

                $next30day = strtotime($house->datecontract);
                $next30days = date("Y-m-d", strtotime("+1 month", $next30day));

                $dcont = Carbon::parse($house->datecontract);
                $dnext = Carbon::parse($house->nextmonth);
                $endcont = Carbon::parse($house->endcontract);

                $date_left = $now1->diffInDays($next30days);
                $date_next = $now1->diffInDays($dnext); ?>


                <!--expiredcontract-->
                @if($now1 > $endcont)
                 <!--expiredcontract-->

                        <tr>
                            <th scope="row">{{ $iii }}</th>
                            <td>{{ $house->tender }}</td>
                            <td>{{ $house['are_a']->cleaning_name }}</td>
                            <td>{{ $house['compantwo']->company_name }}</td>
                            <td>{{ $house->sheet }}</td>

    
              <td>

                   <div class="row"> 
                 &nbsp;&nbsp;&nbsp;&nbsp;
     
                        <?php $tender = Crypt::encrypt($house->tender ); ?>
                          <a style="color: green;"  href="{{route('view_company_report' , [ $tender,  $house['compantwo']->company_name , $house['are_a']->cleaning_name])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fas fa-eye"></i></a>  &nbsp;&nbsp;
                        <a style="color: green;"  href="{{route('renew_contract' , [$house->id])}}" data-toggle="tooltip" title="Renew tender contract"><i class="fas fa-arrow-alt-circle-right"></i></a>

                     </div>
             </td>


                        </tr>
      <!--expiredcontract-->
                 @endif
                 <!--expiredcontract-->

                    @endforeach
                    @endif
                    </tbody>

                </table>
                <br>

            </div>




               <div class="modal fade" id="editHouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Cleaning Company</h5>
                </div>

                <form method="POST" action="{{route('assessment.sheet.edit')}}" class="col-md-6">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Name </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_name"
                                   name="name" placeholder="Enter Company name">
                            <input id="edit_id" name="edit_id" hidden>
                        </div>


                        <div class="form-group">
                            <label for="name_of_house">Type </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type"
                                   name="type" placeholder="Enter Company type">

                        </div>


                         <div class="form-group">
                            <label for="name_of_house">Status </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_status"
                                   name="status" placeholder="Enter Company status">

                        </div>

                       <div class="form-group">
                            <label for="name_of_house">Registration</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_registration"
                                   name="registration" placeholder="Enter Company Registration">

                        </div>

                        <div class="form-group">
                            <label for="name_of_house">Tin</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_tin"
                                   name="tin" placeholder="Enter Company tin">

                        </div>


                        <div class="form-group">
                            <label for="name_of_house">Vat</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_vat"
                                   name="vat" placeholder="Enter Company vat">

                        </div>

                         <div class="form-group">
                            <label for="name_of_house">License </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_License"
                                   name="license" placeholder="Enter Company License">

                        </div>








                         <div style="width:600px;">
                                                <div style="float: left; width: 130px">

                                                        <button  type="submit" class="btn btn-primary">Save Changes
                                                        </button>


                                               </div>
                                               <div style="float: right; width: 290px">


                                                  <a class="btn btn-danger" href="/cleaningcompany" role="button">Cancel </a>

                                                       </div>
                                            </div>
                         </div>
                </form>


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

           document.getElementById("edit_status").value = D;

           document.getElementById("edit_registration").value = E;

           document.getElementById("edit_tin").value = F;

           document.getElementById("edit_vat").value = G;

           document.getElementById("edit_License").value = H;
       }




    </script>


     @endSection
