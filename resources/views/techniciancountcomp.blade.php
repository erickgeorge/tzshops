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
    work orders vs Technician count 
    @endSection

@section('body')


    <br>
    <div class="row container-fluid ">
        <div class="col-lg-12">
            <h3 class="container"><b>Available Technician Completed their works order</b></h3>
        </div>
             
  



       
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
   

    
	
	 <div class="container">


 
</div>

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
            <h1 class="text-center" style="margin-top: 150px">Currently no Technician completed Work order</h1>
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