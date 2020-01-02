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
 <div class="container">

    <br>
    <div  style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center">Work order details</h3>
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
            <label class="input-group-text">Type of a problem</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{ $wo->problem_type }}" disabled>
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
 @if($wo->emergency == 1)
   <h6 align="center" style="color: red;"><b> This Workorder is Emergency &#9888;</b></h6>
 @endif

  <h4><b>Technician assigned for Work: </b></h4>
@if(empty($wo['work_order_staff']->id))
        <p style="color: red">No Technician assigned yet</p>
    @else
    <?php
  
  $idwo=$wo->id;
  $techforms = WorkOrderStaff::with('technician_assigned')->where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
  <th>Complete work</th>
  
  </tr>
    @foreach($techforms as $techform)
  
  


  <tr>
  
   @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>
   <td style="color:red">@if($techform->status==1) COMPLETED   @else  ON PROGRESS   @endif</td>

     

    <td>{{ 
   $techform->created_at }}</td>
   
    @if($techform->created_at ==  $techform->updated_at)
   
   
    <td> NOT COMPLETED</td>
    @else
    <td>{{ 
   $techform->updated_at }}</td>
    @endif
    

    @if(auth()->user()->type != 'CLIENT')
   @if($techform->status!=1)
   <td>   <a style="color: black;" href="{{ route('workOrder.technicianComplete', [$techform->id]) }}" data-toggle="tooltip" title="COMPLETE WORK"><i
                                                    class="fas fa-clipboard-check large"></i></a></td>
                          
    </td>
   @endif 
    @endif 

  
  



          @else
          <td style="color: red">No technician assigned yet</td>
      @endif
  
  
  
  </tr>
    @endforeach
  </table>
    @endif
    <br>
     <br>
   <hr>

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
    <th>DATE INSPECTED</th>
  </tr>
    @foreach($iforms as $iform)
  
  
  <tr>
    <td style="color:red" >{{ $iform->status }}</td>
    <td>{{ $iform->description }}</td>
      <td>{{$iform['technician']->lname.' '.$iform['technician']->fname }}</td>
    <td>{{ $iform->date_inspected }}</td>
  </tr>
  
  @endforeach
  </table>
    @endif
    <br>
    <br>
    <hr>


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
    <th>DETAILS</th> 
  <th>STATUS</th>
  <th>MESSAGE</th>
  
    <th>DATE REQUESTED</th>
  </tr>
    @foreach($tforms as $tform)
  
  
  <tr>
    <td>{{ date('F d Y', strtotime($tform->time))  }}</td>
    <td>{{ date('h:i:s A', strtotime($tform->time)) }}</td> 
     <td> <a onclick="myfunc('{{$tform->coments}}')"><span data-toggle="modal" data-target="#viewMessage"
                                                                         class="badge badge-success">View Details</span></a></td>
    <td style="color:red">@if($tform->status==0) WAITING   @elseif($tform->status==1) APPROVED @else REJECTED   @endif</td>
  


     <td> <a onclick="myfunc2('{{$tform->details}}')"><span data-toggle="modal" data-target="#viewdetails"
                                                                         class="badge badge-success">View Message</span></a></td>

  <td>{{ 
   $tform->created_at }}</td>
  </tr>
  
  @endforeach
  </table>
    @endif
    <br>
  
  
  
  
  <br>
   
     <br>
     <hr>
    
  <br>
  @if(auth()->user()->type != 'CLIENT')
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
   <td style="color:red">@if($matform->status==0)<span class="badge badge-success"> WAITING FOR MATERIAL APPROVAL </span> @elseif($matform->status== 1)<span class="badge badge-success">APPROVED BY IOW </span> @elseif($matform->status== 2) <span class="badge badge-primary">RELEASED FROM STORE </span> @elseif($matform->status==20) <span class="badge badge-success">PLEASE CROSSCHECK MATERIAL </span> @elseif($matform->status==17) <span class="badge badge-warning">SOME OF MATERIAL REJECTED </span> @elseif($matform->status== 5)<span class="badge badge-success">MATERIAL ON PROCUREMENT STAGE</span> @elseif($matform->status== 3)<span class="badge badge-primary">MATERIAL TAKEN FROM STORE</span>  @elseif($matform->status == -1)<span class="badge badge-danger">
    REJECTED BY IOW</span>@elseif($matform->status== 15)<span class="badge badge-success">MATERIAL PURCHASED</span>
       @endif</td>
      
   <td>{{$matform->created_at }}</td>
   <td>{{$matform->updated_at }}</td>
   
  </tr>
  
  @endforeach
  
  </table>
    @endif

    <br>
  
  <br>
  <hr>
   @elseif(auth()->user()->type == 'CLIENT')
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
   <td style="color:red">@if($matform->status==0)<span class="badge badge-success"> MATERIAL WAITING FOR APPROVAL </span> @elseif($matform->status== 1)<span class="badge badge-success">MATERIAL APPROVED BY IOW </span> @elseif($matform->status== 2) <span class="badge badge-primary">MATERIAL RELEASED FROM STORE </span> @elseif($matform->status==20) <span class="badge badge-success">MATERIAL REQUESTED </span> @elseif($matform->status==17) <span class="badge badge-warning">MATERIAL ON CHECK BY IOW </span>  @elseif($matform->status== 3)<span class="badge badge-primary">MATERIAL TAKEN FROM STORE</span>  @elseif($matform->status== 5)<span class="badge badge-success">MATERIAL ON PROCUREMENT STAGE</span> @elseif($matform->status == -1)<span class="badge badge-warning">MATERIAL ON CHECK BY IOW</span>@elseif($matform->status== 15)<span class="badge badge-success">MATERIAL PURCHASED</span>
       @endif</td>
      
   <td>{{$matform->created_at }}</td>
   <td>{{$matform->updated_at }}</td>
   
  </tr>
  
  @endforeach
  
  </table>
    @endif

    <br>
  
  <br>
  <hr>
   @endif
     <br>  <br>

     <h4><b>Material Used: </b></h4>
     
  @if(empty($wo['work_order_material']->id))
        <p style="color: red">No Material Used for this Workorder</p>
    @else
    <?php
  
  $idw=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>

<table style="width:100%">
  <tr>
     
    <th>Material Name</th>
    <th>Material Description</th>
     <th>Type</th>
     <th>Quantity</th>  
  </tr>
    @foreach($matforms as $matform)
  <tr>
   <td>{{$matform['material']->name }}</td>
   <td>{{$matform['material']->description }}</td>
   <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
  </tr>
  
  @endforeach
   
       
  </table>
    @endif
    <br>
  
  
    <br>
   

    <hr>
    <div>
 
</div>
    @if(strpos(auth()->user()->type, "HOS") !== false)
         
          @if($wo->status == 30)
            <div>
                <span class="badge badge-warning" style="padding: 20px">Work order completely closed!</span>
            </div>

        @elseif($wo->status == 2)
            <div>
                <span class="badge badge-warning" style="padding: 20px">Work order tempolary closed!</span>
            </div>
        @elseif($wo->status == 52)
            <div>
                <span class="badge badge-warning" style="padding: 20px">Work order is on check by IoW!</span>
            </div>
        @elseif($wo->status == 53)
            <div>
                <span class="badge badge-danger" style="padding: 20px">Work order is not approved by IoW!</span>
            </div>

        @elseif($wo->status == 9)
              <div>
                <form method="POST" action="{{ route('workorder.close.complete', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Close work order completely</button>
                </form>
            </div>
        @elseif($wo->status == 25)
            <div>
                <form method="POST" action="{{ route('workorder.close', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Close work order temporalily</button>
                </form>
            </div>
        @else
            <div>
                <form method="POST" action="{{ route('workorder.inspector', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Notify IoW to verify Work Order before Closing</button>
                </form>
            </div>
      
        @endif
        <div style="padding: 1em;">
         <a href="{{ url('trackreport/'.$wo->id) }}" ><button class="btn btn-primary">
    Print report
  </button></a>
        </div>

    @else
        <div class="row">
            <div>
                {{-- status of 2 means work order has been closed --}}
                @if($wo->status != 2)
                    
                    <!--<form method="POST" action="{{ route('workorder.close', [$wo->id, $wo->updated_by]) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Close work order</button>
                    </form>-->
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
</div>



       <div class="modal fade" id="iowapproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Not satisfied Work order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you are not satisfied with inspection for this work order.</p>
                    <form method="POST" action="{{ route('workorder.notsatisfiedbyiow', [$wo->id]) }}">
                        @csrf
                        <textarea name="notsatisfiedreason" required maxlength="400" class="form-control"  rows="5" id="notsatisfiedreason"></textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




         <div class="modal fade" id="exampleModalu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Not satisfied Work order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you are not satisfied with your work order.</p>
                    <form method="POST" action="{{ route('workorder.notsatisfied', [$wo->id]) }}">
                        @csrf
                        <textarea name="unsatisfiedreason" required maxlength="400" class="form-control"  rows="5" id="unsatisfiedreason"></textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for view Details -->
    <div class="modal fade" id="viewMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: black"><b></b> Details you sent to Transport Officer.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h3 id="comments"><b> </b></h3>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

     <!-- Modal for view Message -->
    <div class="modal fade" id="viewdetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: black"><b></b> Message From Transport Officer.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h3 id="details"><b> </b></h3>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




  

  
         @if($wo->client_id == auth()->user()->id)
           @if($wo->status == 2)
        
        <div style="padding-left:  800px;">
        <div class="row">
                 <div class="row">
                    <form method="POST" action="{{ route('workorder.satisfied', [$wo->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">SATISFIED</button>
                    </form>
                     </div> 
                     &nbsp;&nbsp;&nbsp;&nbsp;
                     <div class="col">
                     <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalu">NOT SATISFIED</button>
                 
                        </div>   
                        </div>  
       </div>

              @endif
        @endif

                  <br>
                   <br>
                    <br>




        @if(auth()->user()->type=='Inspector Of Works')
      
          @if($wo->status == 52)
        <div style="padding-left:  800px;">
        <div class="row">
                 <div class="row">
                    <form method="POST" action="{{ route('workorder.iowapprove', [$wo->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Appprove</button>
                    </form>
                     </div> 
                     &nbsp;&nbsp;&nbsp;&nbsp;
                     <div class="col">
                     <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#iowapproval">Not Satisfied</button>
                 
                        </div>   
                        </div>  
       </div>

                @endif
                 

                  <br>
                   <br>
                    <br>
                     @endif




</div>


<script type="text/javascript">
  
   function myfunc(x) {
            document.getElementById("comments").innerHTML = x;
        }

         function myfunc2(x) {
            document.getElementById("details").innerHTML = x;
  }
</script>

    @endSection