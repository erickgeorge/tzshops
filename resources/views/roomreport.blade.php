@extends('layouts.master')

@section('title')
    Room Report - Location
    @endSection

@section('body')
<?php use App\location; ?>
<div class="container">
    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 style="  " align="center"><b style="text-transform: capitalize;">Room report - Location</b></h5>
        </div>


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
                    <th>Location</th>

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


							@if($work->location ==null)
								<td >
                                     <?php $locational = location::select('name')->where('id',$work->loc_id)->get();
                                     foreach ($locational as $locational) {
                                        echo $locational->name;
                                      } ?>

                                      </td>
                            @else
									<td >
                                {{ $work->location }}  </td>
                            @endif


                            	@if($work->location ==null)
								<td>
                                    {{ $work->total_room }}  </td>
                                    <td><form method="get" action="inroomreport"><button class="btn btn-primary" name="room" value="{{ $work->loc_id }}"><i class="fa fa-eye"></i> view</button></form></td>

								 @else
									<td >
                                {{ $work->total_location }}  </td>
                                 <td><form method="get" action="thisroomreport"><button class="btn btn-primary" name="workorders" value="{{ $work->location }}"><i class="fa fa-eye"></i> view</button></form></td>
                            @endif


                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">Currently no room reported for works order.</h1>
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
