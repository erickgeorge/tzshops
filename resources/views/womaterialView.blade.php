@extends('layouts.master')

@section('title')
    Material Request
    @endSection

@section('body')


    <br>
    <br>


    <div>
        <div>
            <h3 style="text-align: center"><b>Release Material for the workorder</b></h3>
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
				<th >Quantity Requested</th>
				<th >Quantity Available on Store</th>
				<th >Balance after release</th>
	
				
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
					<td>{{ $item['material']->stock }}</td>
 					<td>{{ $item['material']->stock - $item->quantity}}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
		
		<h2> RELEASE ALL MATERIALS </h2>
		 <a class="btn btn-primary btn-sm" href="{{ route('store.materialrelease', [$item->work_order_id]) }}" role="button">Release</a></td>
                  
    </div>
	
	
    @endSection