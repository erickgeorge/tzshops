@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')
<?php  
      use App\zoneinspector;  ?>
    <br>
     @if(count($items) > 0)
      
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h5 style="padding-left: 90px; " align="center"><b style="text-transform: uppercase;">Works orders with material rejected</b></h5>
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
				<th >HOS name</th>
                <th>Work sorder Details</th>
				<th >Action</th>
				
            </tr>
            </thead>

            <tbody>
     @if(auth()->user()->type == 'Inspector Of Works')
      
<?php $i=0;  ?>
            @foreach($materialed as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   
                    <td>00{{ $item->work_order_id }}</td>
                   
                    <td>Mr .{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                    <td>{{$item['workorder']->details}}</td>
                    
                 
                      <td>  <a style="color: green;" href="rejected/materials/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">Material</a>&nbsp;
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
                   
                    <td>Mr .{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                    <td>{{$item['workorder']->details}}</td>
					
                 
                      <td>  <a style="color: green;" href="rejected/materials/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">Material</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
        @else
            <h2 class="text-center" style="margin-top: 150px">You have no works order with material rejected by Inspector of Work</h2>
        @endif
    </div>
</div>
    @endSection