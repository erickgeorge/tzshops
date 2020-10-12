@extends('layouts.master')

@section('title')
    Room Report - Area/College/Directorate
    @endSection

@section('body')
<?php use App\Area; ?>
<div class="container">
    <br>
    <div class="row container-fluid" >
        <div class="col">
            <h5 style="text-transform: capitalize;" ><b style="text-transform: uppercase;">Room report - Area/College/Directorate</b></h5>
        </div>

        @if(count($wo) > 0)
        <div class="col-md-6">
            <form method="GET" action="" class="form-inline my-2 my-lg-0">
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

@endif


    </div>
    <br>
    <hr>
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif

	<!--<input align="right" name="b_print" type="button" class="btn btn-success mb-2"   onClick="printdiv('div_print');" value=" Print ">-->

    <div  id="div_print" class="container" style="margin-right: 2%; margin-left: 2%;">
        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead >
                <tr style="color: white;">
                    <th>#</th>
                    <th>Area/College/Directorate</th>

                    <th>WO TOTAL REQUESTS</th>
                    <th>Action</th>

                </tr>
                </thead>

                <tbody>

               <?php $i = 0;  ?>
                @foreach($wo as $work)


                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>



								<td >
                                     <?php $locational = area::select('name_of_area')->where('id',$work->area_id)->get();
                                     foreach ($locational as $locational) {
                                        echo ucwords(strtolower($locational->name_of_area));
                                      } ?>

                                      </td>




								<td>
                                    {{ $work->total_room }}  </td>
                                    <td><form method="get" style="text-transform: capitalize;" action="inroomreportextended">
                                        @if (request()->has('start')&&request()->has('end'))
                                 <input type="text" value="{{request('start')}}" name="start" hidden>
                                 <input type="text" value="{{request('end')}}" name="end" hidden>
                                    @endif
                                        <button class="btn btn-primary" name="room" value="{{ $work->area_id }}"><i class="fa fa-eye"></i> view</button></form></td>




                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">Currently no room reported for work order.</h1>
        @endif
    </div>
    </div>

    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });


		function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body><h1> Room report </h1>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
//var exclude = document.getElementByid('exclude').innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;

window.print();
document.body.innerHTML = oldstr;
return false;
}

    </script>
    @endSection
