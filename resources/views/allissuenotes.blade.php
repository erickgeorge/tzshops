@extends('layouts.master')

@section('title')
    All Good Received Notes
    @endSection

@section('body')

@if(count($items)> 0)



    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h5 class="container" ><b>Issue Notes</b></h5>
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

                <th > # </th>
                <th>Date</th>
                  <th>Issue Note Number</th>
				<th >Action</th>

           </tr>
            </thead>

          <tbody>

           <?php $i= 1; ?>
            @foreach($items as $item)


                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ date('d F Y', strtotime($item->isn_time))}}</td>
                     <td>{{$item->isn_number}}</td>
                    <td>

					 <a class="btn btn-primary btn-sm" href ="{{route('allissuenote',[$item->isn_time])}}" role="button">View <i class="fas fa-eye"></i></a></td>


                    </tr>
                    @endforeach
            </tbody>
        </table>
     
    </div>
</div>

@else

<div style="padding-top: 300px;" align="center"><h3> Currently No Available Goods Received Note.</h3></div>

@endif
    @endSection
