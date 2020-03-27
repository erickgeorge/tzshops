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
        <h3 style="text-transform: uppercase;"><b>Non-Building Assets - ( {{ $_GET['asset'] }} )</b></h3>
                  <hr>
                <a href="{{ route('registernonbuildingasset') }}" 
                   class="btn btn-primary">Add New Non-Building Assets</a>
                   <br><br>

                <table id="myTablee" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>

                        <th scope="col">Located at</th>
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
                            
                            <td> @if($non->area_id==null)
                                {{ $non->location }}
                                @else
                                <?php $asset = Area::where('id',$non->area_id)->get();?>
                                @foreach($asset as $asset)
                                @endforeach
                                {{ $asset->name_of_area }}
                                @endif
                            </td>
                           
                            <td>{{ $non->total_asset }}</td>
                            <td>
                            <form method="Get" action="@if($non->area_id==null) @else NonassetIn @endif ">
                                <input type="text" value="@if($non->area_id==null){{ $non->location }} @else {{ $non->area_id }} @endif" hidden name="location">
                                <input type="text" name="asset" value="{{ $_GET['asset'] }}" hidden>
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