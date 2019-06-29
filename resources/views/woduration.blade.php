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
    work orders duration
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-md-6">
            <h3><b>Work orders Duration list </b></h3>
        </div>

        <div class="col-md-6">
            <form method="GET" action="woduration" class="form-inline my-2 my-lg-0">
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
   

    <div id="div_print" class="container">
	
	<input name="b_print" type="button" class="btn btn-success mb-2"   onClick="printdiv('div_print');" value=" Print ">

        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                   
					<th>WO ID</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Location</th>
					 <th>Duration</th>
                    <th id="exclude1">Actions</th>
                </tr>
                </thead>

                <tbody>

                {{-- CREATE A CLASS WIT<?php $i = 0;  ?>
                @foreach($wo as $work)
						
						
						
                    
                       
                        <tr>
                            
                            <td id="wo-details"> {{ $work->id }}</td>
                            <td>{{ $work->details }}  </td>
							<td>{{ $work->problem_type }}  </td>
							
					
							
							
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
							 <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}</td>
                            @else

                                {{ $work->location }}  </td>
                            @endif
						 <?php
							$datetime1 = $work->created_at;
							$datetime2 = $work->updated_at;
    
							$interval = date_diff($datetime1, $datetime2);
    
							
						 ?>
						 <td>{{ $interval->format('%a') }}  </td>
                          
						  
						    <td id="exclude2">
                               
                                       <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i> Track</a>
													</td>
						  
						  
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
var headstr = "<html><head><title></title></head><body><h1> Work orders Duration list </h1>";
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