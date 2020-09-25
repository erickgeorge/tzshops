@extends('layouts.master')

@section('title')
    Room Report - Block
    @endSection

@section('body')
<?php use App\Block; ?>
<div class="container">
    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 style="text-transform: capitalize;" ><b style="text-transform: uppercase;">Room report - Block</b></h5>
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
                    <th>Block</th>

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
                                     <?php $locational = block::select('name_of_block')->where('id',$work->block_id)->get();
                                     foreach ($locational as $locational) {
                                        echo $locational->name_of_block;
                                      } ?>

                                      </td>




                                <td>
                                    {{ $work->total_room }}  </td>
                                    <td><form method="get" action="inroomreporwithrooms">
                                        <button class="btn btn-primary" name="room" value="{{ $work->block_id }}" style="text-transform: capitalize;"><i class="fa fa-eye"></i> view</button></form></td>




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
