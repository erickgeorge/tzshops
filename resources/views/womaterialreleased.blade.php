@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 style=" "  ><b  >Material(s) Released to Work Orders</b></h5>
        </div>

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

    <div class="container " >
        <table class="table table-responsive table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th> </th>
                <th >ID</th>
				<th >Works order Detail</th>
				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
				<th >Quantity</th>


            </tr>
            </thead>

            <tbody>

            <?php $i=0;

				$c=-1;
				$t=0;
						?>
            @foreach($items as $item)

                <?php $i++ ;
				$t= $item->work_order_id;
				?>
                <tr>
                    <th scope="row"></th>
                    <td>  @if($t==$c)  @else  00{{ $item->work_order_id  }} @endif </td>

                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
					  <td>{{ $item->quantity }}</td>
                   <?php
				$c=$item->work_order_id;
				?>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endSection
