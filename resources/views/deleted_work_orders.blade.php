@extends('layouts.master')

@section('title')
    work orders
    @endSection
@section('body')
    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3>Deleted work orders</h3>
        </div>
    </div>
    <hr>
    <table class="table table-hover table-striped table-condensed table-scrollable"   id="myTable" >
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
                <td id="wo-details" >{{ $work->details }}</td>
                <td>{{ $work->problem_type }}</td>
                <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                <td><span class="badge badge-danger">deleted</span></td>
                <td>{{ $work->created_at }}</td>
                <td>
				  @if($work->location ==null)
	  {{ $work['room']['block']->location_of_block }}</td>
   @else
	   
   {{ $work->location }}
   @endif
				</td>
                <td>
                    <a href="#"><span data-toggle="modal" data-target="#viewReason" class="badge badge-success">View reason</span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reason for rejecting work order</h5>
					
					
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="w_r_reason">...</p>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
   <script>

$(document).ready(function(){
	
	
  $('[data-toggle="tooltip"]').tooltip();   
  
 $('#myTable').dataTable({
   "dom": '<"top"i>rt<"bottom"flp><"clear">'
});
  
  

});
</script>
    @endSection