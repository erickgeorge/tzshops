@extends('layouts.master')

@section('title')
work orders
@endSection
@section('body')
  
<br>
<div class="row container-fluid">
  <div class="col-md-8">
    <h3><b>Work orders list </b></h3>
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
<div class="row ">
  <div class="col-md-3">
    <a href="{{url('createworkorders')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-success">Create new Work Order</button></a>
  </div>
  <div class="col-md-6">
  </div>
  <div class="col-md-3">
    <a href="{{url('deleted/work/orders')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-danger">View deleted Work Orders</button></a>
  </div>
</div>
    <div class="container " >
<table class="table table-striped" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th >#</th>
      <th >Details</th>
      <th >Type</th>
      <th >From</th>
      <th >Status</th>
      <th >Created date</th>
      <th >Location</th>
      <th >Actions</th>
    </tr>
  </thead>

  <tbody>
   
    <?php $i=0;  ?>
    @foreach($wo as $work)
    <?php $i++ ?>
    <tr>
      <th scope="row">{{ $i }}</th>
      <td id="wo-details">{{ $work->details }}</td>
      <td>{{ $work->problem_type }}</td>
      <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
      @if($work->status == -1)
      <td><span class="badge badge-warning">new</span></td>
      @else
        <td><span class="badge badge-success">accepted</span></td>
        @endif
      <td>{{ $work->created_at }}</td>
      <td>{{ $work['room']['block']->location_of_block }}</td>
      <td>
      @if(strpos(auth()->user()->type, "HOS") !== false)
        @if($work->status == -1)
            <a href=" {{ route('workOrder.view', [$work->id]) }} "><span class="badge badge-success">View</span></a>
        @else
            <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
            <a style="color: black;" href="" data-toggle="tooltip" title="Track"><i class="fas fa-tasks"></i></a>
        @endif
      @else
          @if($work->status == -1)
            <a href="#"><span class="badge badge-success">Waiting...</span></a>
          @else
            <a href="" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>&nbsp;
            <a style="color: black;" href="" data-toggle="tooltip" title="Track"><i class="fas fa-tasks"></i></a>&nbsp;
        @endif
      @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
@endSection