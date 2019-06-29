@extends('layouts.master')

@section('title')
    Material Request
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3><b>MATERIAL REQUESTED BY WORK ORDER</b></h3>
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
                <th >#</th>
               
				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
				<th >Quantity</th>
				
				
				
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
					 
                    
					<?php $wo_id=$item->work_order_id; ?>
				
                    </tr>
                    @endforeach
            </tbody>
        </table>
		
		<h2> RELEASE ALL MATERIALS </h2>
		 <a class="btn btn-primary btn-sm" href="{{ route('store.materialrelease', [$wo_id]) }}" role="button">Release</a></td>
                  
    </div>
	
	
    @endSection