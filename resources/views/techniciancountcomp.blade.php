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
    work orders vs hos count 
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>TECHNICIAN COMPLETED COUNT ON WORK ORDERS </b></h3>
        </div>

        <div class="col-md-6" align="left">
            <form method="GET" action="techniciancountcomp" class="form-inline my-2 my-lg-0">
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
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Filter</button>
            </form>
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
   

    <div id="div_print" class="container" style="margin-right: 2%; margin-left: 2%;">
	
	<input align="right" name="b_print" type="button" class="btn btn-success mb-2"   onClick="printdiv('div_print');" value=" Print ">

        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                   
					<th>Technician name</th>
                    <th>Total Work orders Completed</th>
                   
                </tr>
                </thead>

                <tbody>

             
                @foreach($wo as $work)
						
						
						
                    
                       
                        <tr>
                            
                           
							
							
					
							
							
                            <td>{{ $work['technician_assigned']->fname.' '.$work['technician_assigned']->lname }}</td>
							<td>{{ $work->total_wo }}  </td>
							
						  
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no work oder</h1>
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
    @endSection