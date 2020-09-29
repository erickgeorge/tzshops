@extends('layouts.master')

@section('title')
    works order
    @endSection

@section('body')
<?php use App\WorkOrderInspectionForm;
    use App\WorkOrderTransport;
    use App\WorkOrderStaff;
    use App\WorkOrderMaterial;
    use App\techasigned;
    use App\iowzonelocation;
      use App\iowzone;

 ?>
 <div class="container">

    <br>
    <div >
        <div class="col-lg-12">
            <h5 style="text-transform: capitalize;">Works order details</h5>
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
                style=" font-weight: bold;">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span> On <h5><span style=" font-weight: bold;">{{ date('d F Y', strtotime($wo->created_at)) }}</span></h5>



        </div>
        <div class="col">
        <h5>  @if($wo->status == 0)Rejected@elseif($wo->status == 1) Accepted @else Processed @endif by <span
                style=" font-weight: bold;">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span></h5>
             <h5 style="color: black">Mobile number: <span style=" font-weight: bold;">{{ $wo['user']->phone }}</span> <br>
              Email: <span style=" font-weight: bold;"> {{ $wo['user']->email }} </span></h5>
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
               aria-describedby="emailHelp" value="{{ ucwords(strtolower($wo->problem_type)) }}" disabled>
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
     <div class="row">
        <div class="col">
            @if($wo->emergency == 1)
            <h6 align="center" style="color:red;"><b>This Works Order Is Emergency &#9888;</b></h6>
             @endif
        </div>
        <div class="col">
            @if($wo->zonelocationtwo != null)

            <form method="POST" action="{{ route('workOrder.edit.zoneloc', [$wo->id]) }}">
               @csrf
               <div class="row">
               <div class="container" >
                   <div class="input-group mb-3">
                   <div class="input-group-prepend">
                       <label style="height: 28px;" class="input-group-text" for="inputGroupSelect01">Zone Location</label>
                   </div>
                   <select  required class="custom-select" id="iowzone" name="location" @if($wo->zone_location != null) disabled @endif>

                     @if($wo->zonelocationtwo != null) <?php
                           $zonelocation = iowzonelocation::where('id',$wo->zonelocationtwo)->first();
                           $zoned = iowzone::where('id',$zonelocation->iowzone_id)->first();
                            ?>
                            @endif
                            @if($wo->zonelocationtwo != null)
                          <option value="{{ $wo->zonelocationtwo }}" selected>

                             {{ $zonelocation->location }}, {{ $zoned->zonename }}
                           </option>
                       @else
                       <option value="" selected>Choose... </option>
                       @endif



                  @foreach($iowzone as $user)
                  <option value="{{ $user->id }}" >{{ $user->location }}</option>
                  @endforeach

                   </select>
               </div>
               </div>
           </div>
          @if($wo->zone_location == null)
               <button type="submit" class="btn btn-primary">Save</button>
          @endif

             </form>

        @endif
        </div>
    </div>




    <h4><b>Assigned Technician(s) for Inspection</b></h4>
    @if(empty($wo['work_order_staffassigned']->id))
       <p >No Technician(s) assigned yet</p>
    @else


    <?php

  $idwo=$wo->id;
  $techforms = techasigned::with('technician_assigned_for_inspection')->where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
    <thead style="color: white;">
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
    <th>Leader</th>
    </thead>

  </tr>
    @foreach($techforms as $techform)
  <tr>

     @if($techform['technician_assigned_for_inspection'] != null)
    <td>{{$techform['technician_assigned_for_inspection']->lname.' '.$techform['technician_assigned_for_inspection']->fname}}</td>
   <td >@if($techform->status==1) Completed   @else  On Progress  @endif</td>

 <td>{{ date('d F Y', strtotime($techform->created_at)) }} </td>

  @if($techform->leader == null)
<td><a style="color: black;" href="{{ route('workOrder.technicianassignleaderinspection', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader"><i
                                                    class="fas fa-user-tie large"></i></a></td>
                                                   @elseif($techform->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Yes </td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >No</i></td>
                                                    @endif




   <!-- @if($techform->status!=1)
   <td>   <a style="color: black;" href="{{ route('workOrder.technicianCompleteinspection', [$techform->id]) }}" data-toggle="tooltip" title="COMPLETE INSPECTION"><i
                                                    class="fas fa-clipboard-check large"></i></a></td>

    </td>
   @endif-->







      @endif





  </tr>
    @endforeach
  </table>


    @endif
   <br>

   <hr>
    <br>





<!--report before work-->

    @if(empty($wo['work_order_inspection']->status))

    @else
    <h4><b>Inspection Report Before Work </b></h4>
    <?php

  $idwo=$wo->id;
  $iforms = WorkOrderInspectionForm::where('work_order_id',$idwo)->where('status','Inspection report before work')->get();
        ?>

<table style="width:100%">
  <tr>
     <thead style="color: white;">

    <th>Description</th>
  <th>Full Name</th>
    <th>Date</th>
  </thead>
  </tr>
    @foreach($iforms as $iform)


  <tr>

    <td><textarea class="form-control" disabled>{{ $iform->description }}</textarea></td>
      <td>{{$iform['technician']->lname.' '.$iform['technician']->fname }}</td>
    <td>{{ date('d F Y', strtotime($iform->date_inspected )) }}</td>
  </tr>

  @endforeach
  </table>
  <br>
    <hr>
      <br>



  <br>

    @endif

<!--report before work-->




  <h4><b>Assigned Technician(s) for Work </b></h4>
@if(empty($wo['work_order_staff']->id))
        <p >No Technician(s) assigned yet</p>
    @else
    <?php

  $idwo=$wo->id;
  $techforms = WorkOrderStaff::with('technician_assigned')->where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
<thead style="color: white;">
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>

  <th>Leader</th>
</thead>

  </tr>
    @foreach($techforms as $techform)




  <tr>

   @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>
   <td >@if($techform->status==1) Completed   @else  On Progress  @endif</td>



   <td>{{ date('d F Y', strtotime($techform->created_at)) }}</td>

    @if($techform->leader == null )

<td>   <a style="color: black;" href="{{ route('workOrder.technicianassignleader', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader"><i
                                                    class="fas fa-user-tie large"></i></a></td>
                                                   @elseif($techform->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Yes</td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >No</i></td>
                                                    @endif


  <!--  @if(auth()->user()->type != 'CLIENT')
   @if($techform->status!=1)
   <td>   <a style="color: black;" href="{{ route('workOrder.technicianComplete', [$techform->id]) }}" data-toggle="tooltip" title="COMPLETE WORK"><i
                                                    class="fas fa-clipboard-check large"></i></a></td>

    </td>
   @endif
    @endif-->






          @else
          <td >No technician(s) assigned yet</td>
      @endif



  </tr>
    @endforeach
  </table>
    @endif
    <br>
     <br>
   <hr>



<!--report after work-->

    @if(empty($wo['work_order_inspection']->status))



        <p >Not inspected yet</p>

    @else


    <?php

  $idwo=$wo->id;
  $iforms = WorkOrderInspectionForm::where('work_order_id',$idwo)->where('status','Report after work')->get();
        ?>




 <h4><b>Inspection Report After Work </b></h4>

<table style="width:100%">
  <tr>
     <thead style="color: white;">

    <th>Description</th>
  <th>Full Name</th>
    <th>Date</th>
  </thead>
  </tr>
    @foreach($iforms as $iform)


  <tr>


    <td><textarea class="form-control" disabled>{{ $iform->description }}</textarea></td>


      <td>{{$iform['technician']->lname.' '.$iform['technician']->fname }}</td>
    <td>{{ date('d F Y', strtotime($iform->date_inspected )) }}</td>
  </tr>

  @endforeach
  </table>

  <br>
    <hr>
      <br>



  <br>

    @endif

<!--report after work-->





  <br>
    <h4><b>Transport Description </b></h4>
  @if(empty($wo['work_order_transport']->work_order_id))
        <p >No Transport requested</p>
    @else
    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
     <thead style="color: white;">
    <th>Date</th>
    <th>Time</th>
    <th>Details</th>
  <th>Status</th>
  <th>Message</th>

    <th>Date Requested</th>
  </thead>
  </tr>
    @foreach($tforms as $tform)


  <tr>
    <td>{{ date('F d Y', strtotime($tform->time))  }}</td>
    <td>{{ date('h:i:s A', strtotime($tform->time)) }}</td>
     <td> <a onclick="myfunc('{{$tform->coments}}')"><span data-toggle="modal" data-target="#viewMessage"
                                                                         class="badge badge-success">View Details</span></a></td>
    <td >@if($tform->status==0) Waiting   @elseif($tform->status==1) Approved @else Rejected   @endif</td>



     <td> <a onclick="myfunc2('{{$tform->details}}')"><span data-toggle="modal" data-target="#viewdetails"
                                                                         class="badge badge-success">View Message</span></a></td>

  <td><?php $time = strtotime($tform->created_at); echo date('d/m/Y',$time);  ?> </td>


  @endforeach
  </table>
    @endif
    <br>




  <br>

     <br>
     <hr>

  <br>
  @if(auth()->user()->type != 'CLIENT')
    <h4><b>Material(s) Request </b></h4>
  @if(empty($wo['work_order_material']->id))

        <p >No Material have been requested</p>

    @else
    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
  <tr>
     <thead style="color: white;">

    <th>Materials Name</th>

  <th>Type</th>
   <th>Quantity</th>
   <th>IoW</th>
   <th>Approved By</th>
    <th>Status</th>
     <th>Date Requested</th>
      <th>Date Updated</th>
       </thead>

  </tr>
    @foreach($matforms as $matform)
  <tr>

    <td>{{$matform['material']->name }}</td>

    <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
   <td>{{$matform['iowzone']->name }}</td>
       <td>
       @if($matform->accepted_by == NULL)
      <span class="badge badge-warning">Not accepted Yet.</span>
       @else
       {{ $matform['acceptedby']->name }}
       @endif
       </td>
    <td >@if($matform->status==0)<span class="badge badge-success"> Waiting for material approval </span> @elseif($matform->status== 1)<span class="badge badge-success">Approved by IoW </span> @elseif($matform->status== 2) <span class="badge badge-primary">Released from store</span> @elseif($matform->status==20) <span class="badge badge-success">Please crosscheck material </span> @elseif($matform->status==17) <span class="badge badge-warning">Some of material rejected </span> @elseif($matform->status== 5)<span class="badge badge-success">Material on procurement stage</span> @elseif($matform->status== 3)<span class="badge badge-primary">Material taken from store</span>  @elseif($matform->status == -1)<span class="badge badge-danger">
    Rejected by IoW</span>@elseif($matform->status== 15)<span class="badge badge-success">Material purchased</span>
       @endif</td>

 <td> {{ date('d F Y', strtotime($matform->created_at))  }}</td>

    <td>{{ date('d F Y', strtotime($matform->updated_at))  }} </td>



  </tr>

  @endforeach

  </table>
    @endif

    <br>

  <br>
  <hr>
   @elseif(auth()->user()->type == 'CLIENT')
      <h4><b>Material(s) Requests </b></h4>
  @if(empty($wo['work_order_material']->id))
        <p class="text-primary">No Material have been requested</p>
    @else
    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
  ?>

<table style="width:100%">
  <tr>
<thead style="color: white;">
    <th>Material Name</th>
    <th>Material Description</th>
    <th>Type</th>
    <th>Quantity</th>
    <th>Status</th>
    <th>Date Requested</th>
    <th>Date Updated</th>
</thead>
  </tr>
    @foreach($matforms as $matform)
  <tr>

    <td>{{$matform['material']->name }}</td>
   <td>{{$matform['material']->description }}</td>
    <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
     <td >@if($matform->status==0)<span class="badge badge-success"> Waiting for material approval </span> @elseif($matform->status== 1)<span class="badge badge-success">Approved by IoW  </span> @elseif($matform->status== 2) <span class="badge badge-primary">Released from store </span> @elseif($matform->status==20) <span class="badge badge-success">Material Requested </span> @elseif($matform->status==17) <span class="badge badge-warning">Material on check by IoW </span>  @elseif($matform->status== 3)<span class="badge badge-primary">Material taken from store</span>  @elseif($matform->status== 5)<span class="badge badge-success">Material on procurement stage</span> @elseif($matform->status == -1)<span class="badge badge-warning">Material on check by IoW</span>@elseif($matform->status== 15)<span class="badge badge-success">Material Purchased</span>
       @endif</td>

  <td> {{ date('d F Y', strtotime($matform->created_at))  }}</td>

    <td>{{ date('d F Y', strtotime($matform->updated_at))  }} </td>

  </tr>

  @endforeach

  </table>
    @endif

    <br>

  <br>
  <hr>
   @endif
     <br>  <br>

     <h4><b>Material(s) Used </b></h4>

  @if(empty($wo['work_order_material']->id))
        <p >No Material Used for this Works order</p>
    @else
    <?php

  $idw=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>

<table style="width:100%">
  <tr>
 <thead style="color: white;">
    <th>Material Name</th>
    <th>Material Description</th>
     <th>Type</th>
     <th>Quantity</th>
  </thead>
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
@if(auth()->user()->type == 'Estates Director')
<div style="padding: 1em;">
  <a href="{{ url('trackreport/'.$wo->id) }}" ><button class="btn btn-primary">
PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button></a>
</div>
@endif
@if(auth()->user()->type == "CLIENT")
<div style="padding: 1em;">
  <a href="{{ url('trackreport/'.$wo->id) }}" ><button class="btn btn-primary">
PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button></a>
</div>
@endif
    @if(strpos(auth()->user()->type, "HOS") !== false)

          @if($wo->status == 30)
            <div>
                <span class="badge badge-success" style="padding: 20px">Works order completely closed!</span>
            </div>

        @elseif($wo->status == 2)
            <div>
                <span class="badge badge-success" style="padding: 20px">Works order is Provisional closed!</span>
            </div>
        @elseif($wo->status == 52)
            <div>
                <span class="badge badge-success" style="padding: 20px">Works order is on check by IoW!</span>
            </div>
        @elseif($wo->status == 53)
            <div>
                <span class="badge badge-success" style="padding: 20px">Works order is not approved by IoW!</span>
            </div>

        @elseif($wo->status == 9)
              <div>
                <form method="POST" action="{{ route('workorder.close.complete', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Close works order completely</button>
                </form>
            </div>
        @elseif($wo->status == 25)
            <div>
                <form method="POST" action="{{ route('workorder.close', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Provisional Close</button>
                </form>
            </div>
        @else

          @if($wo->status == 6)
            <div>
                <form method="POST" action="{{ route('workorder.inspector', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Notify Inspector of work to approve work done</button>
                </form>
            </div>
          @endif

        @endif
        <div style="padding: 1em;">
         <a href="{{ url('trackreport/'.$wo->id) }}" ><button class="btn btn-primary">
    PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
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
                    <h5 class="modal-title" id="exampleModalLabel">Rejecting works order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject this works order.</p>
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
                    <h5 class="modal-title" id="exampleModalLabel">Not satisfied Works order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you are not satisfied with inspection for this works order.</p>
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
                    <h5 class="modal-title" id="exampleModalLabel">Not satisfied Works order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you are not satisfied with your works order.</p>
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
                        <button type="submit" class="btn btn-success">Satisfied</button>
                    </form>
                     </div>
                     &nbsp;&nbsp;&nbsp;&nbsp;
                     <div class="col">
                     <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalu">Not Satisfied</button>

                        </div>
                        </div>
       </div>

              @endif
        @endif

                  <br>
                   <br>
                    <br>




        @if((auth()->user()->type=='Inspector Of Works')||(auth()->user()->type == 'Maintenance coordinator'))

          @if($wo->status == 52)
        <div style="padding-left:  800px;">
        <div class="row">
                 <div class="row">
                    <form method="POST" action="{{ route('workorder.iowapprove', [$wo->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                     </div>
                     &nbsp;&nbsp;&nbsp;&nbsp;
                     <div class="col">
                     <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#iowapproval">Not satisfied</button>

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
