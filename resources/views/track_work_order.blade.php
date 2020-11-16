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
      use App\techwork;
    use App\WoInspectionForm;


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
             <h5>Submited by  <span
                style=" font-weight: bold;">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span><h5>Submited on <span style=" font-weight: bold;">{{ date('d F Y', strtotime($wo->created_at)) }}</span></h5><h5> <h5 style="color: black">Mobile number: <span style=" font-weight: bold;">{{ $wo['user']->phone }}</span>
                  <h5> Email: <span style=" font-weight: bold;"> {{ $wo['user']->email }} </span></h5>



        </div>
        <div class="col">
        <h5>  @if($wo->status == 0)Rejected@elseif($wo->status == 1) Accepted @else Processed @endif by <span
                style=" font-weight: bold;">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span></h5>
             <h5 style="color: black">Mobile number: <span style=" font-weight: bold;">{{ $wo['hos']->phone }}</span> <br>
              Email: <span style=" font-weight: bold;"> {{ $wo['hos']->email }} </span></h5>
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

</div>
 @if(empty($wo->room_id) )


     <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>


        <input style="color: black" type="text" required class="form-control" placeholder="location" name="location"
               aria-describedby="emailHelp" value="{{ $wo->location }}" disabled>
    </div>




    @else

<div class="row">
  <div class="col">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>


        <input style="color: black" type="text" required class="form-control" placeholder="location" name="location"
               aria-describedby="emailHelp" value="{{ $wo['room']['block']['area']['location']->name }}" disabled>
    </div>

  </div>
  <div class="col">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']['area']->name_of_area }}" disabled>
    </div>
  </div>
</div>


<div class="row">
  <div class="col">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Block</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="block" name="block" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']->name_of_block }}" disabled>
    </div>
  </div>

  <div class="col">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Room</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="room" name="room" aria-describedby="emailHelp"
               value="{{ $wo['room']->name_of_room }}" disabled>
    </div>
  </div>
</div>

    @endif




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
    <h4><b>1 Technician assigned for Inspection </b></h4>
    @else
    <h4><b>{{ count($techforms) }} Technicians assigned for Inspection  </b></h4>
    @endif




<table class="table table-striped  display" style="width:100%">

    <thead style=" background-color: #376ad3; color: white; ">
  <tr>
<th>#</th>
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
    <?php $i=0;?>
    @foreach($techforms as $techform)
    <?php $i++ ?>
  <tr>
<td>{{$i}}</td>
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





<!-- transport for inspection -->


    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->where('inspection', 0)->get();
?>

    @if(count($tforms)>0)

 <h4><b>Transport Description for Inspection</b></h4>

<table class="table table-striped  display" style="width:100%">  <tr>
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







<!--report before work-->



    <?php

  $idwo=$wo->id;
  $iformsbefore = WorkOrderInspectionForm::where('work_order_id',$idwo)->where('status','Inspection report before work')->get();
        ?>
  @if(count($iformsbefore)>0)

  @foreach($iformsbefore as $iformb)
  @endforeach

 <h4><b>Inspection Report Before Work , Prepared on: {{ date('d F Y', strtotime($iformb->date_inspected )) }} </b></h4>

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






<!--material requests-->


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



<table class="table table-striped  display" style="width:100%">
  <tr>
     <thead style="color: white;">
    <th>#</th>
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
   <?php $mk=0; ?>
    @foreach($matforms as $matform)
     <?php $mk++; ?>
  <tr>
<td>{{$mk}}</td>
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

<table class="table table-striped  display" style="width:100%">
  <tr>
<thead style="color: white;">
  <th>#</th>
    <th>Material Name</th>
    <th>Material Description</th>
    <th>Type</th>
    <th>Quantity</th>
    <th>Status</th>
    <th>Date Requested</th>
    <th>Date Updated</th>
</thead>
  </tr>
   <?php $ib=0; ?>
    @foreach($matforms as $matform)
     <?php $ib++; ?>
  <tr>
<td>{{$ib}}</td>
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
     <br>


<!--material requests-->




  @if(empty($wo['work_order_material']->id))
        <!--<p >No Material Used for this Works order</p>-->
    @else


    <?php

  $idw=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>

 @if(count($matforms) == 1)
    <h4><b>1 Material Received </b></h4>
    @else
    <h4><b>{{ count($matforms) }} Materials Received  </b></h4>
    @endif

<table class="table table-striped  display" style="width:100%">
  <tr>
 <thead style="color: white;">
  <th>#</th>
    <th>Material Name</th>
    <th>Material Description</th>
     <th>Type</th>
     <th>Quantity</th>
  </thead>
  </tr>
   <?php $ibn=0; ?>
    @foreach($matforms as $matform)
     <?php $ibn++; ?>
  <tr>
  <td>{{$ibn}}</td>
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



 <!--End material requests-->

 <br>


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
    <h4><b>1 Technician assigned for Work </b></h4>
    @else
    <h4><b>{{ count($techforms) }} Technicians assigned for Work  </b></h4>
    @endif

<table class="table table-striped  display" style="width:100%">  <tr>

<thead style="color: white;">
  <th>#</th>
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
   <?php $iii=0;?>
    @foreach($techforms as $techform)
 <?php $iii++;?>
  <tr>
      <td>{{$iii}}</td>
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
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->where('inspection', 1)->where('statusreje', 0)->get();
?>

    @if(count($tforms)>0)

 <h4><b>Transport Description for Work</b></h4>

<table class="table table-striped  display" style="width:100%">
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


  @foreach($iforms as $iform)
  @endforeach

 <h4><b>Report after Work , Prepared on: {{ date('d F Y', strtotime($iform->date_inspected )) }} </b></h4>

 <div class="form-group ">
        <label for="">Description:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $iform->description }}</textarea>
    </div>

  <br>
    <hr>



    @endif

<!--report after work-->



<!--works order first closing-->

 @if($wo->hosclosedate != null)
   @if(($wo->status == 52) or ($wo->status == 2) or ($wo->status == 30) or ($wo->status == 12) or ($wo->status == 53) )
            <div>

<h5><b>Closing works done</b></h5>
             <table class="table table-striped  display" style="width:100%">
                <tr>
                  <thead style="color: white;">
                    <th>#</th>
                  <th>Status</th>
                  <th>Full Name</th>
                  <th>Type</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Date</th>
                  </thead>
                </tr>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Intention to close</td>
                    <td> {{$wo['hoscloses']->fname.' '.$wo['hoscloses']->lname}}</td>
                  @if(strpos( $wo['hoscloses']->type, "HOS") !== false)
                <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($wo['hoscloses']->type), 4, 14)?> </td>
                  @else
              @if($wo['hoscloses']->type == 'Inspector Of Works' )
                <td>Inspector of Works</td>
                    @else
                <td style="text-transform: capitalize;">{{strtolower( $wo['hoscloses']->type) }} </td>
                    @endif
                 @endif
                       <td>{{$wo['hoscloses']->phone}}</td>
                       <td>{{$wo['hoscloses']->email}}</td>
                        <td>{{ date('d F Y', strtotime($wo->hosclosedate)) }}</td>
                  </tr>
                   @if($wo->hosclose2date == null)<!--if rejected by iow-->
                  @if($wo->iowclosedate != null)
                  <tr>
                    <td>2</td>
                    <td>Approved by</td>
                    <td>{{$wo['iowcloses']->fname.' '.$wo['iowcloses']->lname}}</td>
                     @if(strpos( $wo['iowcloses']->type, "HOS") !== false)
                <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($wo['iowcloses']->type), 4, 14)?> </td>
                  @else
              @if($wo['iowcloses']->type == 'Inspector Of Works' )
                <td>Inspector of Works</td>
                    @else
                <td style="text-transform: capitalize;">{{strtolower( $wo['iowcloses']->type) }} </td>
                    @endif
                 @endif
                      <td>{{$wo['iowcloses']->phone}}</td>
                    <td>{{$wo['iowcloses']->email}}</td>
                    <td>{{ date('d F Y', strtotime($wo->iowclosedate)) }}</td>

                  </tr>
                  @endif
                  @endif
                @if($wo->hosclose2date == null)<!--if rejected by iow-->
                 @if($wo->clientclosedate != null)
                  <tr>
                    <td>3</td>
                    <td>Closed Completely</td>
                    <td>{{$wo['clientcloses']->fname.' '.$wo['clientcloses']->lname}}</td>
                     @if(strpos( $wo['clientcloses']->type, "HOS") !== false)
                <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($wo['clientcloses']->type), 4, 14)?> </td>
                  @else
             @if($wo['clientcloses']->type == 'Inspector Of Works' )
                <td>Inspector of Works</td>
                    @else
                <td style="text-transform: capitalize;">{{strtolower( $wo['clientcloses']->type) }} </td>
                    @endif
                 @endif
                     <td>{{$wo['clientcloses']->phone}}</td>
                      <td>{{$wo['clientcloses']->email}}</td>
                    <td>{{ date('d F Y', strtotime($wo->clientclosedate)) }}</td>
                  </tr>
                  @endif
                  @endif

                </tbody>
              </table>

           <hr>
            </div>

    @endif
   @endif




<!--works order first closing-->


<br><br>

  



  <!--tracking after work rejected-->


  @if(($wo->status == 53) and ($wo->iowreject == 0))
              <h5><b>This works order has been rejected by {{ $wo['iowrejected']->type }} {{$wo['iowrejected']->fname.' '.$wo['iowrejected']->lname}} on {{ date('d F Y', strtotime($wo->iowdate)) }}.</b></h5>
              <hr>

   <br>

 <div class="form-group ">
        <label for="">Reason for rejection by Inpector of Work:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{$wo->notsatisfiedreason}}</textarea>
    </div>

  <br>
    <hr>
      <br>

  <br>

  @endif


  @if((($wo->status == 53) or ($wo->status == 30)) and ($wo->iowreject != 0))
  <h5 align="center"><b>Works order processes after being rejected by {{ $wo['iowrejected']->type }} {{$wo['iowrejected']->fname.' '.$wo['iowrejected']->lname}} on {{ date('d F Y', strtotime($wo->iowdate)) }} .</b></h5>
  <hr>
  <br>

  <!--reason for rejection by IoW-->

 <div class="form-group ">
        <label for="">Reason for rejection by Inpector of Work:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{$wo->notsatisfiedreason}}</textarea>
    </div>

  <br>
    <hr>
      <br>


  <!--reason for rejection by IoW-->

  @endif




<!--assigned technician-->



    <?php

  $idwo=$wo->id;
  $techwork = techwork::where('wo_id',$idwo)->get();
?>

  @if(count($techwork) == 0 )

  @else

  @if(count($techwork) == 1)
    <h4><b>1 Technician assigned for Work </b></h4>
    @else
    <h4><b>{{ count($techwork) }} Technicians assigned for Work  </b></h4>
    @endif

 <table class="table table-striped  display" style="width:100%">  <tr>

<thead style="color: white;">
  <th>#</th>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
 <!-- <th>Date Completed</th>-->
  <th>Leader</th>
</thead>

  </tr>
   <?php $ii=0;?>
    @foreach($techwork as $techworks)
  <?php $ii++;?>
  <tr>
 <td>{{$ii}}</td>
     @if($techworks['technician_work'] != null)
    <td>{{$techworks['technician_work']->fname.' '.$techworks['technician_work']->lname}}</td>
   <td >@if($techworks->status==1) Completed   @else  On Progress   @endif</td>


    <td>{{ date('d F Y', strtotime($techworks->created_at)) }}</td>


 <!--  @if($techform->status==1)

  <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>
    @else


      <td style="color: red"> Not Completed Yet</td>
    @endif -->

     @if($techworks->leader == null )

<td>   <a title="Assign as Lead technician" class="btn btn-primary" href="{{ route('workOrder.assignleaderafterrejectiow', [$idwo ,$techworks->id ]) }}" data-toggle="tooltip" title="Assign leader">
    Select</a></td>
                                                   @elseif($techworks->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Yes </i></td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >No</i></td>
                                                    @endif

      @endif



  </tr>
    @endforeach
  </table>
   <br>
   @if($techworks->leader == null )
   <div>  <h5 style="color: blue"><b> Please select lead technician before continuing. </b></h5></div>
    @endif
   <hr>
    <br>
 @endif

<!--assigned technician-->



<!-- transport for work -->


    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->where('inspection', 1)->where('statusreje', 1)->get();
?>

    @if(count($tforms)>0)

 <h4><b>Transport Description for Work</b></h4>

 <table class="table table-striped  display" style="width:100%">
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
     <td> <a onclick="myfunc5('{{$tform->coments}}')"><span data-toggle="modal" data-target="#viewMessage"
                                                                         class="badge badge-success">View Details</span></a></td>
    <td >@if($tform->status==0) Waiting  @elseif($tform->status==1) Approved @else REJECTED   @endif</td>



     <td> <a onclick="myfunc6('{{$tform->details}}')"><span data-toggle="modal" data-target="#viewdetails"
                                                                         class="badge badge-success">View Message</span></a></td>

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
  $report = WoInspectionForm::where('wo_id',$idwo)->get();
        ?>
    @if(count($report)>0)

  @foreach($report as $rp)
  @endforeach

 <h4><b>Report after Work , Prepared on: {{ date('d F Y', strtotime($rp->date_inspected )) }} </b></h4>

 <div class="form-group ">
        <label for="">Description:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $rp->description }}</textarea>
    </div>

  <br>
    <hr>
      <br>

  <br>

    @endif

<!--report after work-->



<!--closing works order after reje-->

 @if($wo->hosclose2date != null)
     @if(($wo->status == 52) or ($wo->status == 2) or ($wo->status == 30) or ($wo->status == 12) or ($wo->status == 53)  or ($wo->status == 30)  )
            <div>

<h5><b>Closing works done</b></h5>
             <table class="table table-striped  display" style="width:100%">
                <tr>
                  <thead style="color: white;">
                    <th>#</th>
                  <th>Status</th>
                  <th>Full Name</th>
                  <th>Type</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Date</th>
                  </thead>
                </tr>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Intention to close</td>
                    <td> {{$wo['hos2close']->fname.' '.$wo['hos2close']->lname}}</td>
                  @if(strpos( $wo['hos2close']->type, "HOS") !== false)
                <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($wo['hos2close']->type), 4, 14)?> </td>
                  @else
                @if($wo['hos2close']->type == 'Inspector Of Works' )
                <td>Inspector of Works</td>
                    @else
                <td style="text-transform: capitalize;">{{strtolower( $wo['hos2close']->type) }} </td>
                    @endif
                 @endif
                       <td>{{$wo['hos2close']->phone}}</td>
                       <td>{{$wo['hos2close']->email}}</td>
                        <td>{{ date('d F Y', strtotime($wo->hosclose2date)) }}</td>
                  </tr>
                  @if($wo->iowclosedate != null)
                  <tr>
                    <td>2</td>
                    <td>Approved by</td>
                    <td>{{$wo['iowcloses']->fname.' '.$wo['iowcloses']->lname}}</td>
                     @if(strpos( $wo['iowcloses']->type, "HOS") !== false)
                <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($wo['iowcloses']->type), 4, 14)?> </td>
                  @else
               @if($wo['iowcloses']->type == 'Inspector Of Works' )
                <td>Inspector of Works</td>
                    @else
                <td style="text-transform: capitalize;">{{strtolower( $wo['iowcloses']->type) }} </td>
                    @endif
                 @endif
                      <td>{{$wo['iowcloses']->phone}}</td>
                    <td>{{$wo['iowcloses']->email}}</td>
                    <td>{{ date('d F Y', strtotime($wo->iowclosedate)) }}</td>

                  </tr>
                  @endif

                 @if($wo->clientclosedate != null)
                  <tr>
                    <td>3</td>
                    <td>Closed Completely</td>
                    <td>{{$wo['clientcloses']->fname.' '.$wo['clientcloses']->lname}}</td>
                     @if(strpos( $wo['clientcloses']->type, "HOS") !== false)
                <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($wo['clientcloses']->type), 4, 14)?> </td>
                  @else
               @if($wo['clientcloses']->type == 'Inspector Of Works' )
                <td>Inspector of Works</td>
                    @else
                <td style="text-transform: capitalize;">{{strtolower( $wo['clientcloses']->type) }} </td>
                    @endif
                 @endif
                     <td>{{$wo['clientcloses']->phone}}</td>
                      <td>{{$wo['clientcloses']->email}}</td>
                    <td>{{ date('d F Y', strtotime($wo->clientclosedate)) }}</td>
                  </tr>
                  @endif

                </tbody>
              </table>

           <hr>
            </div>

    @endif
   @endif

  <!--Closing works order after reje-->


  <!--tracking after work rejected-->



    <!--statussesss-->

    
          @if($wo->status == 30)
            <div>
            <!--    <h4 align="center">Works order completely closed!</h4>-->
            </div>

        @elseif($wo->status == 2)
            <div>
                <h4 align="center" style="padding: 20px">Works order is provisionally closed</h4>
            </div>
        @elseif($wo->status == 52)
            <div>
              <h4 align="center" style="padding: 20px">Waiting Approval of IoW after checking the work done</h4>
            </div>
        @elseif($wo->status == 53)
            <div>
               <h4 align="center" style="padding: 20px">Works order is not approved by IoW</h4>
            </div>

        @elseif($wo->status == 9)
             <!-- <div>
                <form method="POST" action="{{ route('workorder.close.complete', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Close works order completely</button>
                </form>
            </div>-->
        @elseif($wo->status == 25)
          <!--  <div>
                <form method="POST" action="{{ route('workorder.close', [$wo->id, $wo->client_id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Provisional Close</button>
                </form>
            </div>-->
        @else



        @endif


        @if ($wo->systemclosed!=0)
    

            <h4 >This Works Order Was Closed Automatically by a System Due to a Customer Delay of Closing for 7 Days on : {{ date('d F Y', strtotime($wo->updated_at))  }} </h4>
          <hr>  

        @endif    



<!--statusess-->  



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

    @if(auth()->user()->type == 'Inspector Of Works')

    <div style="padding: 1em;">
  <a href="{{ url('trackreport/'.$wo->id) }}" ><button class="btn btn-primary">
PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button></a>
</div>

    @endif


      



 @if(strpos(auth()->user()->type, "HOS") !== false)

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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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




        @if((auth()->user()->type=='Inspector Of Works')||(auth()->user()->type == 'Maintenance coordinator'))

          @if(($wo->status == 52))
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

         @if(($wo->iowreject == 3))
          @if(($wo->status != 2) and ($wo->status != 30))

        <div style="padding-left:  900px;">
        <div class="row">
                 <div class="row">
                    <form method="POST" action="{{ route('workorder.iowapprove', [$wo->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Approve</button>
                    </form>
                     </div>

                        </div>
       </div>
             @endif
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
