@extends('layouts.master')

@section('title')
work orders
@endSection
@section('body')
<br>
<div class="row container-fluid">
  <div class="col-md-8">
    <h3>Work orders list</h3>
  </div>
  <div class="col-md-4">
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</div>
<br>
<hr>
<div class="row">
  <div class="col-md-8">
    <a href="{{url('createworkorders')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-success">Create new work order</button></a>
    <a href="{{url('add/technician')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-warning">Add technician</button></a>
  </div>
  <div class="col-md-4">
    <a href="{{url('deleted/work/orders')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-danger">View deleted Work Orders</button></a>
  </div>
</div>
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Details</th>
      <th scope="col">Type</th>
      <th scope="col">From</th>
      <th scope="col">Status</th>
      <th scope="col">Created date</th>
      <th scope="col">Location</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>

  <tbody>
   
    <?php $i=0;  ?>
    @foreach($wo as $work)
    <?php $i++ ?>
    <tr>
      <th scope="row">{{ $i }}</th>
      <td>{{ $work->details }}</td>
      <td>{{ $work->problem_type }}</td>
      <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
      <td><span class="badge badge-warning">new</span></td>
      <td>{{ $work->created_at }}</td>
      <td>{{ $work['room']['block']->location_of_block }}</td>
      <td>
      @if(strpos(auth()->user()->type, "HOS") !== false)
        @if($work->status == -1)
            <form method="POST" id="{{ 'accept'.$work->id }}" action="{{ route('workorder.accept', [$work->id]) }}">
              @csrf
              <a href="#" onclick="document.getElementById('{{ 'accept'.$work->id }}').submit()"><span class="badge badge-success">Accept</span></a>
            </form>
            <a href="#" data-toggle="modal" data-target="#exampleModal"><span class="badge badge-danger">Reject</span></a>
        @else
            {{--<a href="{{ url('view/work_order', [$work->id]) }}" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>&nbsp;--}}
            <a style="color: green;" href="{{ url('view/work_order', [$work->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rejecting work order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please provide reason as to why you want to reject this work order.</p>
        <form method="POST" action="{{ route('workorder.reject', [$work->id]) }}">
          @csrf
          <textarea name="reason" required maxlength="100" class="form-control"  rows="5" id="reason"></textarea>
          <br>
          <button type="submit" class="btn btn-danger">Reject</button>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
@endSection