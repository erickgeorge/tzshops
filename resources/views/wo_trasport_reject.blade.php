@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12" align="center">
            <h3><b>Rejected Requested Transport </b></h3>
        </div>
@if(count($items)>0)
        <div class="container" style="padding-left: 620px;">
            <form method="GET" action="wo_transport_request_rejected" class="form-inline my-2 my-lg-0">
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
   
   
    <div class="container " >
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >HOS name</th>
				<th >Location</th>
                <th >Details</th>
				<th >Date</th>
				<th >Time</th>
                <th >Message</th>
				
				<th >Status</th>
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['requester']->fname.'  '.$item['requester']->lname  }}</td>
                    @if(empty($item['workorder']->location))
                    <td>{{ 
				$item['workorder']['room']['block']->location_of_block

				}}</td>
				
				@else
				<td>{{ 
				$item['workorder']->location

				}}</td>
				
				@endif

                <td>{{ $item->coments}}</td>
				
				
					<td>{{ date('F d Y', strtotime($item->time)) }}</td>
					
					<td>{{ date('h:m:s a', strtotime($item->time)) }}</td>
					  
                    <td>{{ $item->details}}</td>
					 <td><span class="badge badge-danger"> REJECTED </span> </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endSection