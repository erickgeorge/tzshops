@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12" align="center">
            <h3><b>Available materials </b></h3>
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
        <div class="row ">
        <div class="col">

             <a href="{{url('addmaterial')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-success">Add new material</button></a>

        </div>
       <!-- <div class="col" align="right">
            <a href="{{ url('work_order_material_missing') }}"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Material requests <b style="color:red; background-color: grey; padding: 4px; border-radius: 5px;">90</b></button></a>
        </div> -->
        <div class="col" align="right">
            <button class="btn btn-primary">print</button>
        </div>
       <!-- <div class="col-md-3">
            <a href=""><button style="margin-bottom: 20px" type="button" class="btn btn-warning">View needed materials (10)</button></a>
        </div>  -->
    </div>
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >Name</th>
                <th >Description</th>
                <th >Type</th>
                <th >Stock</th>
                <th >Created date</th>
                <th >Stock updated at</th>
                <th >Actions</th>
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
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td>
                        <a style="color: green;" href="{{ route('storeIncrement.view', [$item->id]) }}"  data-toggle="tooltip" title="Increment material"><i class="fas fa-plus"></i></a>&nbsp;
                        <a style="color: black;" href="" data-toggle="tooltip" title="Track"><i class="fas fa-tasks"></i></a>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endSection