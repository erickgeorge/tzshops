@extends('layouts.master')

@section('title')
    manage technician report
    @endSection

@section('body')
    <br>
   
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
<div class="container">
    {{-- tabs --}}
    <div class="payment-section-margin">
        <div class="tab">
            <div class="container-fluid" style="margin-top: 6%;">
                <div class="tab-group row">


                   
                   <button id="modal" class="tablinks active col-md-4" onclick="openTab(event, 'techcomplete')">
                        Technician Completed Work
                    </button>

                    <button class="tablinks col-md-4" onclick="openTab(event, 'techprogress')" id="defaultOpen">
                        Technician on Progress
                    </button>

                    
                    

                </div>
            </div>
     
     

        {{-- techprogress --}}

         <div id="techprogress" class="tabcontent">
              <h3>Technician on Progress </b></h3>
              <hr>

               <div >

         </div>



    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
       <button   name="b_print" type="button" class="btn btn-outline-primary mb-2"   onClick="printdiv('div_print');"  ><i class="fa fa-file-pdf-o"></i> PDF</button>
    

    <div id="div_print" class="container" style="margin-right: 2%; margin-left: 2%;">
    
              
 
        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTableee" style="width:100%">
                <thead class="thead-dark">
                <tr>
                   
                    <th>Technician name</th>
                    <th>Total Work orders</th>
                   
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
           

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




              {{-- technician complete --}}

         <div id="techcomplete" class="tabcontent">
              <h3>Technician Completed  Work </b></h3>
              <hr>

               <div>

         </div>



    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
       <button   name="b_print" type="button" class="btn btn-outline-primary mb-2"   onClick="printdiv('div_print');"  ><i class="fa fa-file-pdf-o"></i> PDF</button>
       
   

    <div id="div_print" class="container" style="margin-right: 2%; margin-left: 2%;">
    
     

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
             


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>







        



    <script>
        window.onload = function () {
            //write your function code here.

            document.getElementById("modal").click();
        };

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });

            $('#myTablee').DataTable();
            $('#myTableee').DataTable();     
                                                 
 

        });


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