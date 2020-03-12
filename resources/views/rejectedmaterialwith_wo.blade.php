@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
     @if(count($items) > 0)
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h3 align="center"><b>Work Orders with Material Rejected</b></h3>
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
              
				<th >Workorder ID</th>
				<th >HOS name</th>
                <th>Workorder Details</th>
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
                   
                    <td>Mr .{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                    <td>{{$item['workorder']->details}}</td>
					
                 
                      <td>  <a style="color: green;" href="rejected/materials/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">Material</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no Workorder with material rejected by Inspector of Work</h1>
        @endif
    </div>
</div>
    @endSection