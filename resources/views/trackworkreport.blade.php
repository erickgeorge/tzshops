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
        
          @if(empty($wo->room_id)) 
          <tr>
            <td colspan="4">Location : <b>{{ $wo->location }} </b></td> </tr>
           
         @else

         <tr>
                   {{ $wo['room']['block']->location_of_block }}
            </b> </td>
            <td colspan="2">Area : <b>
                        
                   {{ $wo['room']['block']['area']->name_of_area }}
                          </b></td>
            <td>Block : <b>
                   {{ $wo['room']['block']->location_of_block }}
                </b> </td>
            <td>Room : <b>
                  {{ $wo['room']->name_of_room }}
             </b></td>
       </tr>
              @endif
        
        <tr>
            <td colspan="4">Description of the problem: <b style="text-transform: capitalize;">{{ $wo->details }}</b> </td>
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

<table style=" width:100%">
 
     <thead style="background-color: #376ad3;color: white;">
       <tr>
    <th>Date of Transport</th>
    <th>Time</th>
    <th>Details</th>
  <th>Status</th>
  <th>Message</th>

    <th>Date</th>
      </tr>
  </thead>
  <tbody>

    @foreach($tforms as $tform)


  <tr>
    <td>{{ date('d F Y', strtotime($tform->time))  }}</td>
    <td>{{ date('h:i:s A', strtotime($tform->time)) }}</td>
     <td> {{$tform->coments}}</td>
    <td>@if($tform->status==0) Waiting  @elseif($tform->status==1) Approved @else REJECTED   @endif</td>



     <td> {{$tform->details}}</td>

 <td>{{ date('d F Y', strtotime($tform->created_at))  }} </td>

  </tr>

  @endforeach
  </tbody>
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


 <thead style="background-color: #376ad3;color: white;">    
  <tr>
    <th>Full Name</th>
  <th>Status</th>
    <th>Date Assigned</th>
 <!-- <th>Date Completed</th>-->
  @foreach($techforms as $techform)
  @endforeach
  @if($techform->leader != null )
  <th>Leader</th>
  @endif

  </tr>
</thead>
<tbody>
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
    </tbody>
  </table>
   <br>

   <hr>
    <br>
 @endif
@endif


<!--assigned technician for work-->



<!--report after work-->


    <?php

  $idwo=$wo->id;
  $iforms = WorkOrderInspectionForm::where('work_order_id',$idwo)->where('status','Report after work')->get();
        ?>



    @if(count($iforms)>0)


 <h4><b>Technician(s) Report After Work </b></h4>

<table style="width:100%">

   <thead style="background-color: #376ad3;color: white;">
        <tr>

    <th>Description</th>
  <th>Full Name</th>
    <th>Date</th>
     </tr>
  </thead>
  <tbody>
 
    @foreach($iforms as $iform)


  <tr>

    <td><textarea class="form-control" disabled>{{ $iform->description }}</textarea></td>
      <td>{{$iform['technician']->lname.' '.$iform['technician']->fname }}</td>
    <td>{{ date('d F Y', strtotime($iform->date_inspected )) }}</td>
  </tr>

  @endforeach
  </tbody>
  </table>

  <br>
    <hr>
      <br>



  <br>

    @endif

<!--report after work-->





  <!--MATERIALS-->

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

    <thead style="background-color: #376ad3;color: white;">
  <tr>
    <th>Materials Name</th>

  <th>Type</th>
   <th>Quantity</th>
   <!--<th>IoW</th>-->
   <th>Approved By</th>
    <th>Status</th>
     <th>Date Requested</th>
      <th>Date Updated</th>
        </tr>
       </thead>

<tbody>
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
  </tbody>

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
 <thead style="background-color: #376ad3;color: white;">    <tr>
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
</tbody>
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
 <thead style="background-color: #376ad3;color: white;">
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
   <td>{{$matform['material']->name }}</td>
   <td>{{$matform['material']->description }}</td>
   <td>{{$matform['material']->type }}</td>
   <td>{{$matform->quantity }}</td>
  </tr>

  @endforeach
</tbody>

  </table>
    <br>

    <br>


    <hr>
    @endif
  

  <!--MATERIALS-->




@if ($wo->systemclosed!=0)
<br>
<table class="table table-light">
    <tbody>
        <tr>
            <td style="text-transform: capitalize;">This Works Order Was Closed Automatically by a system due to a Customer delay of closing for 7 days on : {{ date('d F Y', strtotime($wo->updated_at))  }} </td>
        </tr>
    </tbody>
</table>
@elseif($wo->status == 30)
<br>
<table class="table table-light">
    <tbody>
        <tr>
            <td style="text-transform: capitalize;">This Works Order Was Closed on : {{ date('d F Y', strtotime($wo->updated_at))  }}  By Head of section</td>
        </tr>
    </tbody>
</table>
 @endif

 <div id='footer'>
    <p class="page">Page-</p>
</div>
