@extends('layouts.master')

@section('title')
    Material to be purchased
    @endSection

@section('body')
<?php
use App\User;
use App\MinuteSheet; ?>
    <br>



    <div>
        <div>
            <h5 class="container"><b>Material(s) to be Purchased </b></h5>
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

    <div class="container " >
        <table class="table table-responsive table-striped display" id="myTableproc"  style="width:100%">
            <thead >
            <tr style="color: white;">
                <th >#</th>
                <th >Wo ID</th>
                <th >Material Name</th>
                <th >Material Description</th>
                <th >Value/Capacity</th>
                <th >Type</th>
                <th >Quantity Requested</th>
                <th >Quantity Reserved</th>
                <th >Material to Purchase</th>
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['workorder']->woCode }}</td>
                    <td>{{ $item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->brand }}</td>
                    <td>{{ $item['material']->type }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->reserved_material }}</td>

                    <td> {{ $item->quantity- $item->reserved_material  }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>

         @if(auth()->user()->type == 'Head Procurement')

    
         <a class="btn btn-primary btn-sm" href="{{ route('store.materialafterpurchase') }}" role="button">Notify Store Manager</a>


         @endif
          <br>
          <br>



    @endSection
