@extends('layouts.master')

@section('title')
    Works orders with materials rejected
    @endSection

@section('body')
<?php
      use App\zoneinspector;  ?>
    <br>
     @if(count($items) > 0)
<div class="container">
    <div class="row container-fluid">
        <div class="col">
            <h5 style="  " ><b>Works orders with Material(s) Rejected</b></h5>
        </div>
        <div class="col-md-4">
            <a href="" class="btn btn-primary"> PDF <i class="fa fa-file-pdf" aria-hidden="true"></i> </a>
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
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif

    <div class="container " >

        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >#</th>

				<th >Works order ID</th>
				<th >HoS Name</th>
                <th>Rejected By</th>
                <th>Works order Details</th>
				<th >Action</th>

            </tr>
            </thead>

            <tbody>
     @if(auth()->user()->type == 'Inspector Of Works')

<?php $i=0; ?>
            @foreach($materialed as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                    <td>00{{ $item->work_order_id }}</td>

                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                     <td>{{ $item['acceptedby']->fname.' '.$item['acceptedby']->lname}}</td>
                    <td>{{$item['workorder']->details}}</td>


                      <td>  <a style="color: green;" href="rejected/materials/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">View Materials</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
      @elseif(strpos(auth()->user()->type, "HOS") !== false )
       <?php $iii=0;  ?>
               @foreach($materialhos as $item)

                <?php $iii++ ?>
                <tr>
                    <th scope="row">{{ $iii }}</th>

                    <td>00{{ $item->work_order_id }}</td>

                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                     <td>{{ $item['acceptedby']->fname.' '.$item['acceptedby']->lname}}</td>
                    <td>{{$item['workorder']->details}}</td>


                      <td>  <a style="color: green;" href="rejected/materials/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">View Materials</a>&nbsp;
                        </td>
                    </tr>
               @endforeach
      @else
            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                    <td>00{{ $item->work_order_id }}</td>

                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                    <td>{{ $item['acceptedby']->lname.' '.$item['acceptedby']->fname }}</td>
                    <td>{{$item['workorder']->details}}</td>


                      <td>  <a style="color: green;" href="rejected/materials/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">View Materials</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
        @else
            <h3 class="text-center" style="margin-top: 150px">You have no works order with material(s) rejected</h3>
        @endif
    </div>
</div>
    @endSection
