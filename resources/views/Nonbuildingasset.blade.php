@extends('layouts.asset')

@section('title')

    Non-Building Assets
    @endsection


@section('body')
    <br>

    @if(Session::has('message'))

        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>

    @endif
<div class="container">


         <div>

              <h5 style="text-transform: capitalize;" ><b style="text-transform: capitalize;">Non-Building Assets </b></h5>
                  <hr>
                <a href="{{ route('registernonbuildingasset') }}"
                   class="btn btn-primary">Add New Non-Building Assets</a>
                   <br><br>

                <table id="myTablee" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>

                        <th scope="col">Name of asset</th>
                        <th>Total Quantity</th>

                        <th scope="col">Action</th>
                    </tr>
                    </thead>



                    <tbody>
                     <?php $i = 0; ?>
                    @foreach($NonAsset as $non)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>

                            <td>{{ $non->name_of_asset }}</td>

                            <td>{{ $non->total_asset }}</td>
                            <td>
                            <form method="Get" action="NonBuildAsset">
                                <input type="text" value="{{ $non->name_of_asset }}" hidden name="asset">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-eye"></i> View</button>
                            </form>

                         </td>
                             </tr>

                    @endforeach
                </tbody>

                </table>






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

    @endsection
