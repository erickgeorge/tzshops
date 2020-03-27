@extends('layouts.master')

@section('title')
    works orders
    @endSection

@section('body')

    <br>
      @if(count($items) > 0)
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h3 align="center"><b style="text-transform: uppercase;">Material accepted for this works  order </b></h3>
        </div>

       <!-- <div style="padding-left: 650px;">
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
        </div>-->
@endif

        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr class="container">
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
           			
				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
				<th >Quantity</th>
				<th >Status</th>
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   
                   
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
					  <td>{{ $item->quantity }}</td>
                      @if($item->status == 5)
                      <td><span class="badge badge-warning">On Procurement Stage</span>
                       </td>
                       @elseif($item->status == 3)
                       <td><span class="badge badge-primary">Sent From Store to HoS</span>
                       </td>
                       @elseif($item->status == 15)
                       <td><span class="badge badge-warning"> Purchased</span>
                       </td>
                       @else
                        <td><span class="badge badge-primary"> ACCEPTED</span>
                       </td>

                       @endif
                    </tr>
			
                    @endforeach
            </tbody>
        </table>
    </div>
   
        @else

             <br><div> <h2 style="padding-top: 300px;">Currently no works order with accepted material</h2></div>
             
                
        @endif
    </div>
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