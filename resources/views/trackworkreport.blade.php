<title><?php echo $header; ?></title>
<?php use App\WorkOrderInspectionForm;
    use App\WorkOrderTransport;
    use App\WorkOrderStaff;
    use App\WorkOrderMaterial;
 

 ?>
 <div class="container">

    <br>
    <div style="margin-top: 20px" align="center">
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <p><h2>University of Dar es salaam</h2> <h5>Directorate of Estates Services</h5></p><p><b style="text-transform: uppercase;"><?php
     echo $header; 
     ?></b></p>
</div><br>

  
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
        <div class="col"  align="center">
            <h5>This works order is submitted by  <span
                style="color: green">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span>&nbsp;&nbsp;|&nbsp;&nbsp;Contacts:{{ $wo['user']->phone }}, {{ $wo['user']->email }} </h5>
    
        </div>
        <div class="col" align="center">
          <h5>created on <span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span>
    &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; @if($wo->status == 0)Rejected@elseif($wo->status == 1) Accepted @else Processed @endif by <span
                style="color: green">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span></h5>
        </div>
    </div>
    
   
 
  <hr>
<table style="width:100%">
  <tr>
  <th>Problem type:</th>
  <th> Location:</th>
  <th>Area:</th>
  <th>Block:</th>
  <th>Room:</th>
</tr>
<tr>
  <td>{{ $wo->problem_type }}</td>
  <td> @if(empty($wo->room_id)) {{ $wo->location }}
        @else {{ $wo['room']['block']->location_of_block }}  @endif</td>
  <td>@if(empty($wo->room_id)) {{ $wo->room_id }} @else {{ $wo['room']['block']['area']->name_of_area }}
                @endif</td>
  <td> @if(empty($wo->room_id)) {{ $wo->location }} @else {{ $wo['room']['block']->name_of_block }}
        @endif</td>
  <td>@if(empty($wo->room_id)) {{ $wo->location }}  @else {{ $wo['room']->name_of_room }}
        @endif</td>
</tr>
</table>
<div class="row" style="padding-top: 2em; padding-bottom: 2em;">
  <div class="col"> <b>Details:</b> {{ $wo->details }}
    </div>
  </div>

  <hr>
  <br>
 @if($wo->emergency == 1)
   <h6 align="center" style="color: red;"><b> This Works order is Emergency </b></h6>
 @endif


  <br>
    <h4><b>Transport Description: </b></h4>
  @if(empty($wo['work_order_transport']->work_order_id))
        <p style="color: blue;">No Transport form</p>
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
    <td style="color:blue;">@if($tform->status==0) WAITING   @elseif($tform->status==1) APPROVED @else REJECTED   @endif</td>
  


     <td> <a onclick="myfunc2('{{$tform->details}}')"><span data-toggle="modal" data-target="#viewdetails"
                                                                         class="badge badge-success">View Message</span></a></td>

  <td>{{ 
   $tform->created_at }}</td>
  </tr>
  
  @endforeach
  </table>
    @endif
    <br>
  
  <hr>
    <h4><b>Technician assigned: </b></h4>
@if(empty($wo['work_order_staff']->id))
        <p style="color: blue;">No Technician assigned yet</p>
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
  
   @if($techform['technician_assigned'] != null)
    <td>{{$techform['technician_assigned']->lname.' '.$techform['technician_assigned']->fname}}</td>
   <td style="color:blue;">@if($techform->status==1) COMPLETED   @else  OnPROGRESS   @endif</td>

     

    <td><?php $time = strtotime($techform->created_at); echo date('d/m/Y',$time);  ?></td>
   
    @if($techform->created_at ==  $techform->updated_at)
   
   
    <td> NOT COMPLETED</td>
    @else
    <td><?php $time = strtotime($techform->updated_at); echo date('d/m/Y',$time);  ?></td>
    @endif
    
   @if($techform->status!=1)
   <td>   <a style="color: black;" href="{{ route('workOrder.technicianComplete', [$techform->id]) }}" data-toggle="tooltip" title="COMPLETE WORK"><i
                                                    class="fas fa-clipboard-check large"></i></a></td>
                          
    </td>
  @endif  

  
  



          @else
          <td style="color: blue;">No technician assigned yet</td>
      @endif
  
  
  
  </tr>
    @endforeach
  </table>
    @endif
    <br>
  
  <hr>  
  <br>
    <h4><b>Material Requests: </b></h4>
  @if(empty($wo['work_order_material']->id))
        <p style="color: blue;">No Material have been requested yet</p>
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
   <td style="color:blue;">@if($matform->status==0)<span class="badge badge-success"> WAITING FOR MATERIAL APPROVAL </span> @elseif($matform->status== 1)<span class="badge badge-success">APPROVED BY IOW </span> @elseif($matform->status== 2) RELEASED FROM STORE @elseif($matform->status==20) <span class="badge badge-success">PLEASE CROSSCHECK MATERIAL </span> @elseif($matform->status== 3)<span class="badge badge-primary">MATERIAL TAKEN FROM STORE</span>  @elseif($matform->status == -1)
    REJECTED BY IOW
       @endif</td>
      
   <td><?php $time = strtotime($matform->created_at); echo date('d/m/Y',$time);  ?></td>
   <td><?php $time = strtotime($matform->updated_at); echo date('d/m/Y',$time);  ?></td>
   
  </tr>
  
  @endforeach
  
  </table>
    @endif
    <br>
  
 
  <hr>

     <h4><b>Material Used: </b></h4>
     
  @if(empty($wo['work_order_material']->id))
        <p style="color: blue;">No Material Used for this Works order</p>
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
  
  
  <hr>
    <h4><b>Inspection Description: </b></h4>
    @if(empty($wo['work_order_inspection']->status))
        <p style="color: blue;">Not inspected yet</p>
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
    <td style="color:blue;" >{{ $iform->status }}</td>
    <td>{{ $iform->description }}</td>
      <td>{{$iform['technician']->lname.' '.$iform['technician']->fname }}</td>
    <td><?php $time = strtotime($iform->date_inspected); echo date('d/m/Y',$time);  ?></td>
  </tr>
  
  @endforeach
  </table>
    @endif
    <br>
    <hr>
    @if(strpos(auth()->user()->type, "HOS") !== false)
         
          @if($wo->status == 30)
            <div>
                <span class="badge badge-warning" style="padding: 20px">Works order completely closed!</span>
            </div>

        @elseif($wo->status == 2)
            <div>
                <span class="badge badge-warning" style="padding: 20px">Works order tempolary closed!</span>
            </div>
        @elseif($wo->status == 9)
              
        @else
            
        @endif

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
    
</div>

</div>