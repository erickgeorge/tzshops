@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')
   @if(count($items) > 0)

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            @if(auth()->user()->type =='STORE')
            <h5 class="container" ><b>Works Orders With Material(s) Available and Required by Head of Section</b></h5>
            @else
            <h5 class="container"><b> Works Orders with Material(s) Received From Store</b></h5>
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
            <thead >
           <tr style="color: white;">
                <th >#</th>

                <th >Works order ID</th>
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


                      <td>  <a style="color: green;" href="received/materials/from_store/{{$item->work_order_id}}"  data-toggle="tooltip" title="View Material">View Materials</a>&nbsp;
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        @elseif(auth()->user()->type =='STORE')
            <h3 class="text-center" style="margin-top: 350px">You have no Works order with Material(s) taken from store</h3>
        @else

         <h3 class="text-center" style="margin-top: 350px">You have no Works order with Material(s) rejected by Inspector of Work</h3>
        @endif




    </div>
</div>
    @endSection
