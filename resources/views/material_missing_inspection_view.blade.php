@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Work Orders that need material </b></h3>
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
   
    <div class="container " style="margin-right: 2%; margin-left: 2%;">
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
                   
                    </tr>



                    @endforeach

<h3> THESE MATERIALS NEEDS TO BE PURCHASED/ADDED TO THE STORE </h3>
<h6>Please add them so that Other Orders can get fulfilled</h6>
				</br>

                    
            </tbody>
        </table><br>
        <div><a style="color: green;" href="stores"  data-toggle="tooltip" title="Accept"> <Button class='btn btn-success'> Go To Store  <span> </button></a> 

        <a style="color: green;" href="stores"  data-toggle="tooltip" title="Accept"> <Button class='btn btn-success'> Proceed  <span> </button></a> 
        </div> 
    </div>
    @endSection