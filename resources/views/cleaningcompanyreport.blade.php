@extends('layouts.land')

@section('title')
    Cleaning Company report
    @endSection

@section('body')
    <br>
   <?php use Carbon\Carbon;?>

<div class="container">


       <div >
               @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
              @endif
                  <h5 style=" text-transform: capitalize;" ><b style="text-transform: capitalize;">Companies trending </b></h5>
                  <hr>

                   <br> <br>

                <table id="myTableee" id="myTable" class="table table-striped">

                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Area Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($cleangcompany as $house)
                        <?php $i++; ?>

                <?php $now1 =  Carbon::now();
                $dcont = Carbon::parse($house->datecontract);
                $dnext = Carbon::parse($house->nextmonth);

                $date_left = $now1->diffInDays($dcont);
                $date_next = $now1->diffInDays($dnext); ?>


                        <tr>
                            <th scope="row">{{ $i }}</th>
                             <td>{{ $house->tender }}</td>
                              <td>{{ $house['compantwo']->company_name }}</td>
                            <td>{{ $house['are_a']->cleaning_name }}</td>


                  @if($house->status == 2 )
                           <td><span class="badge badge-danger">Not assigned yet </span><br>
                            @if($now1 >= $dcont)<span class="badge badge-danger">Days reached please assign</span>@endif </td>


                  @else

                          <?php  $ddate = strtotime($house->nextmonth);
                              $newDate = date("Y-m-d", strtotime("-1 month", $ddate));
                                                                                    ?>


                           <td><span class="badge badge-primary">Current assessment on {{ date('F Y', strtotime($newDate))}}</span> </td>
                  @endif





                            <?php $tender = Crypt::encrypt($house->tender ); ?>
                          <td><a style="color: green;"  href="{{route('view_company_report' , [ $tender,  $house['compantwo']->company_name , $house['are_a']->cleaning_name])}}" data-toggle="tooltip" title="View report"><i
                                                    class="fas fa-eye"></i></a></td>







                        </tr>
                    @endforeach
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

                <form method="POST" action="edit/company" class="col-md-6">
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
