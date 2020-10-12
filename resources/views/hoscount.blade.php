@extends('layouts.master')
<style type="text/css" media="print">

        #exclude1{
            display:none;
        }

		#exclude2{
            display:none;
        }

    </style>
@section('title')
    HOS Completed Work order
    @endSection

@section('body')

<div class="container">

 @if(count($wo) > 0)

    <br>
    <div class="row container-fluid" >
        <div class="col">

            <h5 ><b>Head of Sections With Completed Works Orders  </b></h5>


        </div>
        <div class="col">
            <form method="GET" action="" class="form-inline my-2 my-lg-0">
                From <input name="start" style="width: 145px;" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date"  placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" style="width: 145px;" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>


    </div>

    <hr>
</div><br>

    <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif


    <!--<div id="div_print" class="container" align="center">-->





            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead >
               <tr style="color: white;">
                <th style="width: 10px;">#</th>
					<th>HOS name</th>
                    <th>Total Works Orders Completed</th>
                    <th colspan="" rowspan="" headers="" scope="">Action</th>

                </tr>
                </thead>

                <tbody>

@php
    $sdf = 1;
@endphp
                @foreach($wo as $work)
                        <tr>
                        <td>{{$sdf}}</td>
                             <td>{{ $work['hos']->fname.' '.$work['hos']->lname }}</td>
							<td>{{ $work->total_wo }}  </td>
                        <td colspan="" rowspan="" headers=""><a href="{{ route('hoscompletedjob', [$work['hos']->id]) }}?@php if(request()->has('start')){echo'start='.$_GET['start'];}if(request()->has('end')){echo'&end='.$_GET['end'];}@endphp"><i class="fa fa-eye"></i> View</a></td>
                        </tr>
                        @php
                            $sdf++;
                        @endphp
                        @endforeach
                </tbody>
            </table>
        @else
            <h4 class="text-center" style="margin-top: 150px">Currently no available Head of Section completed the works order.</h4>
        @endif
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
var headstr = "<html><head><title></title></head><body><h1>HOS COUNT ON WORK ORDERS </h1>";
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
    </div>
    @endSection
