@extends('layouts.master')

@section('title')
    Work order with missing material
    @endSection

@section('body')

@if(count($items)> 0)

    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h3 align="center"><b>Work order with missing materials and need to be purchased</b></h3>
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
            <thead class="thead-dark">
            <tr>
                
				
                <th > # </th>
				<th > ID </th>
                <th>HoS Name</th>
				<th >Workorder Detail</th>
				
				<th >Action</th>
				
            </tr>
            </thead>

          <tbody>                    

           <?php $i= 0; ?>
            @foreach($items as $item)

               
                <tr> <td>{{$i++}}</td>
                    <td>00{{ $item->work_order_id }}</td>
                    <td>Mr .{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                    <td>{{ $item['workorder']->details }}</td>
                    
                    <td>
					
					 <a class="btn btn-primary btn-sm" href="{{ route('store.material_to_procure_view', [$item->work_order_id]) }}" role="button">View Material</a></td>
                  
                      
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>

@else

<div style="padding-top: 300px;" align="center"><h1> No Work order with material to be purchased.</h1></div>

@endif
    @endSection