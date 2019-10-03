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


                   
                   <button id="modal" class="tablinks active col-md-4" onclick="openTab(event, 'cleaningzone')">
                        Technician Completed Work
                    </button>

                    <button class="tablinks col-md-4" onclick="openTab(event, 'cleaningarea')" id="defaultOpen">
                        Technician on Progress
                    </button>

                    
                    

                </div>
            </div>
     
     

        {{-- Cleaningarea --}}

         <div id="cleaningarea" class="tabcontent">
              <h3><b>Available Cleaning Areas </b></h3>\
              <hr>
           

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




              {{-- Cleaningzone --}}

         <div id="cleaningzone" class="tabcontent">
              <h3><b>Available Cleaning Zones </b></h3>
             


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>







        
    @endSection


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
                $('#myTable5').DataTable();                                            
 

        });

</script>