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

<h3> ACCEPT/REJECT THIS WORK-ORDER MATERIAL REQUEST </h3>
                </br>

                    <div> <h5> ACCEPT  <span> <a style="color: green;" href="{{ route('store.materialaccept', [$item->work_order_id]) }}"  data-toggle="tooltip" title="Accept"><i class="far fa-check-circle"></i></a>
                   </span>  &nbsp;&nbsp;&nbsp;&nbsp;  REJECT <span> <a style="color: black;" href="{{ route('store.materialreject', [$item->work_order_id]) }}" data-toggle="tooltip" title="Reject"><i class="far fa-window-close"></i></a>
                </span> </h5> </div> 
            </tbody>
        </table>
    </div>
    @endSection