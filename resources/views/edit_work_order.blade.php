@extends('layouts.master')

@section('title')
    work order
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


 ?>




<style type="text/css">
.label{
    width: 700px;
}
</style>
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
        <label for="">Details:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
    <br>

     @if($wo->emergency == 1)
   <h6 align="center" style="color:red;"><b>This Works Order Is Emergency &#9888;</b></h6>
    @endif




    @if(empty($wo['work_order_staffassigned']->id))

    @else
     <h4><b>Assigned Technician(s) for Inspection </b></h4>
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
  <!--<th>Date Completed</th>-->
  <th>Leader</th>
     </thead>

  </tr>
    @foreach($techforms as $techform)
  <tr>

     @if($techform['technician_assigned_for_inspection'] != null)
    <td>{{$techform['technician_assigned_for_inspection']->lname.' '.$techform['technician_assigned_for_inspection']->fname}}</td>
   <td class="text-primary">@if($techform->status==1) Completed  @else  On Progress   @endif</td>
   <td>{{ date('d F Y', strtotime($techform->created_at)) }} </td>


<!--
   @if($techform->status==1)

  <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>
    @else
   

      <td style="color: red"> Not Completed Yet</td>
    @endif -->

    @if($techform->leader == null )

<td>   <a style="color: black;" href="{{ route('workOrder.technicianassignleaderinspection', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader"><i
                                                    class="fas fa-user-tie large"></i></a></td>
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

</div>
<div >
  <a href="{{ url('techforreport/'.$wo->id) }}" ><button class="btn btn-primary">
PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button></a>
</div>
</div>
@endif

<br>
   <hr>
    <br>

    @endif





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
    <th>Type</th>
    <th>Description</th>
  <th>Full Name</th>
    <th>Date</th>
  </thead>
  </tr>
    @foreach($iforms as $iform)


  <tr>
    <td class="text-primary" >{{ $iform->status }}</td>
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










    @if(empty($wo['work_order_staff']->id))

    @else
    
    <?php

  $idwo=$wo->id;
  $techforms = WorkOrderStaff::with('technician_assigned')->where('work_order_id',$idwo)->get();
?>
 @foreach($techforms as $status)
 @endforeach

@if($status->status5 == 22)

 <h4><b>Assigned Technician(s) for Work</b></h4>

<table style="width:100%">
  <tr>

<thead style="color: white;">
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
 <!-- <th>Date Completed</th>-->
  <th>Leader</th>
</thead>

  </tr>
    @foreach($techforms as $techform)

  <tr>

     @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>
   <td class="text-primary">@if($techform->status==1) Completed   @else  On Progress   @endif</td>


    <td>{{ date('d F Y', strtotime($techform->created_at)) }}</td>


 <!--  @if($techform->status==1)

  <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>
    @else
   

      <td style="color: red"> Not Completed Yet</td>
    @endif -->

@if($techform->leader == null )

<td>   <a style="color: black;" href="{{ route('workOrder.technicianassignleader', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader"><i
                                                    class="fas fa-user-tie large"></i></a></td>
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



<!--report after work-->

    @if(empty($wo['work_order_inspection']->status))

    @else

   
    <?php

  $idwo=$wo->id;
  $iforms = WorkOrderInspectionForm::where('work_order_id',$idwo)->where('status','Report after work')->get();
        ?>




 <h4><b>Inspection Report After Work </b></h4>

<table style="width:100%">
  <tr>
     <thead style="color: white;">
    <th>Type</th>
    <th>Description</th>
  <th>Full Name</th>
    <th>Date</th>
  </thead>
  </tr>
    @foreach($iforms as $iform)


  <tr>
    <td class="text-primary" >{{ $iform->status }}</td>
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




  @if(empty($wo['work_order_transport']->work_order_id))

    @else
    <h4><b>Transport Description </b></h4>
    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->get();
?>

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
     <td> <a onclick="myfunc5('{{$tform->coments}}')"><span data-toggle="modal" data-target="#viewMessage"
                                                                         class="badge badge-success">View Details</span></a></td>
    <td class="text-primary">@if($tform->status==0) Waiting  @elseif($tform->status==1) Approved @else REJECTED   @endif</td>



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





  @if(auth()->user()->type != 'CLIENT')

  @if(empty($wo['work_order_material']->id))

    @else
    <h4><b>Materials Requests </b></h4>
    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
    ?>

<table style="width:100%">
  <tr>
     <thead style="color: white;">

    <th>Name</th>

  <th>Type</th>
   <th>Quantity</th>
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
       <td>
       @if($matform->accepted_by == NULL)
      <span class="badge badge-warning">Not accepted Yet.</span>
       @else
       {{ $matform['acceptedby']->name }}
       @endif
       </td>
   <td class="text-primary">@if($matform->status==0)<span class="badge badge-success"> WAITING FOR MATERIAL APPROVAL </span> @elseif($matform->status== 1)<span class="badge badge-success">APPROVED BY IOW </span> @elseif($matform->status== 2) <span class="badge badge-primary">RELEASED FROM STORE </span> @elseif($matform->status==20) <span class="badge badge-success">PLEASE CROSSCHECK MATERIAL </span> @elseif($matform->status==17) <span class="badge badge-warning">SOME OF MATERIAL REJECTED </span> @elseif($matform->status== 5)<span class="badge badge-success">MATERIAL ON PROCUREMENT STAGE</span> @elseif($matform->status== 3)<span class="badge badge-primary">MATERIAL TAKEN FROM STORE</span>  @elseif($matform->status == -1)<span class="badge badge-danger">
    REJECTED BY IOW</span>@elseif($matform->status== 15)<span class="badge badge-success">MATERIAL PURCHASED</span>
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
     <h4><b>Material Requests: </b></h4>
    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
  ?>

<table style="width:100%">
  <tr>
     <thead style="color: white;">

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
   <td class="text-primary">@if($matform->status==0)<span class="badge badge-success"> WAITING FOR MATERIAL APPROVAL </span> @elseif($matform->status== 1)<span class="badge badge-success">APPROVED BY IOW </span> @elseif($matform->status== 2) <span class="badge badge-primary">RELEASED FROM STORE </span> @elseif($matform->status==20) <span class="badge badge-success">PLEASE CROSSCHECK MATERIAL </span> @elseif($matform->status==17) <span class="badge badge-warning">SOME OF MATERIAL REJECTED </span> @elseif($matform->status== 5)<span class="badge badge-success">MATERIAL ON PROCUREMENT STAGE</span> @elseif($matform->status== 3)<span class="badge badge-primary">MATERIAL TAKEN FROM STORE</span>  @elseif($matform->status == -1)<span class="badge badge-danger">
    REJECTED BY IOW</span>@elseif($matform->status== 15)<span class="badge badge-success">MATERIAL PURCHASED</span>
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




  @if(empty($wo['work_order_material']->id))

    @else
      <h4><b>Materials Used </b></h4>
    <?php

  $idw=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>

<table style="width:100%">
  <tr>
     <thead style="color: white;">

    <th>Name</th>
    <th> Description</th>
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



         <form method="POST" action="{{ route('workOrder.edit', [$wo->id]) }}">
            @csrf

            <div class="form-group ">

                @if($wo->emergency == 1)
                    <input type="checkbox" name="emergency" checked> <b style="color:red;">This works order is emergency</b>
                @else
                    <input type="checkbox" name="emergency"> <b style="color:red;">This works order is emergency</b>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
          </form>


        <div class="row">
            <div class="col">
                 <div class="checkbox">
            <label><input id="checkdiv" name="checkdiv" type="checkbox" value="yesmanual" onclick="ShowHideDiv(this)">
                Assign Zone Location</label>
               </div>
            </div>
        </div>


       <div id="divmanual">

     @if($wo->zonelocationtwo == null)

                 <form method="POST" action="{{ route('workOrder.edit.zoneloctwo', [$wo->id]) }}">
            @csrf
            <div class="row">
            <div class="container" >
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="height: 28px;" class="input-group-text" for="inputGroupSelect01">Zone Location</label>
                </div>
                <select style="width: 400px;" required class="custom-select" id="iowzone" name="location" >


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

     @if($wo->zonelocationtwo != null)

         <form method="POST" action="{{ route('workOrder.edit.zoneloc', [$wo->id]) }}">
            @csrf
            <div class="row">
            <div class="container" >
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="height: 28px;" class="input-group-text" for="inputGroupSelect01">Zone Location</label>
                </div>
                <select style="width: 400px;" required class="custom-select" id="iowzone" name="location" @if($wo->zone_location != null) disabled @endif>

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




       @if($wo->zone_location != null)

        <br>
        <h4>Works order forms</h4>
        {{-- tabs --}}
        <div class="payment-section-margin">
            <div class="tab">
                <div class="container-fluid">
                    <div class="tab-group row">
                       <button required class="tablinks col-md-3" onclick="openTab(event, 'assigntechnicianforinspection')"><b style="color:black">ASSIGN TECHNICIAN FOR INSPECTION</b></button>

                       <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'customer')">INSPECTION FORMS</button>

                        <button required class="tablinks col-md-3" onclick="openTab(event, 'assigntechnician')"><b style="color:black">ASSIGN TECHNICIAN FOR WORK</b></button>

                        <button  style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'request_transport')">REQUEST TRANSPORT
                        </button>
                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'material_request')" id="defaultOpen">MATERIAL REQUEST FORM</button>

                        <!--<button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'material_request_store')" id="defaultOpen">MATERIAL REQUEST FROM STORE</button>-->
                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'crosscheck_material_requested')" id="defaultOpen">CROSS CHECK MATERIAL REQUESTED</button>


                    </div>
                </div>
       @else
         <div align="center" style="color: red;"> Please assign zone location for further Steps. </div>
       @endif





            {{-- ASSIGN TECHNICIAN tab--}}


                    <div id="assigntechnician" class="tabcontent">


                 @if(($wo->statusmform == 3) || ($wo->statusmform == 4))


                        <div class="row">
                            <div class="col-md-6">
                                <p>Assign Technician(s) For This Works Order</p>
                            </div>
                        </div>
                      

 <!--techniciantable-->
 @if($wo->status == 5)

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



                        <form method="POST" action="{{ route('work.assigntechnician', [$wo->id]) }}">
                        @csrf
                          <div class="form-group">
                          <!-- <input  id="technician_work"  type="text" hidden> </input>  -->

              <TABLE id="dataTable1" width="350px" >
                  <TR>
                       <TD><INPUT type="checkbox" name="chk[]"/></TD>

                       <TD>
                            <select   id="techidc" required class="custom-select"  name="technician_work[]" style="width: 700px;">






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

                        <INPUT class="btn badge-primary" type="button" value="Add Row" onclick="addRow1('dataTable1')" />

                        <INPUT class="btn badge-danger" type="button" value="Delete Row" onclick="deleteRow1('dataTable1')" />
                        <br><br>

                        <button  type="submit" class="btn btn-primary bg-primary">Assign Technician</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </form>


                @else
               <div align="center" style="color: red;"> Please assign inspection form before work before assigning technician for work. </div>
                @endif
                    </div>

                {{-- end ASSIGN TECHNICIAN  --}}






                       {{-- ASSIGN TECHNICIAN tab--}}

                    @csrf
                    <div id="assigntechnicianforinspection" class="tabcontent">

                       @if($wo->statusmform == 1)

                        <div class="row">
                            <div class="col-md-6">
                                <p>Assign technician for inspection before work</p>
                            </div>
                        </div>
                        <div >
                        <p id="alltechdetails">  </p>
                        </div>



                        <form method="POST" action="{{ route('work.assigntechnicianforinspection', [$wo->id]) }}">
                        @csrf
                          <div class="form-group">

          <TABLE id="dataTable" width="350px" >
                  <TR>
                       <TD><INPUT type="checkbox" name="chk[]"/></TD>

                       <TD>

                            <select   id="techidfoxrinspection" required class="custom-select"  name="technician_work[]" style="width: 700px;">


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

                        <INPUT class="btn badge-primary" type="button" value="Add Row" onclick="addRow('dataTable')" />

                        <INPUT class="btn badge-danger" type="button" value="Delete Row" onclick="deleteRow('dataTable')" />
                        <br><br>

                        <button  type="submit" class="btn btn-primary bg-primary">Assign Technician</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </form>
                              @else
               <div align="center" style="color: red;"> You have already assigned technician for inspection for this works order.</div>
                @endif

                    </div>

     

                {{-- end ASSIGN TECHNICIAN  --}}




                {{-- INSPECTION tab--}}
                <form method="POST" action="{{ route('work.inspection', [$wo->id]) }}">
                    @csrf
                    <div id="customer" class="tabcontent">
                      @if($wo->statusmform != 1)
                        <div class="row">
                            <div class="col-md-6">
                                <p>Works order status</p>
                            </div>
                        </div>


                         <div class="form-group">

                            <select class="custom-select" required name="status" style="color: black; width:  700px;">

                                   @if($wo->status == 70)
                                    <option selected value="Inspection report before work">Inspection report before work</option> @else
                                       <option selected value="Report after work">Report after work</option>@endif

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
                            <label>Select technician leader</label>
                            <br>
                            <select style="color: black; width:  700px;" required class="custom-select"  name="technician" >
                              
                                @if($wo->status == 70)

                                <?php

                                $tech = techasigned::where('work_order_id',$wo->id)->where('leader2', 3)->first();
                                ?>
                                   @if(empty($tech))
                                   @else
          
                                    <option selected value="{{ $tech->staff_id }}">{{ $tech['technician_assigned_for_inspection']->lname.' '.$tech['technician_assigned_for_inspection']->fname }}
                                    </option>

                                    @endif
                          

                                @else

                                <?php

                                $tech = WorkOrderStaff::where('work_order_id',$wo->id)->where('leader2', 3)->first();
                                ?>

                                 @if(empty($tech))
                                   @else
                                    <option  value="{{ $tech->staff_id }}">{{ $tech['technician_assigned']->lname.' '.$tech['technician_assigned']->fname }}
                                    </option>
                                   @endif 
                            
                                @endif
                            </select>
                        </div>



                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>
               @else
               <div align="center" style="color: red;"> Please assign technician for inspection before filling inspection form. </div>
                @endif
                 </div>
                {{-- end inspection --}}



                 {{-- request_transport form--}}
                <form method="POST" action="{{ route('work.transport', [$wo->id]) }}">
                    @csrf
                    <div id="request_transport" class="tabcontent">
                  @if($wo->statusmform != 1)
                        <div class="row">
                            <div class="col-md-6">
                                <p>Works Order Transport Request Form</p>
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

                         <p>Transport details</p>
                        <div class="form-group">
                            <textarea  style="color: black;width: 700px;" name="coments" required maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>
                        <br>


                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>
                    </div>
                </form>

                @else
               <div align="center" style="color: red;"> Please assign technician for inspection before requesting transport. </div>
                @endif

                </div>
                {{-- end request_transport form --}}




                {{-- material_request tab--}}

                 <div id="material_request" class="tabcontent">
                <form method="POST"  action="{{ route('work.materialadd', [$wo->id]) }}" >
                    @csrf



                        <?php

                        use App\Material;
                        $materials= Material::orderby('name', 'ASC')->get();


                        ?>
                         @if($wo->statusmform == 4)

                        <div class="row">
                            <div class="col-md-6">
                                <p>Select material for this works order</p>
                            </div>
                        </div>



                          <div class="form-group">



          <TABLE id="dataTablemat" align="center" >


                  <TR>
                       <TD><INPUT type="checkbox" name="chk[]"/></TD>
                        <input type="text" name="zone" value="{{ $zoned->id }}" hidden>

                       <TD>


                            <select  required class="custom-select"  name="material[]" >
                                <option   selected value="" >Choose material...</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name.', Description:('.$material->description.') ,Value:( '.$material->brand.' ) ,Type:( '.$material->type.' )' }}</option>
                                @endforeach
                            </select>

                       </TD>

                       <TD>

                          <input placeholder="Enter quantity" type="number" max="100" style="color: black; " name="quantity[]" required class="form-control" >

                       </TD>


                  </TR>

        </TABLE>

                        </div>
                        <div align="right">

                        <INPUT class="btn btn-outline-primary" type="button" value="Add Row" onclick="addmaterialrow('dataTablemat')" />

                        <INPUT   id="deleterowbutton" style="display: none;" class="btn btn-outline-danger" type="button" value="Delete Row" onclick="deletematerialrow('dataTablemat')" />
                        <br><br> </div>

                        <button  type="submit" class="btn btn-primary bg-primary">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>

                    </form>



                @else
               <div align="center" style="color: red;"> Please assign technician for inspection before requesting material for work. </div>
                @endif
                 </div>
                {{-- end material_request  --}}









     {{-- crosscheck material--}}
                <div class="container">
                 <div id="crosscheck_material_requested" class="tabcontent">
                        <?php


                        $wo_materials= WorkOrderMaterial::where('work_order_id',$wo->id)->where('status',20)->get();

                        ?>

                         @if(COUNT($wo_materials)!=0)

        <br>
                        <table class="table table-striped" style="width:100%">
  <tr>
    <th>No</th>
    <th>Material Name</th>
    <th>Description</th>
    <th>Type</th>
    <th>Quantity Requested</th>
    <th>Action</th>

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


    <button class="btn btn-success" > <a  style="color: white" href="/send/material_again/{{$wo->id}}"   > REQUEST MATERIAL </a></button>



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
                                                       <button style="background-color: darkgreen; color: white; width: 205px;" type="submit" class="btn btn-success">Save
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

                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save Material</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #bb321f; color: white" class="btn btn-danger">Cancel</button></a>

                </form>
                    <button style="background-color: blue; color: white" onclick="newmaterialproc()" class="btn btn-success">New Material</button>


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




    </SCRIPT>









