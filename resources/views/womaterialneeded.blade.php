@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')
@if(count($items) > 0)

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Work orders that need material </b></h3>
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
                <th >#</th>
              
				<th >Workorder ID</th>
				<th >HOS name</th>
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
					
                 
                      <td>  <a style="color: green;" href="work_order_material_iow/{{$item->work_order_id}}"  data-toggle="tooltip" title="Accept">Material</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
 @else       
               <div class="container" align="center">
                
                   <br><div> <h2 style="padding-top: 300px;">No work order needs Material</h2></div>
                
            </div>
                   @endif
    @endSection