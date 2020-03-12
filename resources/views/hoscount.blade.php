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

 @if(count($wo) > 0)

    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 class="container"><b>Number of Head of Sections Completed their Works orders  </b></h3>
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
            <h1 class="text-center" style="margin-top: 150px">Currently no available Head of Section completed the work order.</h1>
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
