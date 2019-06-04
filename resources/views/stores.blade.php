@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3><b>Available materials </b></h3>
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
        <div class="col-md-3">
            <a href="{{url('addmaterial')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-success">Add new material</button></a>
        </div>
        <div class="col-md-6">
        </div>
        <div class="col-md-3">
            <a href=""><button style="margin-bottom: 20px" type="button" class="btn btn-warning">View needed materials (10)</button></a>
        </div>
    </div>
    <div class="container " >
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
                    <td>{{ $work->created_at }}</td>
                    <td>{{ $work->updated_at }}</td>
                    <td>
                        <a style="color: green;" href=""  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                        <a style="color: black;" href="" data-toggle="tooltip" title="Track"><i class="fas fa-tasks"></i></a>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endSection