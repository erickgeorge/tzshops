@extends('layouts.master')

@section('title')
    Material Request
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>MATERIAL REQUESTED BY WORK ORDER</b></h3>
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
                <th>Action</th>
    
                
            </tr>
            </thead>

            <tbody>

            <?php $i=0; $capacity = 0; ?>
            @foreach($items as $item)

                <?php $i++?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item['material']->stock }}</td>
                    <td>
                        @if(($item['material']->stock)-($item->quantity) < (0)) <?php $capacity = 1; ?> <b style='color:red;'> INSUFFICIENT</b> @else{{{ $item['material']->stock - $item->quantity }}}

                         @endif
                     </td>
                     <td>
                         @if(($capacity !=1)) <a class="btn btn-primary btn-sm" href="{{ route('store.materialrelease', [$item->work_order_id]) }}}" role="button">Release</a>
                         @else <a href="{{ route('store.insufficientmaterial', [$item->work_order_id]) }}">
        <button class="btn btn-warning btn-sm">Request</button></a>
        @endif
                     </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        
        
        @if($capacity != 1)
        <h2> RELEASE ALL MATERIALS </h2>
         <a class="btn btn-primary btn-sm" href="{{ route('store.materialrelease', [$item->work_order_id]) }}" role="button">Release</a></td>
        @endif      
    </div>
    
    </div>
    @endSection