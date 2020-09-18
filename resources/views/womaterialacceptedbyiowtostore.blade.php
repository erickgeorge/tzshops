@extends('layouts.master')

@section('title')
    Work order that needs material
    @endSection

@section('body')
@if(count($items)>0)

    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h5 class="container"  ><b>Works order with Material(s) Accepted by Inspector of Works</b></h5>
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


                <th > No </th>
				<th >Works order ID </th>
                <th >HoS Name </th>
				<th >Works order Detail</th>

				<th >Action</th>

            </tr>
            </thead>

          <tbody>

           <?php $i= 1; ?>
            @foreach($items as $item)


                <tr> <td>{{$i++}}</td>
                    <td>00{{ $item->work_order_id }}</td>
                     <td>Mr .{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                    <td>{{ $item['workorder']->details }}</td>

                    <td>

					 <a class="btn btn-primary btn-sm" href="{{ route('store.materia_accepte_by_iow', [$item->work_order_id]) }}" role="button">View material</a></td>


                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
<br><br><br>

@else

<div style="padding-top: 300px;" align="center"><h1>Currently no works order material accepted by Inspector of Works </h1></div>

@endif
    @endSection
