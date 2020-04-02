@extends('layouts.asset')

@section('title')
    Non-Building Assets
    @endSection

@section('body')
   <?php use App\Room; use App\Area;?> 
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
      <h5 style="padding-left: 90px;  text-transform: uppercase;" ><b style="text-transform: uppercase;">Non-Building Assets - ( {{ $_GET['asset'] }} )</b> - 

<small>
@foreach($arcol as $arcol)
        <?php $cvb = Area::where('id',$arcol->area_id)->get(); ?>
        @foreach($cvb as $cvsb)
        {{ $cvsb->name_of_area }}
        @endforeach
@endforeach
</small>

        - <small>@foreach($aariya as $arriya) {{$arriya->name_of_block }} @endforeach </small></h5>
                  <hr>
                <a href="{{ route('registernonbuildingasset') }}" 
                   class="btn btn-primary">Add New Non-Building Assets</a>
                   <br><br>

                <table id="myTablee" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>

                        <th scope="col">Located at</th>
                        <th scope="col">MFG Date</th>
                        <th scope="col">Life span</th>
                        <th>Total Quantity</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                     <?php $i = 0; ?>
                    @foreach($NonAsset as $non)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            
                            <td> 
                                <?php $asset = Room::where('id',$non->room_located)->get();?>
                                @foreach($asset as $asset)
                                {{ $asset->name_of_room }}
                                @endforeach
                                
                                
                            </td>
                           <td>{{ $non->manufactured_date }}</td>
                           <td>{{ $non->life_span }}</td>
                            <td>{{ $non->quantity }}</td>
                            <td><a class="btn btn-primary text-light"><i class="fa fa-pencil"></i></a><a class="btn btn-danger text-light"><i class="fa fa-trash "></i></a></td>
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