@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3><b>Material released to work-orders</b></h3>
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
   
    <div class="container " >
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th> </th>
                <th >WO ID</th>
				<th >Workorder Detail</th>
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
                    <td>  @if($t==$c)  @else  WO-{{ $item->work_order_id  }} @endif </td>
                   
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
    @endSection