@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')
   @if(count($items) > 0)

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            @if(auth()->user()->type =='STORE')
            <h3 align="center"><b>Work orders with Material available and required by Head of Section</b></h3>
            @else
            <h3 align="center"><b>Work orders with Material received From Store</b></h3>
            @endif

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
            <thead class="thead-dark">
            <tr>
                <th >#</th>
              
				<th >Workorder ID</th>
				<th >Store Manager</th>
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
                   
                    <td>Mr .{{ $item['userreceiver']->lname.' '.$item['userreceiver']->fname }}</td>
					
                 
                      <td>  <a style="color: green;" href="received/materials/from_store/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">Material</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        @elseif(auth()->user()->type =='STORE')
            <h1 class="text-center" style="margin-top: 350px">You have no Workorder with material taken from store</h1>
        @else

         <h1 class="text-center" style="margin-top: 350px">You have no Workorder with material rejected by Inspector of Work</h1>
        @endif




    </div>
</div>
    @endSection