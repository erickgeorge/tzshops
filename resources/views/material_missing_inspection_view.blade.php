@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')


    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
           <h5 style="text-transform: capitalize;"  ><b style="text-transform: capitalize;">Works Orders that need material </b></h5>
        </div>

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
    </div>

    <div class="container " style="margin-right: 2%; margin-left: 2%;">
        <table class="table table-striped display" id="myTable"  style="width:100%">
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

<h3> THESE MATERIALS NEEDS TO BE PURCHASED/ADDED TO THE STORE </h3>
<h6>Please add them so that Other Orders can get fulfilled</h6>
				</br>


            </tbody>
        </table><br>
        <div><a href="stores"  data-toggle="tooltip" title="Accept"> <Button class='btn btn-primary'> Go To Store  <span> </button></a>

        <a href="stores"  data-toggle="tooltip" title="Accept"> <Button class='btn btn-warning'> Proceed  <span> </button></a>
        </div>
    </div>
    @endSection
