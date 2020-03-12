@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')

    <br>
     @if(count($items)>0)
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Works order with rejected Material </b></h3>
        </div>

        <div style="padding-left: 650px;">
            <form method="GET" action="work_order_material_accepted" class="form-inline my-2 my-lg-0">
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
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>
@endif

        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr>
    <div style="margin-right: 2%; margin-left: 2%;">
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
            <thead >
           <tr style="color: white;">
                <th >#</th>
                <th >WO ID</th>
				<th >Workorder Detail</th>
				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
				<th >Quantity</th>
                <th >Reason</th>
				<th >Status</th>
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   <td>WO {{ $item->work_order_id }}</td>
                   
                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
					<td>{{ $item->quantity }}</td>
                    <td><a onclick="myfunc('{{ $item->reason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a></td>
                    <td style="color: red">
                       REJECTED</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
   
        @else
            <h1 class="text-center" style="margin-top: 150px">Currently no works order with rejected material</h1>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red">Reason as why Inspector of Work Rejecting Material Request.</h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h3 id="reason"><b> </b></h3>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });
    
   

         function myfunc(x) {
            document.getElementById("reason").innerHTML = x;
        }
    </script>
    @endSection