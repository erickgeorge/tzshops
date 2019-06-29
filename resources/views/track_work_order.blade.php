@extends('layouts.master')

@section('title')
    work order
    @endSection

@section('body')
<?php use App\WorkOrderInspectionForm;
		use App\WorkOrderTransport;
		use App\WorkOrderStaff;
		use App\WorkOrderMaterial;

 ?>
    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3>Work order details</h3>
        </div>
    </div>
    <hr>
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    <h5>This work order has been @if($wo->status == 0)Rejected@elseif($wo->status == 1) Accepted @else Processed @endif by <span
                style="color: green">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span></h5>
    <h5>It Has been created on <span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span>
    </h5>
    <h3 style="color: black">Contacts:</h3>
    <h5>{{ $wo['user']->phone }}</h5>
    <h5>{{ $wo['user']->email }}</h5>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type of a problem</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{ $wo->problem_type }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        @if(empty($wo->room_id))
            <input style="color: black" type="text" required class="form-control" placeholder="location not defined"
                   name="location"
                   aria-describedby="emailHelp" value="{{ $wo->location }}" disabled>
        @else
            <input style="color: black" type="text" required class="form-control" placeholder="location not defined"
                   name="location"
                   aria-describedby="emailHelp" value="{{ $wo['room']['block']->location_of_block }}"
                   disabled>
        @endif
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area"
               aria-describedby="emailHelp"
               value="{{ $wo->room_id }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Block</label>
        </div>
        @if(empty($wo->room_id))
            <input style="color: black" type="text" required class="form-control" placeholder="block" name="block"
                   aria-describedby="emailHelp"
                   value="{{ $wo->location }}" disabled>
        @else
            <input style="color: black" type="text" required class="form-control" placeholder="block" name="block"
                   aria-describedby="emailHelp"
                   value="{{ $wo['room']['block']->name_of_block }}" disabled>
        @endif
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Room</label>
        </div>
        @if(empty($wo->room_id))
            <input style="color: black" type="text" required class="form-control" placeholder="room" name="room"
                   aria-describedby="emailHelp"
                   value="{{ $wo->location }}" disabled>
        @else
            <input style="color: black" type="text" required class="form-control" placeholder="room" name="room"
                   aria-describedby="emailHelp"
                   value="{{ $wo['room']->name_of_room }}" disabled>
        @endif
    </div>
    <div class="form-group ">
        <label for="">Details:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
	
	<br>
    <h4><b>Transport Description: </b></h4>
	@if(empty($wo['work_order_transport']->work_order_id))
        <p style="color: red">No Transport form</p>
    @else
		<?php
	
	$idwo=$wo->id;
	$tforms = WorkOrderTransport::where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
    <th>DATE</th>
    <th>TIME</th> 
	<th>STATUS</th>
	<th>DETAILS</th>
	
    <th>DATE REQUESTED</th>
  </tr>
    @foreach($tforms as $tform)
	
	
  <tr>
    <td>{{ date('F d Y', strtotime($tform->time))  }}</td>
    <td>{{ date('h:i:s A', strtotime($tform->time)) }}</td> 
    <td style="color:red">@if($tform->status==0) WAITING   @elseif($tform->status==1) APPROVED @else REJECTED   @endif</td>
	
<td>{{ 
	 $tform->details }}</td>

	<td>{{ 
	 $tform->created_at }}</td>
  </tr>
  
	@endforeach
	</table>
    @endif
    <br>
	
	
	
	
	<br>
    <h4><b>Technician assigned: </b></h4>
@if(empty($wo['work_order_staff']->id))
        <p style="color: red">No Technician assigned yet</p>
    @else
		<?php
	
	$idwo=$wo->id;
	$techforms = WorkOrderStaff::with('technician_assigned')->where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
    <th>Staff Full Name</th>
	<th>Status</th>
    <th>DATE Assigned</th>
	<th>Complete work</th>
	
  </tr>
    @foreach($techforms as $techform)
	
	


  <tr>

    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname }}</td>
	
	 <td style="color:red">@if($techform->status==1) COMPLETED   @else  OnPROGRESS   @endif</td>

      @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>
          @else
          <td style="color: red">No technician assigned yet</td>
      @endif

    <td>{{ 
	 $techform->created_at }}</td>
	 @if($techform->status!=1)
	 <td>   <a style="color: black;" href="{{ route('workOrder.technicianComplete', [$techform->id]) }}" data-toggle="tooltip" title="COMPLETE WORK"><i
                                                    class="fas fa-clipboard-check large"></i></a></td>
													
		</td>
@endif		
  </tr>
  
	@endforeach
	</table>
    @endif
    <br>
    
	<br>
    <h4><b>Material Requests: </b></h4>
	@if(empty($wo['work_order_material']->id))
        <p style="color: red">No Material have been requested yet</p>
    @else
		<?php
	
	$idwo=$wo->id;
	$matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
    <th>Material Name</th>
    <th>Material Description</th>
	<th>Type</th>
	 <th>Quantity</th>
	  <th>Status</th>
	   <th>Date Requested</th>
	    <th>Date Updated</th>
  </tr>
    @foreach($matforms as $matform)
	
	
  <tr>
    <td>{{$matform['material']->name }}</td>
   <td>{{$matform['material']->description }}</td>
    <td>{{$matform['material']->type }}</td>
	 <td>{{$matform->quantity }}</td>
	 <td style="color:red">@if($matform->status==0) WAITING   @elseif($matform->status== 1) APPROVED @elseif($matform->status== 2) RELEASED FROM STORE @else REJECTED   @endif</td>
	
	
	 <td>{{$matform->created_at }}</td>
	 <td>{{$matform->updated_at }}</td>
  </tr>
  
	@endforeach
	</table>
    @endif
    <br>
	
	<br>
    <h4><b>Procurement Requests: </b></h4>
	
	
    <br>
    <h4><b>Inspection Description: </b></h4>
    @if(empty($wo['work_order_inspection']->status))
        <p style="color: red">Not inspected yet</p>
    @else
		<?php
	
	$idwo=$wo->id;
	$iforms = WorkOrderInspectionForm::where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
    <th>STATUS</th>
    <th>DESCRIPTION</th> 
	<th>TECHNICIAN RESPONSIBLE</th> 
    <th>DATE</th>
  </tr>
    @foreach($iforms as $iform)
	
	
  <tr>
    <td style="color:red" >{{ $iform->status }}</td>
    <td>{{ $iform->description }}</td>
      <td>{{

	 $iform['technician']->lname.' '.$iform['technician']->fname }}</td>
    <td>{{ $iform->created_at }}</td>
  </tr>
  
	@endforeach
	</table>
    @endif
    <br>
	
	
	
	
	
    <hr>
    @if(strpos(auth()->user()->type, "HOS") !== false)
        @if($wo->status == 2)
            <div>
                <span class="badge badge-warning" style="padding: 20px">Work order closed!</span>
            </div>
        @else
            <div>
                <form method="POST" action="{{ route('workorder.close', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Close work order</button>
                </form>
            </div>
        @endif
    @else
        <div class="row">
            <div>
                {{-- status of 2 means work order has been closed --}}
                @if($wo->status != 2)
                    
                    <form method="POST" action="{{ route('workorder.close', [$wo->id, $wo->updated_by]) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Close work order</button>
                    </form>
                @endif
            </div>
            <p>&nbsp;</p>
             {{--
			<div>
                <form method="POST" action="">
                    @csrf
               <button type="submit" class="btn btn-danger">File a complaint</button>
                </form>
				--}}
            </div>
        </div>
    @endif
    <br>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                    <form method="POST" action="{{ route('workorder.reject',['id'=>$wo->id]) }}">
                        @csrf
                        <textarea name="reason" required maxlength="100" class="form-control" rows="5"
                                  id="reason"></textarea>
                        <br>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    @endSection