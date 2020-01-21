@extends('layouts.master')

@section('title')
    Non-Building Assets
    @endSection

@section('body')
   <?php use App\Area; ?> 
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