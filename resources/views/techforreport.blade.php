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
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>
 <div class="container">

    <br>
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

<hr>

<br>


       <div class="container-name">
     <div class="div1">This works order is submitted by <span
                style=" font-weight: bold; color: green;">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span>

     </div>
     <div class="div2"> On:  <span style=" font-weight: bold; color: green;">{{ date('d F Y', strtotime($wo->created_at)) }}</span>  </div>
  <br>
  <br>

   </div>

          <div class="container-name">
     <div class="div1">Also @if($wo->status == 0)rejected@elseif($wo->status == 1) accepted @else processed @endif by <span
                style=" font-weight: bold; color: green;">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span>

     </div>
     <div class="div2"> Mobile number:  <span style=" font-weight: bold; color: green;">{{ $wo['user']->phone }}</span>  </div>
    <div class="div2">Emai: <span style=" font-weight: bold; color: green;"> {{ $wo['user']->email }} </span> </div>

   </div>




    <hr>

<br>

       <div class="container-name">
     <div class="div1">Type of Problem: <span
                style=" font-weight: bold; color: green;">{{ ucwords(strtolower($wo->problem_type)) }}</span>

     </div>
     <div class="div2"> Location:  <span style=" font-weight: bold; color: green;">@if(empty($wo->room_id)) {{ $wo->location }}
        @else
           {{ $wo['room']['block']->location_of_block }}
        @endif</span>  </div>
  <br>
  <br>

   </div>


          <div class="container-name">
     <div class="div1">Area: <span
                style=" font-weight: bold; color: green;"> @if(empty($wo->room_id))
      {{ $wo->room_id }}

                @else
         {{ $wo['room']['block']['area']->name_of_area }}
                @endif</span>

     </div>
     <div class="div2"> Block:  <span style=" font-weight: bold; color: green;">@if(empty($wo->room_id)) {{ $wo->location }}
        @else
           {{ $wo['room']['block']->location_of_block }}
        @endif</span>  </div>
  <br>
  <br>

   </div>

          <div class="container-name">
     <div class="div1">Room <span
                style=" font-weight: bold; color: green;"> @if(empty($wo->room_id))
          {{ $wo->location }}
        @else
            {{ $wo['room']->name_of_room }}
        @endif</span>

     </div>
     <div class="div2"> Details  <span style=" font-weight: bold; color: green;">{{ $wo->details }}</span>  </div>
  <br>
  <br>

   </div>



  <hr>
 @if($wo->emergency == 1)

 <br>
   <h6 align="center" style="color: red;"><b> This Works Order Is Emergency</b></h6>
   <br>
   <hr>
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
   <th>Leader</th>


  </tr>
  <thead>
    <tbody>
    @foreach($techforms as $techform)
  <tr>

     @if($techform['technician_assigned_for_inspection'] != null)
    <td>{{$techform['technician_assigned_for_inspection']->lname.' '.$techform['technician_assigned_for_inspection']->fname}}</td>
   <td class="text-primary">@if($techform->status==1) Completed   @else  On Progress  @endif</td>

 <td>{{ date('d F Y', strtotime($techform->created_at)) }} </td>

   @if($techform->status==1)

  <td>{{ date('d F Y', strtotime($techform->updated_at)) }}</td>
    @else


      <td style="color: red"> Not Completed Yet</td>
    @endif

 @if($techform->leader == null )

<td>   <a style="color: black;" href="{{ route('workOrder.technicianassignleaderinspection', [$idwo ,$techform->id ]) }}" data-toggle="tooltip" title="Assign leader"><i
                                                    class="fas fa-user-tie large"></i></a></td>
                                                   @elseif($techform->leader2 == 3 )
 <td style="color: black;"  data-toggle="tooltip" >Leader<i
                                                    class="fas fa-user-tie large"></i></td>
                                                    @else
<td style="color: black;"  data-toggle="tooltip" >Normal technician</i></td>
                                                    @endif
W




      @endif



  </tr>
  </tbody>
    @endforeach
  </table>


    @endif
   <br>

   <hr>
    <br>
    <br>

<div>Inspection Description:</div>
   <div  style="
  width: 520px;
  border: 2px solid #376ad3;
  padding: 50px;
  height: 200px;
  margin: 20px;"></h1>

    </div>



<br>
   <div class="container-name">
     <div class="div1">Name of Technician Leader: &nbsp;  &nbsp;&nbsp;  &nbsp;..........................................<u style="padding-left: 12px;"> </u></div>
     <div class="div2"> Signature:  .................................... <u style="padding-left: 40px;">   </u> </div>
    <div class="div2">Date: &nbsp;  &nbsp;  &nbsp;  &nbsp;   .................................... <u style="padding-left: 40px;"> </u> </div>

   </div>
<br>
<br><br>
   <div class="container-name">
     <div class="div1">Name of Head of Section: &nbsp;  &nbsp;&nbsp;  &nbsp;..........................................<u style="padding-left: 12px;"> </u></div>
     <div class="div2"> Signature:  .................................... <u style="padding-left: 40px;">   </u> </div>
    <div class="div2">Date: &nbsp;  &nbsp;  &nbsp;  &nbsp;   .................................... <u style="padding-left: 40px;"> </u> </div>

   </div>

<br><br>


  <div class="container-name">
     <div class="div1"></div>
     <div class="div2"> Official Stamp: <u style="padding-left: 40px;">   </u> </div>


   </div>




  <br>

