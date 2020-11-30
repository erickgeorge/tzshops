@extends('layouts.master')

@section('title')
    Works order that needs material
    @endSection

@section('body')
@php
    use App\WorkOrder;
@endphp
@if(count($items)>0)
<div class="container">

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 style=" "  ><b>Works order with Material(s) Accepted</b></h5>
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


                <th > No </th>
				<th >Works order ID </th>
                <th >HoS Name </th>
				<th >Works order Detail</th>
                <th >Accepted By</th>

				<th >Action</th>

            </tr>
            </thead>

          <tbody>
            @if(auth()->user()->type == 'Inspector Of Works')
            <?php $i= 1; ?>
            @foreach($materls as $item)


                <tr> <td>{{$i++}}</td>
                    <td>{{ $item['workorder']->woCode }}</td>

                    <td>{{ ucwords(strtolower($item['usermaterial']->fname.' '.$item['usermaterial']->lname)) }}</td>

                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{ ucwords(strtolower($item['acceptedby']->fname.' '.$item['acceptedby']->lname))}}</td>

                    <td>

                     <a class="btn btn-primary btn-sm" href="{{ route('woMaterialAccepted', [$item->work_order_id]) }}" role="button">View Material</a></td>


                    </tr>
                    @endforeach
            @else
           <?php $i= 1; ?>
            @foreach($items as $item)


                <tr> <td>{{$i++}}</td>
                    <td>00{{ $item->work_order_id }}</td>
                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>

                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{ $item['acceptedby']->name }}</td>

                    <td>

					 <a class="btn btn-primary btn-sm" href="{{ route('woMaterialAccepted', [$item->work_order_id]) }}" role="button">View Material</a></td>


                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>
<br><br><br>

@else

<div style="padding-top: 300px;" align="center"><h3> No Works order Material(s) accepted by Inspector of Works </h3></div>

@endif
    @endSection
