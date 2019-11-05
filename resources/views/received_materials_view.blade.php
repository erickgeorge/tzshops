@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Material Released by Store Manager for the work order  </b></h3>
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
        @if(count($items) > 0)
             
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
        <th >No</th>
        <th >WorkOrder ID</th>
				<th >Workorder Detail</th>
				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
				<th >Quantity Released</th>
        <th >Status</th>
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   <td>00{{ $item->work_order_id }}</td>
                   
                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
					          <td>{{ $item->quantity }}</td>
                  
                                          
                    <td style="color: blue">
                       RELEASED</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    
   
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no material released  by Store Manager</h1>
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