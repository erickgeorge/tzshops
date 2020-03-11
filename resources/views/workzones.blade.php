@extends('layouts.master')

@section('title')
    work Zones
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style=" margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h3 style="padding-left: 90px;"><b>All Work Zones list </b></h3>
        </div>


    </div>
    <br>
    <hr class="container">
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


    <div id="div_print" class="container">
        <div class="row ">


         <?php
use App\User;
use App\Directorate;
use App\Department;
use App\Section;
use Carbon\Carbon;
use App\iowzonelocation;
 ?>



    </div>
    <div class="bs-example">

    <br/>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="All" style="background-color: white; color: black;">
            @if(count($workszones) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
          			<th>Zone name</th>
                    <th>Total locations</th>
                    <th>Inspector's name</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

              
                <?php $i = 0; ?>
                 @foreach($workszones as $locations)

                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $locations->zonename }}</td>
                            <td><?php $locationtotal = iowzonelocation::where('iowzone_id',$locations->id)->get(); echo count($locationtotal); ?> locations </td>
                            <td>
                            	<?php $zonemaster = user::where('id',$locations->iow)->first(); ?>
                            	{{ $zonemaster['fname'] }} {{ $zonemaster['lname'] }}
                            </td>
                            <td><a href="myzone?zone={{ $locations->id }} " class="btn btn-primary">view workorders</a></td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">No Zones available</h1>
            
        @endif
    </div>

  
        </div>
    </div>

</div>

    <script>



        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });

         function myfunc(x) {
            document.getElementById("unsatisfiedreason").innerHTML = x;
        }

    </script>
    @endSection
