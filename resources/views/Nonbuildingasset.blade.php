@extends('layouts.master')

@section('title')
    Non-Building Assets
    @endSection

@section('body')
    
    <br>
<div class="container">
   <br>
   <br>
   <br>
        
            @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
            @endif
        <h3><b>Non-Building Assets </b></h3>
                  <hr>
                <a href="{{ route('registernonbuildingasset') }}" 
                   class="btn btn-primary">Add New Non-Building Assets</a>
                   <br><br>

                <table id="myTablee" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Located at</th>
                        <th scope="col">Manufacture Date</th>
                        <th scope="col">Life Span</th>
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
                            <td>{{ $non->type }}</td>
                            <td>{{ $non->room_located}}</td>
                            <td>{{ $non->manufactured_date}}</td>
                            <td>{{ $non->life_span }}</td>

                            <td>
                            <div class="row">


                                    <a style="color: green;" data-toggle="modal" data-target="#editHall" title="Edit"><i class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Hall Completely? ')"
                                          action="">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                                </div>

                         </td>
                             </tr>

                    @endforeach
                </tbody>
                    
                </table>
                <br>
                





        
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




    </script>