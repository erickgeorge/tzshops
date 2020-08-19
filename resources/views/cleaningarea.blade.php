@extends('layouts.land')

@section('title')
    manage cleaning area
    @endSection

@section('body')
    <br>

<div class="container">

         <div >

             @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
             @endif

              <h4><b > Cleaning Areas </b></h4>

              <hr>

                            <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" >
                <a href="{{route('landscapingcleaningarea')}}"

                                          style="color: white;" data-toggle="tooltip" title="Print report"> Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i> </a>
                </button>


               @if((auth()->user()->type == 'Supervisor Landscaping')||($role['user_role']['role_id'] == 1))
                <a href="{{ route('Registercleaningarea') }}"
                   class="btn btn-primary">Add new cleaning area</a>
                   <br><br>@endif


                <table id="myTable" id="myTable" class="table table-striped">
                    <thead >
                <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Area Name</th>
                        <th scope="col">LOT</th>
                          @if((auth()->user()->type == 'Supervisor Landscaping')||($role['user_role']['role_id'] == 1))
                        <th scope="col">Action</th>
                        @endif
                    </tr>
                    </thead>



                    <tbody>
                  <?php $i = 0; ?>
                    @foreach($cleanarea as $clean_area)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>

                            <td>{{ $clean_area->cleaning_name }}</td>
                            <td>{{ $clean_area->zone_id }}</td>

  @if((auth()->user()->type == 'Supervisor Landscaping')||($role['user_role']['role_id'] == 1))

                            <td>


                            <div class="row">
                              &nbsp; &nbsp; &nbsp;


                                    <a style="color: green;"
                                       onclick="myfunc9('{{ $clean_area->id }}','{{ $clean_area->cleaning_name }}','{{ $clean_area->zone_id }}' )"
                                       data-toggle="modal" data-target="#editarea" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                             &nbsp;

                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Cleaning Area Completely? ')"
                                          action="{{ route('cleanarea.delete', [$clean_area->id]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                                </div>

                         </td>

                         @endif





                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <br>

            </div>




               <div class="modal fade" id="editarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Cleaning Area Details</h5>
                </div>

                <form method="POST" action="edit/cleaningarea" class="col-md-6">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Cleaning Area Name <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_carea"
                                   name="cleaning_name" placeholder="Enter Cleaning Area Name">
                            <input id="editarea_id" name="editarea_id" hidden>
                        </div>



                    <div class="form-group">
                            <label for="name_of_house">LOT Name <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type"
                                   name="zone" placeholder="Enter LOT Name">
                                <input id="editarea_id"  hidden>

                        </div>
                    </div>



                                               <div style="width:600px;">
                                                <div style="float: left;">

                                                        <button  type="submit" class="btn btn-primary">Save
                                                        </button>


                                               </div>

                                               <div>
                                                      &nbsp;

                                                  <a class="btn btn-danger" href="/manage_Cleaning_area" role="button">Cancel </a>

                                                       </div>
                                            </div>
                                                </div>


              </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>





    @endSection


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


        function myfunc(V, W, X, Y, Z) {

            document.getElementById("edit_id").value = V;

            document.getElementById("edit_name").value = W;

           document.getElementById("edit_location").value = X;

           document.getElementById("edit_type").value = Y;

           document.getElementById("edit_room").value = Z;
       }



        function myfunc1(U, V, W, X, Y, Z) {


            document.getElementById("edit_hallid").value = U;

            document.getElementById("edit_hname").value = V;

            document.getElementById("edit_campus").value = W;

           document.getElementById("edit_area").value = X;

           document.getElementById("edit_type1").value = Y;

           document.getElementById("edit_location1").value = Z;
       }


        function myfunc8(A, B, C) {

             document.getElementById("edit_cid").value = A;

            document.getElementById("edit_campname").value = B;

            document.getElementById("edit_location").value = C;
       }



        function myfunc5(U, V, W) {


             document.getElementById("editzone_id").value = U;

             document.getElementById("edit_zone").value = V;



             document.getElementById("edit_type").value = W;


       }


       function myfunc9(U, V, W) {


             document.getElementById("editarea_id").value = U;

             document.getElementById("edit_carea").value = V;



             document.getElementById("edit_type").value = W;


       }



    </script>
