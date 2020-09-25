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
@php
    // $simple =  WorkOrder::select(DB::raw('YEAR(created_at) as year'))->distinct() ->where('status',30)->get();

    use App\WorkOrder;
    $simple1 =  WorkOrder::select('year_')
    ->distinct()
    ->where('status',30)
    ->where('year_','<>','NULL')
    ->get();
    $simple2 =  WorkOrder::select('month_')
    ->distinct()
    ->where('status',30)
    ->where('month_','<>','NULL')
    ->get();
@endphp
 @if(count($wo) > 0)

    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h5 class="container"><b style="text-transform: capitalize;">Number of Head of Sections Completed their Works orders  </b></h5>
        </div>

       <!-- <div class="col-md-6">
            <form method="GET" action="hoscount" class="form-inline my-2 my-lg-0">
                From <input name="start" value="<?php
               // if (request()->has('start')) {
                   // echo $_GET['start'];
                //} ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php //echo date('Y-m-d'); ?>">
                To <input value="<?php
               // if (request()->has('end')) {
                   //echo $_GET['end'];
               // } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php //echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>-->



    </div>
    <br>
    <hr>
<div class="card">
    <div class="card-body">
        <form action="{{route('filterhos')}}" method="get" enctype="multipart/form-data">
            <div class="row">
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text" id="my-addon">Year</span>
                    </div>
                    <select class="form-control" type="text" name="year" aria-describedby="my-addon">
                        @if (isset($_GET['year']))
                            @if ($_GET['year']!='')
                            <option  value="{{ $_GET['year'] }}">{{ $_GET['year'] }}</option>

                            @endif
                        @endif
                        @foreach ($simple1 as $ic1)
                            <option value="{{$ic1->year_}}">{{$ic1->year_}}</option>

                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text" id="my-addon">Month</span>
                    </div>
                    <select class="form-control" type="text" name="month" placeholder="Recipient's text" aria-label="Recipient's " aria-describedby="my-addon">
                        @if (isset($_GET['month']))
                            @if ($_GET['month']!='')
                            <option  value="{{ $_GET['month'] }}">{{ $_GET['month'] }}</option>

                            @endif
                        @endif
                        <option value="">Select Month</option>

                        @foreach ($simple2 as $ic)
                            <option value="{{$ic->month_}}">{{$ic->month_}}</option>

                        @endforeach                  </select>

                </div>
            </div>
            <div class="col">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </div>
        </form>
    </div>
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
					<th>HOS name</th>
                    <th>Total Works orders Completed</th>
                    <th colspan="" rowspan="" headers="" scope="">Action</th>

                </tr>
                </thead>

                <tbody>


                @foreach($wo as $work)
                        <tr>
                             <td>{{ $work['hos']->fname.' '.$work['hos']->lname }}</td>
							<td>{{ $work->total_wo }}  </td>
                            <td colspan="" rowspan="" headers=""><a href="{{ route('hoscompletedjob', [$work['hos']->id]) }}"><i class="fa fa-eye"></i> View</a></td>
                        </tr>
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
