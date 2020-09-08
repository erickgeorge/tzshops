  <title><?php echo $header; ?> </title>
<?php use App\WorkOrderInspectionForm;
    use App\WorkOrderTransport;
    use App\WorkOrderStaff;
    use App\WorkOrderMaterial;


 ?>

 <style>
    body { background-image:  url('/images/estatfegrn.jpg');

    /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

    }

   .box{
    width:710px;
    height: 130px;
     border: 2px solid #b0aca0;
   }




   .container-name div {
  display: inline-block;
  width: 400px;
  min-height: 50px;

  height: auto;
  }



table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #000;
  text-align: left;
  padding: 8px;
}

#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>
 <div class="container">

    <div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h5>Directorate of Estates Services</h5></p><p><b style="text-transform: uppercase;"><?php
     echo $header;
     ?></b></p>
</div><br>







<?php
    use App\techasigned;


 ?>
 <div class="container">

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th colspan="4">Works Order Summary</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">Submitted By : <b style="text-transform: capitalize;">{{ $wo['user']->fname.' '.$wo['user']->lname }}</b></td>
            <td>On : <b>{{ date('d F Y', strtotime($wo->created_at)) }}</b> </td>
            <td>Problem Type: <b style="text-transform: capitalize;">{{ ucwords(strtolower($wo->problem_type)) }}</b> </td>
        </tr>
        <tr>
            <td>Location : <b>@if(empty($wo->room_id)) {{ $wo->location }}
                @else
                   {{ $wo['room']['block']->location_of_block }}
                @endif</b> </td>
            <td>Area : <b>@if(empty($wo->room_id))
                {{ $wo->room_id }}

                          @else
                   {{ $wo['room']['block']['area']->name_of_area }}
                          @endif</b></td>
            <td>Block : <b>@if(empty($wo->room_id)) {{ $wo->location }}
                @else
                   {{ $wo['room']['block']->location_of_block }}
                @endif</b> </td>
            <td>Room : <b>@if(empty($wo->room_id))
                {{ $wo->location }}
              @else
                  {{ $wo['room']->name_of_room }}
              @endif</b></td>
        </tr>
        <tr>
            <td colspan="4">Description : <b style="text-transform: capitalize;">{{ $wo->details }}</b> </td>
        </tr>
        <tr>
            <td colspan="2" style="text-transform: capitalize;"> @if($wo->status == 0)rejected@elseif($wo->status == 1) accepted @else processed @endif by : <b style="text-transform: capitalize;">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</b> </td>
            <td>Mobile Number : <b>{{ $wo['user']->phone }}</b></td>
            <td>Email : <b>{{ $wo['user']->email }}</b></td>
        </tr>
    </tbody>
</table>


   </div>







@if($wo->emergency == 1)
   <table>
       <tr>
           <td colspan="4">   <h6 align="center" style="color: red;"><b> This Works Order Is Emergency</b></h6>
           </td>
       </tr>
   </table>
@endif



    <h4><b>Assigned Technician for Inspection</b></h4>
    @if(empty($wo['work_order_staffassigned']->id))
       <p class="text-primary">No Technician assigned yet</p>
    @else


    <?php

  $idwo=$wo->id;
  $techforms = techasigned::with('technician_assigned_for_inspection')->where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
   <thead style=" background-color: #376ad3; color: white; ">
  <tr>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
  <th>Date Completed Inspection</th>

  </tr>
  <thead>
    <tbody>
    @foreach($techforms as $techform)
  <tr>

     @if($techform['technician_assigned_for_inspection'] != null)
    <td style="text-transform: capitalize;">{{$techform['technician_assigned_for_inspection']->lname.' '.$techform['technician_assigned_for_inspection']->fname}}</td>
   <td class="text-primary">@if($techform->status==1) Completed   @else  On Progress  @endif</td>

 <td>{{ date('d F Y', strtotime($techform->created_at)) }} </td>

    @if($techform->created_at ==  $techform->updated_at)


    <td> Not completed yet!</td>
    @else
   <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>

    @endif

   <!-- @if($techform->status!=1)
   <td>   <a style="color: black;" href="{{ route('workOrder.technicianCompleteinspection', [$techform->id]) }}" data-toggle="tooltip" title="COMPLETE INSPECTION"><i
                                                    class="fas fa-clipboard-check large"></i></a></td>

    </td>
   @endif-->







      @endif



  </tr>
  </tbody>
    @endforeach
  </table>


    @endif






  <h4><b>Assigned Technician for Work </b></h4>
@if(empty($wo['work_order_staff']->id))
        <p class="text-primary">No Technician assigned yet</p>
    @else
    <?php

  $idwo=$wo->id;
  $techforms = WorkOrderStaff::with('technician_assigned')->where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
    <thead style=" background-color: #376ad3; color: white; ">
  <tr>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
  <th>Date Completed work</th>
  <th>Leader</th>

  </tr>
</thead>
    @foreach($techforms as $techform)



<tbody>
  <tr>

   @if($techform['technician_assigned'] != null)
    <td style="text-transform: capitalize;">{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>
   <td class="text-primary">@if($techform->status==1) Completed   @else  On Progress  @endif</td>



   <td>{{ date('d F Y', strtotime($techform->created_at)) }}</td>
    @if($techform->created_at ==  $techform->updated_at)


    <td> NOT COMPLETED</td>
    @else
     <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>
    @endif

    @if($techform->leader == null )

<td>   <a style="color: black;" href="{{ route('workOrder.technicianassignleader', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader"><i
                                                    class="fas fa-user-tie large"></i></a></td>
                                                   @elseif($techform->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Leader<i
                                                    class="fas fa-user-tie large"></i></td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >Normal technician</i></td>
                                                    @endif


  <!--  @if(auth()->user()->type != 'CLIENT')
   @if($techform->status!=1)
   <td>   <a style="color: black;" href="{{ route('workOrder.technicianComplete', [$techform->id]) }}" data-toggle="tooltip" title="COMPLETE WORK"><i
                                                    class="fas fa-clipboard-check large"></i></a></td>

    </td>
   @endif
    @endif-->






          @else
          <td class="text-primary">No technician assigned yet</td>
      @endif



  </tr>
</tbody>
    @endforeach
  </table>
    @endif

    <h4><b>Technician Report</b></h4>
    @if(empty($wo['work_order_inspection']->status))
        <p class="text-primary">Not inspected yet</p>
    @else
    <?php

  $idwo=$wo->id;
  $iforms = WorkOrderInspectionForm::where('work_order_id',$idwo)->get();
        ?>

<table style="width:100%">
   <thead style=" background-color: #376ad3; color: white; ">
  <tr>
    <th>Status</th>
    <th  >Description</th>
  <th>Full Name</th>
    <th>Date </th>
  </tr>
</thead>
<tbody>
    @foreach($iforms as $iform)


  <tr>
    <td class="text-primary" >{{ $iform->status }}</td>
      <td><?php $erick = $iform->description; echo wordwrap($erick, 20, "<br />\n"); ?></td>
      <td style="text-transform: capitalize;">{{$iform['technician']->lname.' '.$iform['technician']->fname }}</td>
 <td>{{ date('d F Y', strtotime($iform->date_inspected )) }}</td>
  </tr>

  @endforeach
</tbody>
  </table>
    @endif
    <h4><b>Transport Description </b></h4>
  @if(empty($wo['work_order_transport']->work_order_id))
        <p class="text-primary">No Transport requested</p>
    @else
    <?php

  $idwo=$wo->id;
  $tforms = WorkOrderTransport::where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
   <thead style=" background-color: #376ad3; color: white; ">

  <tr>
    <th>Date</th>
    <th>Time</th>
    <th>Details</th>
  <th>Status</th>
  <th>Message</th>

    <th>Date Requested</th>
  </tr>
</thead>
    <tbody>
    @foreach($tforms as $tform)



  <tr>
    <td>{{ date('F d Y', strtotime($tform->time))  }}</td>
    <td>{{ date('h:i:s A', strtotime($tform->time)) }}</td>
     <td> <a onclick="myfunc('{{$tform->coments}}')"><span data-toggle="modal" data-target="#viewMessage"
                                                                         class="badge badge-success">View Details</span></a></td>
    <td class="text-primary">@if($tform->status==0) Waiting   @elseif($tform->status==1) Approved @else Rejected   @endif</td>



     <td> <a onclick="myfunc2('{{$tform->details}}')"><span data-toggle="modal" data-target="#viewdetails"
                                                                         class="badge badge-success">View Message</span></a></td>



  <td>{{ date('d F Y', strtotime($tform->created_at )) }}</td>

</tr>
  @endforeach

</tbody>
  </table>
    @endif




  @if(auth()->user()->type != 'CLIENT')
    <h4><b>Materials Requests </b></h4>
  @if(empty($wo['work_order_material']->id))
        <p class="text-primary">No Material have been requested yet</p>
    @else
    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
?>

<table style="width:100%">
    <thead style=" background-color: #376ad3; color: white; ">
  <tr>

    <th>Materials Name</th>

  <th>Type</th>
   <th>Quantity</th>
   <th>IoW</th>
   <th>Approved By</th>
    <th>Status</th>
     <th>Date Requested</th>
      <th>Date Updated</th>

  </tr>
</thead>
<tbody>
    @foreach($matforms as $matform)
  <tr>

    <td style="text-transform: capitalize;">{{$matform['material']->name }}</td>

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
   <td class="text-primary">@if($matform->status==0)<span class="badge badge-success"> Waiting for material approval </span> @elseif($matform->status== 1)<span class="badge badge-success">Approved by IoW </span> @elseif($matform->status== 2) <span class="badge badge-primary">Released from store</span> @elseif($matform->status==20) <span class="badge badge-success">Please crosscheck material </span> @elseif($matform->status==17) <span class="badge badge-warning">Some of material rejected </span> @elseif($matform->status== 5)<span class="badge badge-success">Material on procurement stage</span> @elseif($matform->status== 3)<span class="badge badge-primary">Material taken from store</span>  @elseif($matform->status == -1)<span class="badge badge-danger">
    Rejected by IoW</span>@elseif($matform->status== 15)<span class="badge badge-success">Material purchased</span>
       @endif</td>

 <td> {{ date('d F Y', strtotime($matform->created_at))  }}</td>

    <td>{{ date('d F Y', strtotime($matform->updated_at))  }} </td>



  </tr>

  @endforeach
</tbody>

  </table>
    @endif
   @elseif(auth()->user()->type == 'CLIENT')
      <h4><b>Materials Requests </b></h4>
  @if(empty($wo['work_order_material']->id))
        <p class="text-primary">No Material have been requested yet</p>
    @else
    <?php

  $idwo=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idwo)->get();
  ?>

<table style="width:100%">
    <thead style=" background-color: #376ad3; color: white; ">
  <tr>

    <th>Material Name</th>
    <th>Material Description</th>
    <th>Type</th>
    <th>Quantity</th>
    <th>Status</th>
    <th>Date Requested</th>
    <th>Date Updated</th>

  </tr>
</thead>
<tbody>
    @foreach($matforms as $matform)
  <tr>

    <td style="text-transform: capitalize;">{{$matform['material']->name }}</td>
   <td>{{$matform['material']->description }}</td>
    <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
   <td class="text-primary">@if($matform->status==0)<span class="badge badge-success"> Waiting for material approval </span> @elseif($matform->status== 1)<span class="badge badge-success">Approved by IoW  </span> @elseif($matform->status== 2) <span class="badge badge-primary">Released from store </span> @elseif($matform->status==20) <span class="badge badge-success">Material Requested </span> @elseif($matform->status==17) <span class="badge badge-warning">Material on check by IoW </span>  @elseif($matform->status== 3)<span class="badge badge-primary">Material taken from store</span>  @elseif($matform->status== 5)<span class="badge badge-success">Material on procurement stage</span> @elseif($matform->status == -1)<span class="badge badge-warning">Material on check by IoW</span>@elseif($matform->status== 15)<span class="badge badge-success">Material Purchased</span>
       @endif</td>

  <td> {{ date('d F Y', strtotime($matform->created_at))  }}</td>

    <td>{{ date('d F Y', strtotime($matform->updated_at))  }} </td>

  </tr>

  @endforeach
</tbody>

  </table>
    @endif

   @endif

     <h4><b>Materials Used </b></h4>

  @if(empty($wo['work_order_material']->id))
        <p class="text-primary">No Material Used for this Works order</p>
    @else
    <?php

  $idw=$wo->id;
  $matforms = WorkOrderMaterial::where('work_order_id',$idw)->where('status',3)->get();
?>

<table style="width:100%">
    <thead style=" background-color: #376ad3; color: white; ">
  <tr>

    <th>Material Name</th>
    <th>Material Description</th>
     <th>Type</th>
     <th>Quantity</th>
  </tr>
</thead>
<tbody>
    @foreach($matforms as $matform)
  <tr>
   <td style="text-transform: capitalize;">{{$matform['material']->name }}</td>
   <td>{{$matform['material']->description }}</td>
   <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
  </tr>

  @endforeach
</tbody>


  </table>
    @endif
    <div>

</div>
@if ($wo->systemclosed=='1')

<table class="table table-light">
    <tbody>
        <tr>
            <td style="text-transform: capitalize;">This Works Order Was Closed Automatically by a system due to a Customer delay of closing for 7 days</td>
        </tr>
    </tbody>
</table>
@endif
