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
        <label for="">Description of the Problem:</label>
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
               <div class="container" >Location - Zone : &nbsp;

                     @if($wo->zonelocationtwo != null) <?php
                           $zonelocation = iowzonelocation::where('id',$wo->zonelocationtwo)->first();
                           $zoned = iowzone::where('id',$zonelocation->iowzone_id)->first();
                            ?>
                            @endif
                            @if($wo->zonelocationtwo != null)

                             {{ $zonelocation->location }} - {{ $zoned->zonename }}
                       @else Not Assigned
                       @endif


               </div>
               </div>


             </form>
           </div>

        @endif
        </div>


  
    <br>
    <br>


<!--assigned technician for inspection-->


    @if(empty($wo['work_order_staffassigned']->id))

    @else

      <?php

  $idwo=$wo->id;
  $techforms = techasigned::with('technician_assigned_for_inspection')->where('work_order_id',$idwo)->get();
?>

  @if(count($techforms) == 1)
    <h4><b>1 Assigned Technician for Inspection </b></h4>
    @else
    <h4><b>{{ count($techforms) }} Assigned Technicians for Inspection  </b></h4>
    @endif

  


<table style="width:100%">

    <thead style=" background-color: #376ad3; color: white; ">
  <tr>
 
  <th>Full Name</th>
     <th>Status </th>
    <th>Date Assigned </th>
     @foreach($techforms as $techform)
     @endforeach
     @if($techform->leader != null )
      <th>Leader </th>
      @endif
  </tr>
</thead>

  <tbody>
    @foreach($techforms as $techform)
  <tr>

     @if($techform['technician_assigned_for_inspection'] != null)
    <td>{{$techform['technician_assigned_for_inspection']->lname.' '.$techform['technician_assigned_for_inspection']->fname}}</td>
   <td >@if($techform->status==1) Completed  @else  On Progress   @endif</td>
   <td>{{ date('d F Y', strtotime($techform->created_at)) }} </td>


<!--
   @if($techform->status==1)

  <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>
    @else


      <td style="color: red"> Not Completed Yet</td>
    @endif -->



      @endif



    @if($techform->leader == null )



                                                   @elseif($techform->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Yes </td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >No</i></td>
                                                    @endif
    
  </tr>
    @endforeach
    </tbody>
  </table>




<br>
   <hr>
    <br>

    @endif

<!--assigned technician for inspection-->







<!--report before work-->



    <?php

  $idwo=$wo->id;
  $iformsbefore = WorkOrderInspectionForm::where('work_order_id',$idwo)->where('status','Inspection report before work')->get();
        ?>
  @if(count($iformsbefore)>0)

  @foreach($iformsbefore as $iformb)
  @endforeach

 <h4><b>Inspection Report Before Work , Reported on: {{ date('d F Y', strtotime($iformb->date_inspected )) }} </b></h4>

    <div class="form-group ">
        <label for="">Description:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $iformb->description }}</textarea>
    </div>
  

  <br>
    <hr>
      <br>



  <br>

    @endif

<!--report before work-->


<!--report after work-->



  

<!-- transport for inspection -->


    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->where('inspection', 0)->get();
?>

    @if(count($tforms)>0)

 <h4><b>Transport Description for Inspection</b></h4>

<table style="width:100%">
  <tr>
     <thead style="color: white;">
    <th>Date of Transport</th>
    <th>Time</th>
    <th>Details</th>
  <th>Status</th>
  <th>Message</th>

    <th>Date</th>
  </thead>
  </tr>
    @foreach($tforms as $tform)


  <tr>
    <td>{{ date('d F Y', strtotime($tform->time))  }}</td>
    <td>{{ date('h:i:s A', strtotime($tform->time)) }}</td>
     <td> <textarea class="form-control" disabled>{{$tform->coments}}</textarea></td>
    <td>@if($tform->status==0) Waiting  @elseif($tform->status==1) Approved @else REJECTED   @endif</td>



     <td><textarea class="form-control" disabled>@if($tform->details == NULL) No message from transport officer @else{{$tform->details}}@endif</textarea></td>

 <td>{{ date('d F Y', strtotime($tform->created_at))  }} </td>

  </tr>

  @endforeach
  </table>
  <br>
     <hr>
       <br>



  <br>
    @endif
    <br>
<!-- transport for inspection -->




<!--assigned technician for work-->

 @if(empty($wo['work_order_staff']->id))

    @else

    <?php

  $idwo=$wo->id;
  $techforms = WorkOrderStaff::with('technician_assigned')->where('work_order_id',$idwo)->get();
?>
 @foreach($techforms as $status)
 @endforeach

@if($status->status5 == 22)

  @if(count($techforms) == 1)
    <h4><b>1 Assigned Technician for Work </b></h4>
    @else
    <h4><b>{{ count($techforms) }} Assigned Technicians for Work  </b></h4>
    @endif

<table style="width:100%">
  <tr>

<thead style="color: white;">
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
 <!-- <th>Date Completed</th>-->
  @foreach($techforms as $techform)
  @endforeach
  @if($techform->leader != null )
  <th>Leader</th>
  @endif
</thead>

  </tr>
    @foreach($techforms as $techform)

  <tr>

     @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>
   <td >@if($techform->status==1) Completed   @else  On Progress   @endif</td>


    <td>{{ date('d F Y', strtotime($techform->created_at)) }}</td>


 <!--  @if($techform->status==1)

  <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>
    @else


      <td style="color: red"> Not Completed Yet</td>
    @endif -->

@if($techform->leader == null )


                                                   @elseif($techform->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Yes </i></td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >No</i></td>
                                                    @endif

      @endif



  </tr>
    @endforeach
  </table>
   <br>

   <hr>
    <br>
 @endif
@endif


<!--assigned technician for work-->



<!-- transport for work -->


    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->where('inspection', 1)->get();
?>

    @if(count($tforms)>0)

 <h4><b>Transport Description for Work</b></h4>

<table style="width:100%">
  <tr>
     <thead style="color: white;">
    <th>Date of Transport</th>
    <th>Time</th>
    <th>Details</th>
  <th>Status</th>
  <th>Message</th>

    <th>Date</th>
  </thead>
  </tr>
    @foreach($tforms as $tform)


  <tr>
    <td>{{ date('d F Y', strtotime($tform->time))  }}</td>
    <td>{{ date('h:i:s A', strtotime($tform->time)) }}</td>
     <td><textarea class="form-control" disabled> {{$tform->coments}}</textarea></td>
    <td >@if($tform->status==0) Waiting  @elseif($tform->status==1) Approved @else REJECTED   @endif</td>



     <td><textarea class="form-control" disabled>@if($tform->details == NULL) No message from transport officer @else{{$tform->details}}@endif</textarea></td>


 <td>{{ date('d F Y', strtotime($tform->created_at))  }} </td>

  </tr>

  @endforeach
  </table>
  <br>
     <hr>
       <br>



  <br>
    @endif
    <br>


<!-- transport for work -->



<!--report after work-->


    <?php

  $idwo=$wo->id;
  $iforms = WorkOrderInspectionForm::where('work_order_id',$idwo)->where('status','Report after work')->get();
        ?>



    @if(count($iforms)>0)


 <h4><b>Technician(s) Report After Work </b></h4>

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




<!--material requests-->

  <br>
  @if(auth()->user()->type != 'CLIENT')
  
  @if(empty($wo['work_order_material']->id))



       <!-- <p >No Material have been requested</p>-->

    @else

       <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
    ?>
    @if(count($matforms) == 1)
    <h4><b>1 Material Requested </b></h4>
    @else
    <h4><b>{{ count($matforms) }} Materials Requested  </b></h4>
    @endif

   

<table style="width:100%">
  <tr>
     <thead style="color: white;">

    <th>Materials Name</th>

  <th>Type</th>
   <th>Quantity</th>
   <!--<th>IoW</th>-->
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
  <!-- <td>{{$matform['iowzone']->name }}</td>-->
       <td>
       @if($matform->accepted_by == NULL)
      <span class="badge badge-warning">Not accepted Yet.</span>
       @else
       {{ $matform['acceptedby']->name }}
       @endif
       </td>
    <td >@if($matform->status==0)<span> Waiting for Approval </span> @elseif($matform->status== 1)<span>Approved by IoW </span> @elseif($matform->status== 2) <span>Released from store</span> @elseif($matform->status==20) <span >Please crosscheck material </span> @elseif($matform->status==17) <span>Some of material rejected </span> @elseif($matform->status== 5)<span>Material on procurement stage</span> @elseif($matform->status== 3)<span>Material taken from store</span>  @elseif($matform->status == -1)<span>
    Rejected by IoW</span>@elseif($matform->status== 15)<span>Material purchased</span>
       @endif</td>

 <td> {{ date('d F Y', strtotime($matform->created_at))  }}</td>

    <td>{{ date('d F Y', strtotime($matform->updated_at))  }} </td>



  </tr>

  @endforeach

  </table>

      <br>

  <br>
  <hr>
    @endif


   @elseif(auth()->user()->type == 'CLIENT')
     
  @if(empty($wo['work_order_material']->id))
     <!--   <p class="text-primary">No Material have been requested</p>-->
      
    @else

    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
    ?>
    @if(count($matforms) == 1)
    <h4><b>1 Material Requested </b></h4>
    @else
    <h4><b>{{ count($matforms) }} Materials Requested  </b></h4>
    @endif

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
  <td >@if($matform->status==0)<span> Waiting for Approval </span> @elseif($matform->status== 1)<span >Approved by IoW </span> @elseif($matform->status== 2) <span>Released from Store </span> @elseif($matform->status==20) <span>Requested to store</span> @elseif($matform->status==17) <span>Some of material rejected </span> @elseif($matform->status== 5)<span>Material on Procurement Stage</span> @elseif($matform->status== 3)<span>Material taken from store</span>  @elseif($matform->status == -1)<span >
    Rejected by IOW</span>@elseif($matform->status== 15)<span>Material Purchased</span>
       @endif</td>

  <td> {{ date('d F Y', strtotime($matform->created_at))  }}</td>

    <td>{{ date('d F Y', strtotime($matform->updated_at))  }} </td>

  </tr>

  @endforeach

  </table>

      <br>

  <br>
  <hr>
    @endif


   @endif
     <br>  <br>

<!--material requests-->



    
  @if(empty($wo['work_order_material']->id))
        <!--<p >No Material Used for this Works order</p>-->
    @else

   
    <?php

  $idw=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>

 @if(count($matforms) == 1)
    <h4><b>1 Material Used and Approved </b></h4>
    @else
    <h4><b>{{ count($matforms) }} Materials Used and Approved  </b></h4>
    @endif

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
    <br>

    <br>


    <hr>
    @endif
  
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
                    <button type="submit" class="btn btn-primary">Close works order completely</button>
                </form>
            </div>
        @elseif($wo->status == 25)
            <div>
                <form method="POST" action="{{ route('workorder.close', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Provisional Close</button>
                </form>
            </div>
        @else

          @if($wo->status == 6)
            <div>
                <form method="POST" action="{{ route('workorder.inspector', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Notify Inspector of work to approve work done</button>
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
                        <button type="submit" class="btn btn-primary">Close work order</button>
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
                        <button type="submit" class="btn btn-primary">Approve</button>
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
