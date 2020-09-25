@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')


@if(auth()->user()->type == 'Maintenance coordinator')
@if(count($mcitems) > 0)

   <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 style=" text-transform: capitalize;"  ><b >WORKS ORDER NEEDS MATERIAL(S) </b></h5>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr class="container">
    <div style="margin-right: 2%; margin-left: 2%;">
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
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
          <tr style="color: white;">
                <th >#</th>

                <th >Works order ID</th>
                <th >HoS name</th>
                <th >Sent To</th>
                <th >Action</th>

            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($mcitems as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                    <td>00{{ $item->work_order_id }}</td>

                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>

                    <td>{{ $item['iowzone']->zonename }}</td>


                      <td>  <a style="color: green;" href="work_order_material_iow/{{$item->work_order_id}}/{{$item->zone}}"  data-toggle="tooltip" title="View Material">View Material</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
 @else
               <div class="container" align="center">

                   <br><div> <h2 style="padding-top: 300px;">Currently no works order needs Material</h2></div>

            </div>
@endif
@endif

@if(auth()->user()->type == 'Inspector Of Works')
@if(count($items) > 0)

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
          <h5 style=" text-transform: capitalize;"  ><b >Works Order Needs Material </b></h5>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr class="container">
    <div style="margin-right: 2%; margin-left: 2%;">
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
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >#</th>

                <th >Works order ID</th>
                <th >HoS name</th>

                <th >Action</th>

            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                    <td>00{{ $item->work_order_id }}</td>

                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>



                      <td>  <a style="color: green;" href="work_order_material_iow/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material"> View Material</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
 @else
               <div class="container" align="center">

                   <br><div> <h2 style="padding-top: 300px;">Currently no works order needs Material</h2></div>

            </div>
@endif
@endif


    @endSection
