@extends('layouts.master')

@section('title')
    Material Request
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b style="text-transform: uppercase;">PROCUREMENT REQUEST OF WORKs ORDER</b></h3>
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
   
    <div class="container " style="margin-right: 2%; margin-left: 2%;" >
        <table class="table table-striped display" id="myTable"  >
            <thead >
            <tr style="color: white;">
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
					 
                    
					
				
                    </tr>
                    @endforeach
            </tbody>
		
        </table>
		 <td>
					
					 <a class="btn btn-primary btn-lg active"  href="{{ route('procurement.release', [$item->work_order_id]) }}"  role="button" aria-pressed="true" role="button" >RELEASE MATERIAL</a></td>
		
                  
    </div>
	












	
    @endSection