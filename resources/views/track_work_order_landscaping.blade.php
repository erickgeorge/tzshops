@extends('layouts.land')

@section('title')
    works order
    @endSection

@section('body')
<?php use App\WorkOrderInspectionForm;
    use App\WorkOrderTransport;
    use App\WorkOrderStaff;
    use App\WorkOrderMaterial;
    use App\techasigned;
    use App\landscapinginspectionform;
 

 ?>
 <div class="container">

    <br>
    <div >
        <div class="col-lg-12">
            <h3 align="center" style="text-transform: uppercase;">Landscaping works order details</h3>
        </div>
    
  
        </div>

  
    <hr>
    <div style="margin-right: 2%; margin-left: 2%;">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col">
            <h5>Submitted by  <span
                style="color: green">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span> On <h5><span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span></h5>

    
    
        </div>
        <div class="col">
        <h5>  @if($wo->status == 0)Rejected@elseif($wo->status == 1) Accepted @else Processed @endif by <span
                style="color: green">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span></h5>
             <h5 style="color: black">Mobile number: <span style="color: green">{{ $wo['user']->phone }}</span> <br>
              Email: <span style="color:green"> {{ $wo['user']->email }} </span></h5>
        </div>
    </div>
    
   
    <br>

<div class="row">
    <div class="col">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Maintenance Section</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{ $wo->maintenance_section }}" disabled>
    </div>
    </div>
    <div class="col">
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
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
         @if(empty($wo->room_id))
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area"
               aria-describedby="emailHelp"
               value="{{ $wo->room_id }}" disabled>

                @else
            <input style="color: black" type="text" required class="form-control" placeholder="location not defined"
                   name="area"
                   aria-describedby="emailHelp" value="{{ $wo['room']['block']['area']->name_of_area }}"
                   disabled>
                @endif

    </div>
    </div>
    <div class="col">
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
    </div>
    <div class="col">
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
    </div>
</div>

    
    <div class="form-group ">
        <label for="">Details:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
  
  <br>


<h5><b>Supervisor assigned for Land scaping inspection: </b></h5>

@if(count($inspection) > 0)

<table style="width:100%">
  <tr>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date of Inspection</th>
  <th>Inspection Description</th>
  </tr>

  @foreach($inspection as $insp)
  <tr>
   <td>{{$insp['usersupervior']->fname . '  ' . $insp['usersupervior']->lname}}</td>
   <td>{{$insp->status}}</td>
   <td>{{$insp->date}}</td>
   <td> <a onclick="myfunc2('{{$insp->description}}')"><span data-toggle="modal" data-target="#viewdetails"
                                                                         class="badge badge-success">View Description</span></a></td>
 </tr>

  @endforeach

  </table>
   <br>
  @else
  <h8><span class="badge badge-danger">No Supervisor Assigned yet!</span></h8> 
  @endif

   <hr>
   
    


     <!-- Modal for view description -->
    <div class="modal fade" id="viewdetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: black"><b></b> Description before work.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h3 id="description"><b> </b></h3>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



  <script type="text/javascript">
   function myfunc2(x) {
            document.getElementById("description").innerHTML = x;
  }
  </script>

    @endSection