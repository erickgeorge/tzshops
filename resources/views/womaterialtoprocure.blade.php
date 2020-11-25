@extends('layouts.master')

@section('title')
    Works order with missing material
    @endSection

@section('body')

@if(count($items)> 0)

    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h5 class="container" ><b>Works Order with Missing Materials</b></h5>
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
				<th > Wo ID </th>
                <th>HoS Name</th>
				<th >Works order Detail</th>

				<th >Action</th>

            </tr>
            </thead>

          <tbody>

           <?php $i= 1; ?>
            @foreach($items as $item)


                <tr> <td>{{$i++}}</td>
                    <td>woCode{{ $item->woCode }}</td>
                    <td>{{ $item['usermaterial']->lname.' '.$item['usermaterial']->fname }}</td>
                    <td>{{ $item['workorder']->details }}</td>

                    <td>

					 <a class="btn btn-primary btn-sm" href="{{ route('store.material_to_procure_view', [$item->work_order_id]) }}" role="button">View Materials</a></td>


                    </tr>
                    @endforeach
            </tbody>
        </table>
        <br>
          @if(auth()->user()->type == 'Head Procurement')
            <a class="btn btn-primary btn-sm" href="{{ route('material_to_purchase') }}" role="button">View All Materials</a>
          @endif
    </div>
</div>

@else

<div style="padding-top: 300px;" align="center"><h3> No Works order with material(s) to be purchased.</h3></div>

@endif
    @endSection
