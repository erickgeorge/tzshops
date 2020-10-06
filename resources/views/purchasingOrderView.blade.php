@extends('layouts.master')

@section('title')
    Material Request
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h5 style=" "  ><b style="text-transform: capitalize;">PROCUREMENT REQUEST OF WORKs ORDER</b></h5>
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
        <table class="table table-responsive table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >#</th>

				<th >Material ID</th>
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



    </div>


    @endSection
