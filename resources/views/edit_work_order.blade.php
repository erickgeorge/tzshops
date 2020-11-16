@extends('layouts.master')

@section('title')
  Edit Work order
    @endSection

@section('body')

<?php use App\WorkOrderInspectionForm;
    use App\WorkOrderTransport;
    use App\WorkOrderStaff;
    use App\techasigned;
    use App\WorkOrderMaterial;
    use App\User;
    use App\iowzone;
    use App\iowzonelocation;
    use App\Material;
    use App\techwork;
    use App\WoInspectionForm;

 ?>

<style type="text/css">
.label{
    width: 700px;
}

.box{

        display: none;

    }

</style>


<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
});
</script>


<div class="container">
<script>
var total=2;

</script>
    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h4>Works Order Details</h4>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    <div style="margin-right: 2%; margin-left: 2%;">
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
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type of a problem</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{  ucwords(strtolower($wo->problem_type))  }}" disabled>
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


    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>


        <input style="color: black" type="text" required class="form-control" placeholder="location" name="location"
               aria-describedby="emailHelp" value="{{ $wo['room']['block']['area']['location']->name }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']['area']->name_of_area }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Block</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="block" name="block" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']->name_of_block }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Room</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="room" name="room" aria-describedby="emailHelp"
               value="{{ $wo['room']->name_of_room }}" disabled>
    </div>

    @endif


    <div class="form-group ">
        <label for="">Description of the problem:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
    <br>
    <div class="row">
        <div class="col">
            @if($wo->emergency == 1)
            <h6 align="center" style="color:red;"><b>This Works Order Is Emergency &#9888;</b></h6>
            @else

             @if(($wo->zonelocationtwo != null)&&($wo->zone_location != null))
                @php
                    $zonelocation = iowzonelocation::where('id',$wo->zonelocationtwo)->first();
                    $zoned = iowzone::where('id',$zonelocation->iowzone_id)->first();
                @endphp
                Location - Zone : &nbsp; <b> {{ $zonelocation->location }} - {{ $zoned->zonename }}</b>
                @else
             @endif

             @endif
        </div>
        <div class="col">
        @if($wo->emergency == 1)
             @if(($wo->zonelocationtwo != null)&&($wo->zone_location != null))
                @php
                    $zonelocation = iowzonelocation::where('id',$wo->zonelocationtwo)->first();
                    $zoned = iowzone::where('id',$zonelocation->iowzone_id)->first();
                @endphp
                Location - Zone : &nbsp; <b> {{ $zonelocation->location }} - {{ $zoned->zonename }}</b>
                @else
             @endif
         @endif     

        </div>
   </div>
            @if($wo->zonelocationtwo != null)
            @if($wo->zone_location == null)
            <i class="text-danger">Please Re-save Location - Zone to confirm</i>  <br> <br>
            @endif
            <form method="POST" action="{{ route('workOrder.edit.zoneloc', [$wo->id]) }}">
               @csrf
               <div class="row">
                @if(($wo->zonelocationtwo != null)&&($wo->zone_location != null))
                @php
                    $zonelocation = iowzonelocation::where('id',$wo->zonelocationtwo)->first();
                    $zoned = iowzone::where('id',$zonelocation->iowzone_id)->first();
                @endphp

                @else
               <div class="container" >
                   <div class="input-group mb-3">
                   <div class="input-group-prepend">
                       <label style="height: 28px;" class="input-group-text" for="inputGroupSelect01">Zone, Location</label>
                   </div>
                   <select style="width: 550px;" required class="custom-select" id="iowzone" name="location" @if($wo->zone_location != null) disabled @endif>

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
               @endif
           </div>
          @if($wo->zone_location == null)
               <button type="submit" class="btn btn-primary">Save</button>
          @endif

             </form>

        @endif
        </div>






       <!--  <form method="POST" action="{{ route('workOrder.edit', [$wo->id]) }}">
            @csrf

            <div class="form-group ">

                @if($wo->emergency == 1)
                    <input type="checkbox" name="emergency" checked> <b style="color:red;">This works order is emergency</b>
                @else
                    <input type="checkbox" name="emergency"> <b style="color:red;">This works order is emergency</b>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
          </form>-->






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



 <table class="table table-striped  display" style="width:100%">
  <tr>
     <thead style="color: white;">
      <th>#</th>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
  <!--<th>Date Completed</th>-->
  <th>Leader</th>
     </thead>

  </tr>
   <?php $mi=0; ?>
    @foreach($techforms as $techform)
     <?php $mi++; ?>
  <tr>
<td>{{$mi}}</td>
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


    @if($techform->leader == null )

<td><a title="Assign as Lead technician" class="btn btn-primary" href="{{ route('workOrder.technicianassignleaderinspection', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader">
    Select</a></td>
                                                   @elseif($techform->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Yes </td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >No</i></td>
                                                    @endif
      @endif
  </tr>
    @endforeach
  </table>


@if(($techform->status==0) and ($techform->leader==1))

<br>
<div class="row">
   <div class="col">
<p>Please download the Works Order Inspection Form for Head of Section and Lead Technician to sign.</p>
</div>
<div >
  <a href="{{ url('techforreport/'.$wo->id) }}" ><button class="btn btn-primary">
Download <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button></a>
</div>
</div>
@endif

<br>
   @if($techform->leader == null )
<h5 style="color: blue"><b> Please select lead technician before continuing. </b></h5>
   @endif
   <hr>


    @endif




<!-- transport for inspection -->


    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->where('inspection', 0)->get();
?>

    @if(count($tforms)>0)

 <h4><b>Transport Description for Inspection</b></h4>

<table style="width:100%"> <table class="table table-striped  display" style="width:100%">  <tr>
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
    <td>@if($tform->status==0) Waiting  @elseif($tform->status==1) Approved @else REJECTED   @endif</td>



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




<!--material used and requested-->


  @if(auth()->user()->type != 'CLIENT')

  @if(empty($wo['work_order_material']->id))

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
    <th>Name</th>

  <th>Type</th>
   <th>Quantity</th>
   <th>Approved By</th>
    <th>Status</th>
     <th>Date Requested</th>
      <th>Date Updated</th>
    </thead>

  </tr>
   <?php $m=0; ?>
    @foreach($matforms as $matform)
    <?php $m++ ?>
  <tr>
<td>{{$m}}</td>
    <td>{{$matform['material']->name }}</td>

    <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
       <td>
       @if($matform->accepted_by == NULL)
      <span >Not accepted Yet.</span>
       @else
       {{ $matform['acceptedby']->name }}
       @endif
       </td>
   <td >@if($matform->status==0)<span > Waiting for Material Approval </span> @elseif($matform->status== 1)<span >Approved by IoW </span> @elseif($matform->status== 2) <span >Released from Store </span> @elseif($matform->status==20) <span >Please Crosscheck Material(s) </span> @elseif($matform->status==17) <span >Some of Material Rejected</span> @elseif($matform->status== 5)<span >Material on Procurement Stage</span> @elseif($matform->status== 3)<span >Material Taken From Store</span>
   @elseif($matform->status== 100)<span >Reserved</span> @elseif($matform->status == -1)<span >
    REJECTED BY IOW</span>@elseif($matform->status== 15)<span >Material Purchased</span>
       @endif</td>

  <td> {{ date('d F Y', strtotime($matform->created_at))  }}</td>

    <td>{{ date('d F Y', strtotime($matform->updated_at))  }} </td>


  </tr>

  @endforeach

  </table>
  <br>
    <hr>
    <br>
    @endif




  

   @elseif(auth()->user()->type == 'CLIENT')

  @if(empty($wo['work_order_material']->id))

    @else
     <h4><b>Material(s) Requested: </b></h4>
    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
  ?>

 <table class="table table-striped  display" style="width:100%">
  <tr>
     <thead style="color: white;">
<th>#</th>
    <th>Material Name</th>

  <th>Type</th>
   <th>Quantity</th>
   <th>IoW</th>
   <th>Approved By</th>
    <th>Status</th>
     <th>Date Requested</th>
      <th>Date Updated</th>
    </thead>

  </tr>
   <?php $n=0; ?>
    @foreach($matforms as $matform)
     <?php $n++; ?>
  <tr>
<td>{{$n}}</td>
    <td>{{$matform['material']->name }}</td>

    <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
   <td>{{$matform['iowzone']->name }}</td>
       <td>
       @if($matform->accepted_by == NULL)
      <span >Not accepted Yet.</span>
       @else
       {{ $matform['acceptedby']->name }}
       @endif
       </td>
   <td >@if($matform->status==0)<span > WAITING FOR MATERIAL APPROVAL </span> @elseif($matform->status== 1)<span >APPROVED BY IOW </span> @elseif($matform->status== 2) <span >RELEASED FROM STORE </span> @elseif($matform->status==20) <span >PLEASE CROSSCHECK MATERIAL </span> @elseif($matform->status==17) <span >SOME OF MATERIAL REJECTED </span> @elseif($matform->status== 5)<span >MATERIAL ON PROCUREMENT STAGE</span> @elseif($matform->status== 3)<span >MATERIAL TAKEN FROM STORE</span>  @elseif($matform->status == -1)<span >
    REJECTED BY IOW</span>@elseif($matform->status== 15)<span >MATERIAL PURCHASED</span>
       @endif</td>

  <td><?php $time = strtotime($matform->created_at); echo date('d/m/Y',$time);  ?> </td>

    <td><?php $time = strtotime($matform->updated_at); echo date('d/m/Y',$time);  ?> </td>


  </tr>

  @endforeach

  </table>
    @endif

    <br>

  <br>
  <hr>
    <br>  <br>
   @endif





    <?php

  $idw=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>


  @if(count($matforms) > 0)

   @if(count($matforms) == 1)
    <h4><b>1 Material Received </b></h4>
    @else
    <h4><b>{{ count($matforms) }} Materials Received  </b></h4>
    @endif



 <table class="table table-striped  display" style="width:100%">
  <tr>
     <thead style="color: white;">
<th>#</th>
    <th>Name</th>
    <th> Description</th>
     <th>Type</th>
     <th>Quantity</th>
   </thead>
  </tr>
   <?php $i = 0; ?>
    @foreach($matforms as $matform)
     <?php $i++; ?>
  <tr>
    <td>{{$i}}</td>
   <td>{{$matform['material']->name }}</td>
   <td>{{$matform['material']->description }}</td>
   <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
  </tr>

  @endforeach


  </table>
  <br>

  <hr>

  @endif

    <!--material used and requested-->




<br>



  <!--Technician Assigned for work-->



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

 <table class="table table-striped  display" style="width:100%">
  <tr>

<thead style="color: white;">
  <th>#</th>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
 <!-- <th>Date Completed</th>-->
  <th>Leader</th>
</thead>

  </tr>
   <?php $mo=0; ?>
    @foreach($techforms as $techform)
 <?php $mo++; ?>
  <tr>
<td>{{$mo}}</td>
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

<td>   <a title="Assign as Lead technician" class="btn btn-primary" href="{{ route('workOrder.technicianassignleader', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader">
    Select</a></td>
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
   @if($techform->leader == null )
   <div>  <h5 style="color: blue"><b> Please select lead technician before continuing. </b></h5></div>
   @endif
   <hr>
    <br>
 @endif
@endif
  <!--Technician Assigned for work-->




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
      <br>



  <br>

    @endif

<!--report after work-->





<!--works order first closing-->

 @if($wo->hosclosedate != null)
   @if(($wo->status == 52) or ($wo->status == 2) or ($wo->status == 30) or ($wo->status == 12) or ($wo->status == 53) )
            <div>

<h5><b>Closing Works Order</b></h5>
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
                    @endif>
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







  <!--tracking after work rejected-->

<br>
<br>

  @if(($wo->status == 53) and ($wo->iowreject != 0))
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
    <h4><b>1 Assigned Technician for Work </b></h4>
    @else
    <h4><b>{{ count($techwork) }} Assigned Technicians for Work  </b></h4>
    @endif

 <table class="table table-striped  display" style="width:100%">
  <tr>

<thead style="color: white;">
  <th>#</th>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
 <!-- <th>Date Completed</th>-->
  <th>Leader</th>
</thead>

  </tr>
   <?php $mj=0; ?>
    @foreach($techwork as $techworks)
 <?php $mj++; ?>
  <tr>
<td>{{$mj}}</td>
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
     @if(($wo->status == 52) or ($wo->status == 2) or ($wo->status == 30) or ($wo->status == 12) or ($wo->status == 53) )
            <div>

<h5><b>Closing Works Order</b></h5>
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

  <!--statusesss-->
 
  <!--statusess-->

  




       <div id="div-manual">


     @if($wo->zonelocationtwo == null)

     Assign Zone Location
     <br>
     <br>

                 <form method="POST" action="{{ route('workOrder.edit.zoneloctwo', [$wo->id]) }}">
            @csrf
            <div class="row">
            <div class="container" >
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="height: 28px;" class="input-group-text" for="inputGroupSelect01">Zone Location</label>
                </div>
                <select style="width: 350px;" required class="custom-select" id="iowzone" name="location" >

            <option value="">Select Zone Location</option>
               @foreach($iowzone as $user)
               <option value="{{ $user->id }}" >{{ $user->location }}</option>
               @endforeach

                </select>
            </div>
            </div>
        </div>
       @if($wo->zonelocationtwo == null)
            <button type="submit" class="btn btn-primary">Save</button>
       @endif

          </form>
     @endif




       </div>


 @if($wo->zone_location  != null)

 <!--       <br>
        <h4>WORKS ORDER FORMS</h4>
        <hr> -->

        {{-- tabs --}}
        <div class="payment-section-margin">
           <!--
                <div class="container-fluid">
                    <div class="tab-group row">
                      <button required class="tablinks col-md-3" onclick="openTab(event, 'assigntechnicianforinspection')"><b style="color:black">ASSIGN TECHNICIAN FOR INSPECTION</b></button>

                       <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'customer')">INSPECTION FORMS</button>

                        <button required class="tablinks col-md-3" onclick="openTab(event, 'assigntechnician')"><b style="color:black">ASSIGN TECHNICIAN FOR WORK</b></button>

                        <button  style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'request_transport')">REQUEST TRANSPORT
                        </button>
                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'material_request')" id="defaultOpen">MATERIAL REQUEST FORM</button>

                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'material_request_store')" id="defaultOpen">MATERIAL REQUEST FROM STORE</button>
                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'crosscheck_material_requested')" id="defaultOpen">CROSS CHECK MATERIAL REQUESTED</button>


                    </div>
                </div>

              -->







            {{-- Require Material  --}}
                @if(($wo->status == 5) and ($wo->requirematerial == NULL))

                <div>  <h5 style="color: blue"><b> Does this works order need material(s)? </b></h5></div>

                <div>
                     <label><input type="radio" name="colorRadio" value="greeno"> Yes</label> &nbsp;
                     <label><input type="radio" name="colorRadio" value="redo"> No</label>
                </div>

                @endif
           {{-- Require Material  --}}



            {{-- ASSIGN TECHNICIAN tab--}}


                    <div >

   @if(($wo->status == 5)||($wo->status == 40)) {{--Status for assigning technician 5: requires and 40: not requires materials--}}


                 @if(((($wo->statusmform == 3) || ($wo->statusmform == 4)) and ($wo->requirematerial == NULL) )  or ($wo->status == 40 ))

<br>
<div class="redo box">
                        <div class="row">
                            <div class="col-md-6">
                                <p>ASSIGN TECHNICIAN(S) FOR THIS WORKS ORDER</p>
                            </div>
                        </div>


 <!--techniciantable-->
 @if(($wo->status == 5)||($wo->status == 40))

 <table style="width:100%">
  <tr>

<thead style="color: white;">
    <th>Full Name</th>
  <th>Action</th>

</thead>

  </tr>
    @foreach($techforms as $techform)

  <tr>

     @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>

                                                    <td>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this technician from the list? ')"
                                          action="{{ route('workOrder.techniciandelete', [$techform->id]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                                </div></td>


      @endif



  </tr>
    @endforeach
  </table>
@endif

 <!--techniciantable-->

 <br>

<p style="color: blue;">Do you want to add another Technician(s) for work?</p>
<style type="text/css">
    .selectt {
      display: none;
   }
  </style>
  <script type="text/javascript">
      $(document).ready(function() {
        $('input[type="checkbox"]').click(function() {
          var inputValue = $(this).attr("value");

        var targetBox = $("." + inputValue);
        $(".selectt").not(targetBox).hide();
        $(targetBox).show();

        });
      });
</script>

<div>
      <label>
        <input class="example" type="checkbox" name="colorCheckbox"
          value="C">&nbsp;Yes   </label>
      <label> &nbsp;
        <input class="example" type="checkbox" name="colorCheckbox"
          value="Cplus">&nbsp;No</label>
    </div>
    <script type="text/javascript">
                                      $('input.example').on('change', function() {
                                        $('input.example').not(this).prop('checked', false);
                                    });
                                    </script>

    <div class="Cplus selectt">
    Satisfied with already assigned Technician(s)
  <form  method="POST" action="{{ route('satisfiedwithtechnician', [$wo->id]) }}">
            @csrf
     <button  type="submit" class="btn btn-primary bg-primary">Submit</button>

  </form></div>
    <div class="C selectt">
  <!--addtech-->
                        <form method="POST" action="{{ route('work.assigntechnician', [$wo->id]) }}">
                        @csrf
                          <div class="form-group">
                          <!-- <input  id="technician_work"  type="text" hidden> </input>  -->

              <TABLE id="dataTable1" width="350px" >
                  <TR>
                       <TD><INPUT type="checkbox" name="chk[]"/></TD>

                       <TD>
                            <select  required  name="technician_work[]" style="background-color:white; width: 700px;

                              border: 1px solid var(--select-border);
                              border-radius: 0.25em;
                              padding: 0.25em 0.5em;
                              font-size: 1.25rem;
                              cursor: pointer;
                              line-height: 1.1;
                              ">
                              <option selected value="">Choose technician ...</option>
                               <?php
                $p=-1;
      ?>

                                @foreach($techswork as $tech)
                                <?php

                                   $wo_technician_count = WorkOrderStaff::
                                   select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                                   ->where('status',0)
                                   ->where('staff_id',$tech->id)
                                   ->groupBy('staff_id')
                                   ->first();

                               ?>
                               @if(empty($wo_technician_count->total_wo))
                                   <?php $t=0;?>

                               @else
                                    <?php $t=$wo_technician_count->total_wo;?>

                                @endif

                              <?php
                             $p++;
                              $name[$p]=$tech->fname.' '.$tech->lname;
                              $ident[$p]=$tech->id;
                              $cwo[$p]=$t;

                              ?>



                                @endforeach
                                <?php
                                for($i=0;$i<=$p-1;$i++){
                                    for($j=$i+1 ;$j<=$p;$j++){
                                        if($cwo[$i]>$cwo[$j]){
                                            $t1=$name[$i];
                                            $t2=$ident[$i];
                                            $t3=$cwo[$i];

                                            $name[$i]=$name[$j];
                                            $ident[$i]=$ident[$j];
                                            $cwo[$i]=$cwo[$j];


                                            $name[$j]=$t1;
                                            $ident[$j]=$t2;
                                            $cwo[$j]=$t3;
                                }}}

                                    for($x=0;$x<=$p;$x++){
                                    ?><option  value="{{ $ident[$x] }}"> {{$name[$x].'        - assigned ('.$cwo[$x].') Works Orders'}} </option>
                                    <?php }  ?>


                            </select>
                              </TD>


                  </TR>
        </TABLE>

                        </div>

                        <INPUT class="btn btn-outline-primary" type="button" value="Add Row" onclick="addRow1('dataTable1')" />

                        <INPUT class="btn btn-outline-danger" type="button" value="Delete Row" onclick="deleteRow1('dataTable1')" />
                        <br><br>

                        <button  type="submit" class="btn btn-primary bg-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </form>


<!--addtech-->
</div>




                @else
               <div align="center" style="color: red;">@if($wo->requirematerial == NULL)  @else   @endif</div>
                @endif
                    </div>





@endif

<div>

<!--comaprison-->
      <?php

  $idw=$wo->id;
  $received = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>  


 <?php

  $idwo=$wo->id;
  $requested = WorkOrderMaterial::where('work_order_id',$idwo)->get();
    ?>

<!--comaprison-->
@if(count($requested) == count($received))

<!--after material corrected from store-->


   @if((($wo->status == 40)) and ($wo->requirematerial == 1))



<br>

                        <div class="row">
                            <div class="col-md-6">
                                <p>ASSIGN TECHNICIAN(S) FOR THIS WORKS ORDER</p>
                            </div>
                        </div>


 <!--techniciantable-->


 <table style="width:100%">
  <tr>

<thead style="color: white;">
    <th>Full Name</th>
  <th>Action</th>

</thead>

  </tr>
    @foreach($techforms as $techform)

  <tr>

     @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>

                                                    <td>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this technician from the list? ')"
                                          action="{{ route('workOrder.techniciandelete', [$techform->id]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                                </div></td>


      @endif



  </tr>
    @endforeach
  </table>

   <br>

<p style="color: blue;">Do you want to add another Technician(s) for work?</p>
<style type="text/css">
    .selectt {
      display: none;
   }
  </style>
  <script type="text/javascript">
      $(document).ready(function() {
        $('input[type="checkbox"]').click(function() {
          var inputValue = $(this).attr("value");

        var targetBox = $("." + inputValue);
        $(".selectt").not(targetBox).hide();
        $(targetBox).show();

        });
      });
</script>

<div>
      <label>
        <input class="example" type="checkbox" name="colorCheckbox"
          value="C">&nbsp;Yes   </label>
      <label> &nbsp;
        <input class="example" type="checkbox" name="colorCheckbox"
          value="Cplus">&nbsp;No</label>
</div>
    <script type="text/javascript">
                                      $('input.example').on('change', function() {
                                        $('input.example').not(this).prop('checked', false);
                                    });
                                    </script>

    <div class="Cplus selectt">
    Satisfied with already assigned Technician(s)
  <form  method="POST" action="{{ route('satisfiedwithtechnician', [$wo->id]) }}">
            @csrf
     <button  type="submit" class="btn btn-primary bg-primary">Submit</button>

  </form></div>



 <!--techniciantable-->

            <div class="C selectt">
                        <form method="POST" action="{{ route('work.assigntechnician', [$wo->id]) }}">
                        @csrf
                          <div class="form-group">
                          <!-- <input  id="technician_work"  type="text" hidden> </input>  -->

              <TABLE id="dataTable22" width="350px" >
                  <TR>
                       <TD><INPUT type="checkbox" name="chk[]"/></TD>

                       <TD>
                            <select   id="techidc" required class="custom-select"  name="technician_work[]" style="width: 700px;">
                              <option selected value="">Choose technician ...</option>






                               <?php
                $p=-1;
      ?>

                                @foreach($techswork as $tech)
                                <?php

                                $wo_technician_count = WorkOrderStaff::
                     select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                     ->where('status',0)
                     ->where('staff_id',$tech->id)
                     ->groupBy('staff_id')
                     ->first();

                               ?>
                               @if(empty($wo_technician_count->total_wo))
                                   <?php $t=0;?>

                               @else
                                    <?php $t=$wo_technician_count->total_wo;?>

                                @endif

                              <?php
                             $p++;
                              $name[$p]=$tech->fname.' '.$tech->lname;
                              $ident[$p]=$tech->id;
                              $cwo[$p]=$t;

                              ?>



                                @endforeach
                                <?php
                                for($i=0;$i<=$p-1;$i++){
                                    for($j=$i+1 ;$j<=$p;$j++){
                                        if($cwo[$i]>$cwo[$j]){
                                            $t1=$name[$i];
                                            $t2=$ident[$i];
                                            $t3=$cwo[$i];

                                            $name[$i]=$name[$j];
                                            $ident[$i]=$ident[$j];
                                            $cwo[$i]=$cwo[$j];


                                            $name[$j]=$t1;
                                            $ident[$j]=$t2;
                                            $cwo[$j]=$t3;
                                }}}

                                    for($x=0;$x<=$p;$x++){
                                    ?><option  value="{{ $ident[$x] }}"> {{$name[$x].'        - assigned ('.$cwo[$x].') Works Orders'}} </option>
                                    <?php }  ?>


                            </select>
                              </TD>


                  </TR>
        </TABLE>

                        </div>

                        <INPUT class="btn btn-outline-primary" type="button" value="Add Row" onclick="addRow22('dataTable22')" />

                        <INPUT class="btn btn-outline-danger" type="button" value="Delete Row" onclick="deleteRow22('dataTable22')" />
                        <br><br>

                        <button  type="submit" class="btn btn-primary bg-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </form>

                  </div>

@endif

<div>


<!--after material corrected from store-->
@endif

<!--comaparison-->




                {{-- end ASSIGN TECHNICIAN  --}}




                {{-- ASSIGN TECHNICIAN tab--}}

                    @csrf
                    <div >

                       @if($wo->statusmform == 1)
                       <br>

                        <div class="row">
                            <div class="col-md-6">
                                <p>ASSIGN TECHNICIAN(S) FOR INSPECTION</p>
                            </div>
                        </div>
                        <div >
                        <p id="alltechdetails"> </p>
                        </div>



                        <form method="POST" action="{{ route('work.assigntechnicianforinspection', [$wo->id]) }}">
                        @csrf
                          <div class="form-group">

          <TABLE id="dataTable" width="350px" >
                  <TR>
                       <TD><INPUT type="checkbox" name="chk[]"/></TD>

                       <TD>

                            <select   id="techidfoxrinspection" required class="custom-select"  name="technician_work[]" style="width: 700px;">
                              <option selected value="">Choose technician...</option>


                               <?php
                $p=-1;
            ?>

                                @foreach($techs as $tech)
                                <?php

                                $wo_technician_count = techasigned::
                     select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                     ->where('status',0)
                     ->where('staff_id',$tech->id)
                     ->groupBy('staff_id')
                     ->first();

                               ?>
                               @if(empty($wo_technician_count->total_wo))
                                   <?php $t=0;?>

                               @else
                                    <?php $t=$wo_technician_count->total_wo;?>

                                @endif

                              <?php
                             $p++;
                              $name[$p]=$tech->fname.' '.$tech->lname;
                              $ident[$p]=$tech->id;
                              $cwo[$p]=$t;

                              ?>

                                @endforeach
                                <?php
                                for($i=0;$i<=$p-1;$i++){
                                    for($j=$i+1 ;$j<=$p;$j++){
                                        if($cwo[$i]>$cwo[$j]){
                                            $t1=$name[$i];
                                            $t2=$ident[$i];
                                            $t3=$cwo[$i];

                                            $name[$i]=$name[$j];
                                            $ident[$i]=$ident[$j];
                                            $cwo[$i]=$cwo[$j];


                                            $name[$j]=$t1;
                                            $ident[$j]=$t2;
                                            $cwo[$j]=$t3;
                                }}}

                                    for($x=0;$x<=$p;$x++){
                                    ?><option  value="{{ $ident[$x] }}"> {{$name[$x].'        - assigned ('.$cwo[$x].') Works orders'}} </option>
                                    <?php }  ?>


                            </select>
                       </TD>


                  </TR>
        </TABLE>

                        </div>

                        <INPUT class="btn btn-outline-primary" type="button" value="Add Row" onclick="addRow('dataTable')" />

                        <INPUT class="btn btn-outline-danger" type="button" value="Delete Row" onclick="deleteRow('dataTable')" />
                        <br><br>

                       <div> <button  type="submit" class="btn btn-primary bg-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a> </div>
                    </form>
                              @else
               <div align="center" style="color: red;"><!-- You have already assigned technician for inspection for this works order.--></div>
                @endif

                    </div>



                {{-- end ASSIGN TECHNICIAN  --}}



                {{-- INSPECTION tab--}}


 <?php
 $tech = techasigned::where('work_order_id',$wo->id)->where('leader2', 3)->first();
  ?>

  @if(($wo->status == 70) || ($wo->status == 3) || ($wo->status == 4) || ($wo->status == 101))  <!--status for inspection report before work and after work-->



     {{-- request_transport form--}}
     @if($wo->status == 70)

         @if(empty($tech))
     <!--     <h5 style="color: blue"><b> Please select lead technician before continuing. </b></h5>-->
         @else

          <h5 style="color: blue"><b> Does this works order need transport for inspection? </b></h5>

         <label><input type="radio" name="colorRadio" value="red">Yes</label> &nbsp;
         <label><input type="radio" name="colorRadio" value="green"> No</label>

           <div class="red box">

                     <form method="POST" onsubmit="return confirm('Are you sure you have signed works order inspection form? ')" action="{{ route('work.transport', [$wo->id]) }}">
                    @csrf
                    <div >
                   @if($wo->statusmform != 1)


                  <br>
                        <div class="row">
                            <div class="col-md-6">
                                <p>INSPECTION TRANSPORT REQUEST FORM</p>
                            </div>
                        </div>
                </br>

                        <input  value="0" name="inspection" hidden></input>
                        <input  value="4" name="status" hidden></input>

                        <p>Transport date <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;" name="date" required class="form-control" min="<?php echo date('Y-m-d'); ?>"  rows="5" id="date"></input>
                        </div>

                          <p>Transport time <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="time" style="color: black; width:  700px;" name="time" required class="form-control"  id="time"></input>
                        </div>

                         <p>Transport details <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <textarea  style="color: black;width: 700px;" name="coments" required maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>
                        <br>


                        <button style=" color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>

                </form>

             </div>

           </div>


             <div class="green box">

           <form method="POST" onsubmit="return confirm('Are you sure you have signed works order inspection form? ')" action="{{ route('work.inspection', [$wo->id]) }}">
               @csrf
                        <div class="row">
                            <div class="col-md-6">

                                <p><b>INSPECTION REPORT BEFORE WORK</b></p>


                            </div>
                        </div>


                         <div class="form-group">

                          <select hidden class="custom-select" required name="status" style="color: black; width:  700px;">


                                    <option selected value="Inspection report before work">Inspection report before work</option>

                         </select>


                          </div>

                        <p>Description <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="200" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        </br>
                        <p>Inspection date <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Technician leader</label>
                            <br>


                                   <!-- <option selected value="{{ $tech->staff_id }}">{{ $tech['technician_assigned_for_inspection']->lname.' '.$tech['technician_assigned_for_inspection']->fname }}
                                    </option>-->

                                      <input hidden class="form-control" required value="{{ $tech->staff_id }}"  name="technician" >

                                       <input disabled class="form-control"  style="color: black; width:  700px;" value="{{ $tech['technician_assigned_for_inspection']->lname.' '.$tech['technician_assigned_for_inspection']->fname }}">
                        </div>






                      <h6 style="color: blue"><b>Was this works order fixed and completed? </b></h6>
                     <div class="form-group options">
                       <input  class="example" type="checkbox" name="fixed" value="1" required />Yes &nbsp;
                       <input  class="example" type="checkbox" name="notfixed" required /> No
                     </div>
<!--script for checkbox-->
                                    <script type="text/javascript">
                                      $('input.example').on('change', function() {
                                        $('input.example').not(this).prop('checked', false);
                                    });
                                    </script>

                                    <script type="text/javascript">
                                      $(function(){
                                        var requiredCheckboxes = $('.options :checkbox[required]');
                                        requiredCheckboxes.change(function(){
                                            if(requiredCheckboxes.is(':checked')) {
                                                requiredCheckboxes.removeAttr('required');
                                            } else {
                                                requiredCheckboxes.attr('required', 'required');
                                            }
                                        });
                                    });
                                    </script>
<!--script for checkbox-->

                        <button style=" color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
             </form>

             </div>

      @endif

    @endif
                </div>





        </div>





                @endif
                {{-- end request_transport form for inspection --}}




                {{-- request_transport form for work--}}

 @if($wo->status == 3)

    <?php
   $techafter = WorkOrderStaff::where('work_order_id',$wo->id)->where('leader2', 3)->first();
   ?>
   @if(empty($techafter))

     <!-- <div>  <h5 style="color: blue"><b> Please select lead technician before continuing. </b></h5></div>-->

   @else

          <div>  <h5 style="color: blue"><b> Does this works order need transport for work? </b></h5></div>

                <div>
                     <label><input type="radio" name="colorRadio" value="greetra"> Yes</label> &nbsp;
                     <label><input type="radio" name="colorRadio" value="redtra"> No</label>
                </div>

   <div class="greetra box">
                <form method="POST" action="{{ route('work.transport', [$wo->id]) }}">
                    @csrf
                  @if($wo->statusmform != 1)
                  <br>
                        <div class="row">
                            <div class="col-md-6">
                                <p>WORK TRANSPORT REQUEST FORM</p>
                            </div>
                        </div>
                </br>

                         <input  value="1" name="inspection" hidden></input>
                         <input  value="101" name="status" hidden></input>

                        <p>Transport date <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;" name="date" required class="form-control" min="<?php echo date('Y-m-d'); ?>"  rows="5" id="date">
                        </div>

                          <p>Transport time <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="time" style="color: black; width:  700px;" name="time" required class="form-control"  id="time">
                        </div>

                         <p>Transport details <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <textarea  style="color: black;width: 700px;" name="coments" required maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>
                        <br>


                        <button style="color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>
</div>


<div class="redtra box">
<br>
  <div class="row">
                            <div class="col-md-6">

                                <p><b>TECHNICIAN REPORT AFTER WORK</b></p>


                            </div>
                        </div>

               <form method="POST" action="{{ route('work.inspection', [$wo->id]) }}">
                 @csrf
                         <div class="form-group">

                          <select hidden class="custom-select" required name="status" style="color: black; width:  700px;">




                                       <option selected value="Report after work">Report after work</option>

                         </select>


                          </div>

                        <p>Description</p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="200" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        </br>
                        <p>Inspection date</p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Technician leader</label>
                            <br>
                                     <input hidden class="form-control" required value="{{ $techafter->staff_id }}"  name="technician" >

                                       <input disabled class="form-control"  style="color: black; width:  700px;" value="{{ $techafter['technician_assigned']->lname.' '.$techafter['technician_assigned']->fname }}">


                        </div>



                        <button style=" color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>

         </div>

                @endif

  @endif

                </div>


                @endif
                {{-- end request_transport form for work --}}




{{--inspection before work--}}

                <br>
                <form method="POST" action="{{ route('work.inspection', [$wo->id]) }}">
                    @csrf
                    <div >
 @if($wo->statusmform != 1)
 @if($wo->status == 4)


  @if(empty($tech))
  @else


                        <div class="row">
                            <div class="col-md-6">

                                <p><b>INSPECTION REPORT BEFORE WORK</b></p>


                            </div>
                        </div>


                         <div class="form-group">

                          <select hidden class="custom-select" required name="status" style="color: black; width:  700px;">


                                    <option selected value="Inspection report before work">Inspection report before work</option>

                         </select>


                          </div>

                        <p>Description <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="200" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        </br>
                        <p>Inspection date <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Technician leader</label>
                            <br>


                                   <!-- <option selected value="{{ $tech->staff_id }}">{{ $tech['technician_assigned_for_inspection']->lname.' '.$tech['technician_assigned_for_inspection']->fname }}
                                    </option>-->

                                      <input hidden class="form-control" required value="{{ $tech->staff_id }}"  name="technician" >

                                       <input disabled class="form-control"  style="color: black; width:  700px;" value="{{ $tech['technician_assigned_for_inspection']->lname.' '.$tech['technician_assigned_for_inspection']->fname }}">

                        </div>

                    <h6 style="color: blue"><b>Was this works order fixed and completed? </b></h6>
                     <div class="form-group options">
                       <input  class="example" type="checkbox" name="fixed" value="1" required /> Yes &nbsp;
                       <input  class="example" type="checkbox" name="notfixed"  required /> No
                     </div>
<!--script for checkbox-->
                                    <script type="text/javascript">
                                      $('input.example').on('change', function() {
                                        $('input.example').not(this).prop('checked', false);
                                    });
                                    </script>

                                    <script type="text/javascript">
                                      $(function(){
                                        var requiredCheckboxes = $('.options :checkbox[required]');
                                        requiredCheckboxes.change(function(){
                                            if(requiredCheckboxes.is(':checked')) {
                                                requiredCheckboxes.removeAttr('required');
                                            } else {
                                                requiredCheckboxes.attr('required', 'required');
                                            }
                                        });
                                    });
                                    </script>
<!--script for checkbox-->

                        <button style=" color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>

    @endif
    @endif
               @else
               <div align="center" style="color: red;"> Please assign technician for inspection before filling inspection form. </div>
                @endif
                 </div>



    {{-- end inspection before work--}}



    {{--inspection after work--}}

                <br>
                <form method="POST" action="{{ route('work.inspection', [$wo->id]) }}">
                    @csrf
                    <div>
@if($wo->statusmform != 1)
@if($wo->status == 101)

 <?php
   $techafterwork = WorkOrderStaff::where('work_order_id',$wo->id)->where('leader2', 3)->first();
   ?>

 @if(empty($techafterwork))

 @else
                        <div class="row">
                            <div class="col-md-6">

                                <p><b>TECHNICIAN REPORT AFTER WORK</b></p>


                            </div>
                        </div>


                         <div class="form-group">

                          <select hidden class="custom-select" required name="status" style="color: black; width:  700px;">




                                       <option selected value="Report after work">Report after work</option>

                         </select>


                          </div>

                        <p>Description</p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="200" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        </br>
                        <p>Inspection date</p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Technician leader</label>
                            <br>
                                     <input hidden class="form-control" required value="{{ $techafterwork->staff_id }}"  name="technician" >

                                       <input disabled class="form-control"  style="color: black; width:  700px;" value="{{ $techafterwork['technician_assigned']->lname.' '.$techafterwork['technician_assigned']->fname }}">


                        </div>



                        <button style=" color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>
  @endif
  @endif


                @endif
                 </div>



    {{-- end inspection after work--}}



                 {{-- request_transport form--}}
                <form method="POST" action="{{ route('work.transport', [$wo->id]) }}">
                    @csrf
                    <div id="request_transport" class="tabcontent">
                  @if($wo->statusmform != 1)
                        <div class="row">
                            <div class="col-md-6">
                                <p style="text-transform: capitalize;">Works Order transport request details</p>
                            </div>
                        </div>
                </br>
                        <p>Transport date</p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;" name="date" required class="form-control" min="<?php echo date('Y-m-d'); ?>"  rows="5" id="date"></input>
                        </div>

                          <p>Transport time</p>
                        <div class="form-group">
                            <input type="time" style="color: black; width:  700px;" name="time" required class="form-control"  id="time"></input>
                        </div>


                    @endif
 {{-- end inspection --}}


@endif

                {{-- material_request tab--}}

<div class="greeno box">
                 <div >
                <form method="POST"  action="{{ route('work.materialadd', [$wo->id]) }}" >
                    @csrf



                        <?php
                         $materials = Material::orderby('description', 'ASC')->get();
                        ?>

                    @if($wo->status == 5)

                         @if(($wo->statusmform == 3))

                        <div class="row">
                            <div class="col-md-6">
                                <p>MATERIAL(S) REQUEST FORM</p>
                            </div>
                        </div>

                        <input type="text" name="zone" value="{{ $zoned->id }}" hidden>


                          <div id="customatedtable">




  <div id="cont">

        </div>
    <input id="totalmaterials" type="text" name="totalinputs" value="" hidden>
    <p>
        <div class="row">
            <div class="col">
                <a id="addRow" onclick="addRow()" class="btn btn-outline-info"><i class="fa fa-plus"></i> Add New Row</a>
            </div>
        </div><br>
        <div class="row">

      <div class="col">
        <button id="bt" type="submit" class="btn btn-primary" disabled>Save</button>&nbsp;<a href="#" onclick="closeTab()"><button type="button" class="btn btn-danger">Cancel</button></a>
      </div>
    </div>
    </p>

                        </div>
                     </form>

<script>
    // ARRAY FOR HEADER.
    var arrHead = new Array();
    arrHead = ['','Material', 'Quantity', ];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

    // FIRST CREATE A TABLE STRUCTURE BY ADDING A FEW HEADERS AND
    // ADD THE TABLE TO YOUR WEB PAGE.
    function createTable() {
        var MatForm = document.createElement('table');
        MatForm.setAttribute('id', 'dataTablemat');
        MatForm.setAttribute('class', 'table');
        MatForm.setAttribute('align', 'center');                     // SET THE TABLE ID.

        var tr = MatForm.insertRow(-1);

        for (var h = 0; h < arrHead.length; h++) {
            var th = document.createElement('th');


            if(h==0){
                  th.setAttribute('style','width:5px;');
                }


                if(h==1){
                  th.setAttribute('style','width:300px;');
                }

                if(h ==2){
                    th.setAttribute('style','width:100px;');
                }

                     // TABLE HEADER.
            th.innerHTML = arrHead[h];
            tr.appendChild(th);
        }

        var div = document.getElementById('cont');
        div.appendChild(MatForm);    // ADD THE TABLE TO YOUR WEB PAGE.

        var empTab = document.getElementById('dataTablemat');

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
        tr = empTab.insertRow(rowCnt);

        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                 // ADD A BUTTON.
                var button = document.createElement('button');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-danger');
                if(c==0)
                {
                    button.setAttribute('disabled', 'true');

                }
                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);

                var i = document.createElement('i');
                  i.setAttribute('class', 'fa fa-trash');
                  button.appendChild(i);
            }
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
               if(c==1)
                {
                        var ele = document.createElement('select');
                        ele.setAttribute('name','material[]');
                        ele.setAttribute('class','custom-select');
                        ele.setAttribute('style','width:100%;');
                }else
                {
                    var ele = document.createElement('input');
                        ele.setAttribute('name','quantity[]');
                        ele.setAttribute('max','100');
                        ele.setAttribute('min','1');
                        ele.setAttribute('class', 'form-control');
                        ele.setAttribute('type', 'number');
                }

                ele.setAttribute('required', '');




    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('totalmaterials').value = value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }

            // ele.setAttribute('value', '');
            // ele.setAttribute('name',value);
            ele.setAttribute('id',value);
            td.appendChild(ele);


            if(c==1)
                {
                    var option = document.getElementById(value);

                    var optionse = document.createElement('option');
                    optionse.setAttribute('value','');
                    optionse.setAttribute('selected','selected');
                    optionse.text = "Choose Material...";
                    option.appendChild(optionse);

                    var option1 = document.getElementById(value);
                    @foreach($materials as $materialsg)
                    var options = document.createElement('option');
                    options.setAttribute('value','{{$materialsg->id}}');
                    options.text = "{{ucwords(strtolower($materialsg->description))}}, [ {{ ' Description : '.ucwords(strtolower($materialsg->brand))}}, {{ ' Type : '.ucwords(strtolower($materialsg->type))}} ]";

                    option1.appendChild(options);
                    @endforeach
                    $(".custom-select").select2({
                        placeholder: "Choose material..",
                        allowClear: true
                    });
                }


            }
        }


    }

    // ADD A NEW ROW TO THE TABLE.s
    function addRow() {
        var empTab = document.getElementById('dataTablemat');

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
        tr = empTab.insertRow(rowCnt);

        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                // ADD A BUTTON.
                var button = document.createElement('button');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-danger');

                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);

                var i = document.createElement('i');
                  i.setAttribute('class', 'fa fa-trash');
                  button.appendChild(i);
            }
   else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
               if(c==1)
                {
                        var ele = document.createElement('select');
                        ele.setAttribute('name','material[]');
                        ele.setAttribute('class','custom-select');
                        ele.setAttribute('style','width:100%;');
                }else
                {
                    var ele = document.createElement('input');
                        ele.setAttribute('name','quantity[]');
                        ele.setAttribute('max','100');
                        ele.setAttribute('min','1');
                        ele.setAttribute('class', 'form-control');
                        ele.setAttribute('type', 'number');
                }

                ele.setAttribute('required', '');




    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('totalmaterials').value = value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }

            // ele.setAttribute('value', '');
            // ele.setAttribute('name',value);
            ele.setAttribute('id',value);
            td.appendChild(ele);


            if(c==1)
                {
                    var option = document.getElementById(value);

                    var optionse = document.createElement('option');
                    optionse.setAttribute('value','');
                    optionse.setAttribute('selected','selected');
                    optionse.text = "Choose Material...";
                    option.appendChild(optionse);

                    var option1 = document.getElementById(value);

                    @foreach($materials as $materialsf)
                    var options = document.createElement('option');
                    options.setAttribute('value','{{$materialsf->id}}');
                    options.text = "{{ucwords(strtolower($materialsf->description))}}, [ {{ ' Description : '.ucwords(strtolower($materialsf->brand))}}, {{ ' Type : '.ucwords(strtolower($materialsf->type))}} ]";
                    option1.appendChild(options);
                    @endforeach

                    $(".custom-select").select2({
                        placeholder: "Choose material..",
                        allowClear: true
                    });
                }
            }
        }


    }

    // DELETE TABLE ROW.
    function removeRow(oButton) {
        var empTab = document.getElementById('dataTablemat');
    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    --value; --value; --value; --value; --value; --value;
    document.getElementById('totalmaterials').value = value;
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);

var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }
              // BUTTON -> TD -> TR.
    }

    // EXTRACT AND SUBMIT TABLE DATA.
    function submit() {
        var myTab = document.getElementById('dataTablemat');
        var values = new Array();

        // LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length - 1; row++) {
            for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'text') {
                    values.push("'" + element.childNodes[0].value + "'");
                }
            }
        }

        // SHOW THE RESULT IN THE CONSOLE WINDOW.
        console.log(values);
    }



</script>

                @else
               <div align="center" style="color: red;"></div>
                @endif

                 @endif
                 </div>

</div>

                {{-- end material_request  --}}



     {{-- crosscheck material--}}
                <div class="container">
                 <div >
                        <?php


                        $wo_materials= WorkOrderMaterial::where('work_order_id',$wo->id)->where('status',20)->get();

                        ?>

                         @if(COUNT($wo_materials)!=0)

      <br>


<!--Requesting material again after crosschecking
        <div id="cont">

    </div>
    <input id="totalmaterials" type="text" name="totalinputs" value="" hidden>
    <p>
        <div class="row">
            <div class="col">
                <a id="addRow" onclick="addRow()" class="btn btn-outline-info"><i class="fa fa-plus"></i> Add New Row</a>
            </div>
        </div><br>
        <div class="row">

      <div class="col">
        <button id="bt" type="submit" class="btn btn-primary" disabled>Save</button>&nbsp;<a href="#" onclick="closeTab()"></a>
      </div>
    </div>
    </p>

Requesting material again after crosschecking-->


        <br>

                <div class="row">
        <br>
                                <p>CROSSCHECK MATERIAL(S) BEFORE REQUESTING TO STORE</p>

                 </div>


                        <table class="table table-striped" style="width:100%">
  <tr>
    <thead style="color: white;">
    <th>No</th>
    <th>Material Name</th>
    <th>Description</th>
    <th>Type</th>
    <th>Quantity Requested</th>
    <th>Action</th>
    </thead>
  </tr>

  <?php $i=1;


  ?>
    @foreach($wo_materials as $matform)

  <tr>
    <td>{{$i++}}</td>
    <td>{{$matform['material']->name }}</td>
    <td>{{$matform['material']->description }}</td>
    <td>{{$matform['material']->type }}</td>
    <td>{{$matform->quantity }}</td>

      <td>


                            <div class="row">
                                  &nbsp;&nbsp;&nbsp;&nbsp;

                                    <a style="color: green;"
                                       onclick="myfunc1( '{{ $matform->id }}','{{ $matform->quantity }}', '{{$matform->name}}')"
                                       data-toggle="modal" data-target="#exampleModali" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Material from the list? ')"
                                          action="{{ route('material.delete', [$matform->id , $matform->work_order_id ]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                                </div>

                         </td>
  </tr>
    @endforeach
</table>


    <button class="btn btn-primary" > <a  style="color: white" href="/send/material_again/{{$wo->id}}"   > Request Material(s) </a></button>



</div>

</div>

<!--modal for edit --->
     <div class="modal fade" id="exampleModali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div >
         <div class="modal-dialog" style="padding-right: 655px; background-color: white" role="document">
         <div class="modal-content">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-left:600px; ">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="modal-header ">
                     <div>
                        <h5  style="width: 600px;" id="exampleModalLabel">Edit Material</h5>
                        <hr>
                    </div>
                  </div>
                <div class="modal-body">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />




                      <form method="POST" action="edit/Material_hos/{{ $matform->work_order_id }}" class="col-md-6">
                        @csrf



                        <div class="form-group">
                            <select  required class="custom-select"  id="materialedit" name="material" style="width: 550px">
                                <option   selected value="" >Choose...</option>
                                @foreach($materials as $material)
                                   <option value="{{ $material->id }}">{{ $material->name.', Brand:('.$material->description.') ,Value:( '.$material->brand.' ) ,Type:( '.$material->type.' )' }}</option>
                                @endforeach
                            </select>
                        </div>


                         <div class="form-group">
                            <label for="name_of_house">Quantity </label>
                            <input style="color: black;width:550px" type="number" required class="form-control"      id="editmaterial"
                                   name="quantity" placeholder="Enter quantity again">
                            <input id="edit_mat" name="edit_mat" hidden>
                         </div>
                                                    <div>
                                                       <button style=" color: white; width: 205px;" type="submit" class="btn btn-primary">Save
                                                       </button>
                                                    </div>

                                            </form>

                                                       <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


     <script type="text/javascript">

      $("#materialedit").select2({
            placeholder: "Choose materia..",
            allowClear: true
        });
     </script>


                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>
     @endif

    <!--end modal for edit --->



                {{-- end material_request  --}}




                {{-- Purchasing order tab --}}

                <div id="purchasingorder" class="tabcontent">
                <form method="POST"  action="{{ route('work.purchasingorder', [$wo->id]) }}" >
                    @csrf
                    <h4>Purchasing Order Request</h4>
                   <div class="form-group">

                            <select onchange="stock();" required class="custom-select"  id="materialreq" name="1">
                                <option   selected value="" >Choose...</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name.' '.$material->description }}</option>
                                @endforeach
                            </select>
                        </div>


                         <p>Quantity</p>
                        <div class="form-group">
                            <input type="number" min="1"  style="color: black" name="2" required class="form-control"  rows="5" id="2"></input>
                        </div>


                        <div id="newmaterialproc" >


                        </div>
                    <input type="hidden" id="totalmaterials" value="2"  name="totalmaterials" ></input>

                        <button style=" color: white" type="submit" class="btn btn-primary">Save Material</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>

                </form>
                    <button style="background-color: blue; color: white" onclick="newmaterialproc()" class="btn btn-primary">New Material</button>


                </div>

                {{-- transportation tab --}}
                <div id="payment" class="tabcontent">
                    <h4>Transportation Form</h4>
                    <p>To be populated.</p>

                </div>
            </div>
        </div>
    <br>

    {{-- TECHNICIAN DETAILS FORM  --}}


@endif
</div>



<!--wo after rejected by Inspector of work-->



 {{-- Require Material question  --}}


                @if(($wo->status == 53) and ($wo->iowreject == 0))
              <h5><b>This works order has been rejected by {{ $wo['iowrejected']->type }} {{$wo['iowrejected']->fname.' '.$wo['iowrejected']->lname}} on {{ date('d F Y', strtotime($wo->iowdate)) }} Please restart processing works order again.</b></h5>
              <hr>

              <!--  <div>  <h5 style="color: blue"><b> Does this works order need material(s)? </b></h5></div>

                <div>
                     <label><input type="radio" name="colorRadio" value="Yes"> Yes</label> &nbsp;
                     <label><input type="radio" name="colorRadio" value="No"> No</label>
                </div>-->


           <!--No-->
<!--<div class="No box">-->

   <!--addtech-->
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


  <div>
           
             <div class="row">
                            <div class="col-md-6">
                                <p>ASSIGN TECHNICIAN(S) WORK</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('work.assigntechnician.afterreject', [$wo->id]) }}">
                        @csrf
                          <div class="form-group">
                          <!-- <input  id="technician_work"  type="text" hidden> </input>  -->

              <TABLE id="dataTable1" width="350px" >
                  <TR>
                       <TD><INPUT type="checkbox" name="chk[]"/></TD>

                       <TD>
                            <select  required  name="technician_work[]" style="background-color:white; width: 700px;

                              border: 1px solid var(--select-border);
                              border-radius: 0.25em;
                              padding: 0.25em 0.5em;
                              font-size: 1.25rem;
                              cursor: pointer;
                              line-height: 1.1;
                              ">
                              <option selected value="">Choose technician ...</option>
                               <?php
                $p=-1;
      ?>

                                @foreach($techs as $tech)
                                <?php

                                   $wo_technician_count = WorkOrderStaff::
                                   select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                                   ->where('status',0)
                                   ->where('staff_id',$tech->id)
                                   ->groupBy('staff_id')
                                   ->first();

                               ?>
                               @if(empty($wo_technician_count->total_wo))
                                   <?php $t=0;?>

                               @else
                                    <?php $t=$wo_technician_count->total_wo;?>

                                @endif

                              <?php
                             $p++;
                              $name[$p]=$tech->fname.' '.$tech->lname;
                              $ident[$p]=$tech->id;
                              $cwo[$p]=$t;

                              ?>



                                @endforeach
                                <?php
                                for($i=0;$i<=$p-1;$i++){
                                    for($j=$i+1 ;$j<=$p;$j++){
                                        if($cwo[$i]>$cwo[$j]){
                                            $t1=$name[$i];
                                            $t2=$ident[$i];
                                            $t3=$cwo[$i];

                                            $name[$i]=$name[$j];
                                            $ident[$i]=$ident[$j];
                                            $cwo[$i]=$cwo[$j];


                                            $name[$j]=$t1;
                                            $ident[$j]=$t2;
                                            $cwo[$j]=$t3;
                                }}}

                                    for($x=0;$x<=$p;$x++){
                                    ?><option  value="{{ $ident[$x] }}"> {{$name[$x].'        - assigned ('.$cwo[$x].') Works Orders'}} </option>
                                    <?php }  ?>


                            </select>
                              </TD>


                  </TR>
        </TABLE>

                        </div>

                        <INPUT class="btn btn-outline-primary" type="button" value="Add Row" onclick="addRow1('dataTable1')" />

                        <INPUT class="btn btn-outline-danger" type="button" value="Delete Row" onclick="deleteRow1('dataTable1')" />
                        <br><br>

                        <button  type="submit" class="btn btn-primary bg-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </form>
</div>

<!--addtech-->


           <!--EndNo-->



                @endif
{{-- Require Material  --}}



{{-- need transport  --}}

  @if($wo->iowreject == 4)


   <?php
   $techafterreje = techwork::where('wo_id',$wo->id)->where('leader2', 3)->first();
   ?>
                                      <div class="col-md-6">
                                <p><b>TECHNICIAN REPORT AFTER WORK</b></p>
                            </div>


            <form method="POST" action="{{ route('work.inspection.afterioreject', [$wo->id]) }}">
                    @csrf
                         <div class="form-group">

                          <select hidden class="custom-select" required name="status" style="color: black; width:  700px;">

                                <option selected value="1">Report after work</option>

                         </select>

                          </div>

                        <p>Description <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="200" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        </br>
                        <p>Inspection date  <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Technician leader</label>
                            <br>
                                     <input hidden class="form-control" required value="{{ $techafterreje->staff_id }}"  name="technician" >

                                       <input disabled class="form-control"  style="color: black; width:  700px;" value="{{ $techafterreje['technician_work']->lname.' '.$techafterreje['technician_work']->fname }}">


                        </div>



                        <button style=" color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>
  @else

  @if($wo->iowreject == 2 )


          <div>  <h5 style="color: blue"><b> Does this works order need transport for work? </b></h5></div>

                <div>
                     <label><input type="radio" name="colorRadio" value="yestrans"> Yes</label> &nbsp;
                     <label><input type="radio" name="colorRadio" value="notrans"> No</label>
                </div>

   <div class="yestrans box">
                <form method="POST" action="{{ route('work.transportiowreje', [$wo->id]) }}">
                    @csrf

                  <br>
                        <div class="row">
                            <div class="col-md-6">
                                <p>WORK TRANSPORT REQUEST FORM</p>
                            </div>
                        </div>
                  </br>

                         <input  value="1" name="inspection" hidden></input>
                         <input  value="101" name="status" hidden></input>

                        <p>Transport date <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;" name="date" required class="form-control" min="<?php echo date('Y-m-d'); ?>"  rows="5" id="date">
                        </div>

                          <p>Transport time <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="time" style="color: black; width:  700px;" name="time" required class="form-control"  id="time">
                        </div>

                         <p>Transport details <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <textarea  style="color: black;width: 700px;" name="coments" required maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>
                        <br>


                        <button style="color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>
</div>

  <div class="notrans box">



   <?php
   $techafterreje = techwork::where('wo_id',$wo->id)->where('leader2', 3)->first();
   ?>
      <div class="row">
                            <div class="col-md-6">
                                <p><b>TECHNICIAN REPORT AFTER WORK</b></p>
                            </div>
                        </div>

            <form method="POST" action="{{ route('work.inspection.afterioreject', [$wo->id]) }}">
                    @csrf
                         <div class="form-group">

                          <select hidden class="custom-select" required name="status" style="color: black; width:  700px;">

                                <option selected value="1">Report after work</option>

                         </select>

                          </div>

                        <p>Description <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="200" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        </br>
                        <p>Inspection date  <sup style="color: red;">*</sup></p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Technician leader</label>
                            <br>
                                     <input hidden class="form-control" required value="{{ $techafterreje->staff_id }}"  name="technician" >

                                       <input disabled class="form-control"  style="color: black; width:  700px;" value="{{ $techafterreje['technician_work']->lname.' '.$techafterreje['technician_work']->fname }}">


                        </div>



                        <button style=" color: white" type="submit" class="btn btn-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>
</div>

  @endif
  @endif

{{-- Need transport  --}}


<!--wo after rejected by inspector of work-->

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





  @endSection

     <?php
                        $mat= Material::get();
                        $matvalue= Material::get();
                        ?>
     <script type="text/javascript" language="javascript">
    var array = new Array();
     var arrayvalue = new Array();
    <?php foreach($mat as $key){ ?>
        array.push('<?php echo $key->name.', Brand:('.$key->description.') ,Value:( '.$key->brand.' ) ,Type:( '.$key->type.' )' ; ?>');
    <?php } ?>


    <?php foreach($mat as $key ){ ?>
        arrayvalue.push('<?php echo $key->id ; ?>');
    <?php } ?>
</script>

    <script>
    async function getTechnician(){
        var detail;
        var techid;
        var id = document.getElementById("techid").value;
    var response = await fetch('/gettechniciandetails/'+id).then(function(response){
        return response.json();
        })
    .then(data => {
        total=data["workorderstaff"].length;
        detail='Full name : '+data["technician"].lname+data["technician"].fname+'  Type is : '+data["technician"].type+'  \r    Phone : '+data["technician"].phone+'  Email is : '+data["technician"].email ;
        techid=data["technician"].id;
        //h=data[0].work_order_id;
        //console.log(data[0].work_order_id);

    });


        document.getElementById("detail").innerHTML=detail;
        document.getElementById("totalwork").innerHTML=total;
        document.getElementById("technician_work").value=techid;

      }




    // getTechnician(5);



       function myfunc1(U, V, W) {


            document.getElementById("edit_mat").value = U;

            document.getElementById("editmaterial").value = V;

             document.getElementById("material").value = W;

       }
    </script>


    <script type="text/javascript">

      $("#newmaterial").select2({
            placeholder: "Choose Technician...",
            allowClear: true
        });
    </script>

    <script type="text/javascript">

   function myfunc5(x) {
            document.getElementById("comments").innerHTML = x;
        }

         function myfunc6(x) {
            document.getElementById("details").innerHTML = x;
  }
   </script>


 <script type="text/javascript">

        $("#divmanual").hide();
        $("input:checkbox").on('click', function () {
            // in the handler, 'this' refers to the box clicked on
            var $box = $(this);
            if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the group/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>







<SCRIPT language="javascript">
        function addRow(tableID) {

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;



            for(var i=0; i<colCount; i++)
             {

                var newcell = row.insertCell(i);





                newcell.innerHTML = table.rows[0].cells[i].innerHTML;

                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;


                }



            }


        }

        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>


    <SCRIPT language="javascript">
        function addRow1(tableID) {

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;



            for(var i=0; i<colCount; i++)
             {

                var newcell = row.insertCell(i);





                newcell.innerHTML = table.rows[0].cells[i].innerHTML;

                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;


                }



            }


        }

        function deleteRow1(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>



        <SCRIPT language="javascript">
        function addRow22(tableID) {

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;



            for(var i=0; i<colCount; i++)
             {

                var newcell = row.insertCell(i);





                newcell.innerHTML = table.rows[0].cells[i].innerHTML;

                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;


                }



            }


        }

        function deleteRow22(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>




<SCRIPT language="javascript">
        function addmaterialrow(tableID) {

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;



            for(var i=0; i<colCount; i++)
             {


               if(rowCount = 1) {

                          document.getElementById('deleterowbutton').style.display='inline-block';



                    }


                var newcell = row.insertCell(i);

                newcell.innerHTML = table.rows[0].cells[i].innerHTML;

                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;


                }



            }


        }



        function deletematerialrow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }


                        if(rowCount <= 2) {


                        document.getElementById('deleterowbutton').style.display='none';
                    }

                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }

            }catch(e) {
                alert(e);
            }
        }




    </script>

