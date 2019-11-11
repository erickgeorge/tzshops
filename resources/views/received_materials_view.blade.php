@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            @if(auth()->user()->type == 'STORE')
            <h3 align="center"><b>List of material taken from Store</b></h3>
            @else
            <h3 align="center"><b>Material Received from Store </b></h3>
            @endif
        </div>

      <!--<div class="col-md-6" align="left">
            <form method="GET" action="work_order_material_accepted" class="form-inline my-2 my-lg-0">
                From <input name="start" value="<?php
                //if (request()->has('start')) {
                   // echo $_GET['start'];
               // } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php// echo date('Y-m-d'); ?>">
                To <input value="<?php
                //if (request()->has('end')) {
                    //echo $_GET['end'];
               // } ?>"
                            // name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             //max="<?php //echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>-->


        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr class="container">
    <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
  

    <div class="container">
  
             
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
        <th >No</th>

				<th >Workorder Details</th>
				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
                @if(auth()->user()->type =='STORE')
                <th>Quantity Taken</th>
                @else
                <th >Quantity Received</th>
                @endif
				
        <th >Status</th>
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
				    <td>{{ $item->quantity }}</td>
                  
                       @if(auth()->user()->type == 'STORE')
                       <td style="color: blue"><span class="badge badge-info">  TAKEN</span>
                      </td>
                       @else
                       <td style="color: blue"><span class="badge badge-info">  AVAILABLE</span>
                      </td>
                       @endif                   
                    
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
         
        
   
      
            
       @if(auth()->user()->type !='STORE')

          <h4  style="     color: #c9a8a5;"> Please assign Issue Note for materials you requested from store.</h4>
         <a class="btn btn-primary btn-sm"  href="issuenotepdf/{{$item->work_order_id}}" role="button">Print Issue Note</a>
         @endif

       
    </div>
     
   



    
    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });
    
   

  

    </script>
    @endSection