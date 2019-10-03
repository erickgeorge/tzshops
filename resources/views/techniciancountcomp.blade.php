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
<div class="container">

    <br>
    <div class="row container-fluid " style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>TECHNICIAN COMPLETED COUNT ON WORK ORDERS </b></h3>
        </div>
             
  <div>
                        <h3><a  href="{{ url('techniciancount')}}">Technician on progress</a></h2>
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
	
	 <div class="container">


 <button   name="b_print" type="button" class="btn btn-success mb-2"   onClick="printdiv('div_print');"  style="font-size:24px ">Export to pdf <i class="fa fa-file-pdf-o" style="color:red"></i></button>
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