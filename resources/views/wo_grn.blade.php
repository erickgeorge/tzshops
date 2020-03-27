@extends('layouts.master')

@section('title')
    Purchasing Order Requests
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h3 align="center"><b style="text-transform: uppercase;">Purchasing Order Requests</b></h3>
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
            <thead>
            <tr style="color: white;">
                
				
                
				<th >Works Order ID </th>
				<th >Work order Detail</th>
				
				<th >Action</th>
				
            </tr>
            </thead>

            <tbody>

           
            @foreach($items as $item)

               
                <tr>
                    
                      <td>{{ $item->work_order_id }}</td>
                    <td>{{ $item['workorder']->details }}</td>
                    
                    <td>
					
					 <a class="btn btn-primary btn-sm" href="{{ route('procurement.grn.view', [$item->work_order_id]) }}" role="button">View Materials</a></td>
                  
                       </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endSection