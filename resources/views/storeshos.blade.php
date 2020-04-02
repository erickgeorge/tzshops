@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-lg-12" align="center">
            <h5 style="padding-left: 90px; "><b style="text-transform: uppercase;">Available materials </b></h5>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
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
    <div class="row ">
        <div class="col-md-3" align="right">

             <a href="{{url('addmaterial')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new material</button></a>

        </div>
        <div class="col-md-6">
        </div>
        
    </div>
    <div class="container " style="margin-right: 2%; margin-left: 2%;">
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
          <tr style="color: white;">
                <th >#</th>
                <th >Name</th>
                <th >Brand Name</th>
                <th >Value/Capacity</th>
                <th >Type</th>
                <th >Stock</th>
                <th >Created date</th>
                <th >Stock updated at</th>
               
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item->name }}</td>
                    <td id="wo-details">{{ $item->description }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ number_format($item->stock) }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>
                    
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endSection