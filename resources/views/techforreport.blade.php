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



<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th colspan="4">Works Order Summary</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="2">Sumitted By: <b>{{ $wo['user']->fname.' '.$wo['user']->lname }}</b>


     </td>
            <td >On : <b>{{ date('d F Y', strtotime($wo->created_at)) }}</b></td>

            <td>Problem Type : <b>{{ ucwords(strtolower($wo->problem_type)) }}</b> </td>
        </tr>
        <tr>

            <td> Location : <b>@if(empty($wo->room_id)) {{ $wo->location }}
                @else
                   {{ $wo['room']['block']->location_of_block }}
                @endif </b> </td>
                <td>
                    Area : <b>@if(empty($wo->room_id))
                        {{ $wo->room_id }}

                                  @else
                           {{ $wo['room']['block']['area']->name_of_area }}
                                  @endif</b>
                </td>
                <td>
                    Block : <b>@if(empty($wo->room_id)) {{ $wo->location }}
                        @else
                           {{ $wo['room']['block']->location_of_block }}
                        @endif</b>
                </td>
                <td>
                    Room : <b>@if(empty($wo->room_id))
                        {{ $wo->location }}
                      @else
                          {{ $wo['room']->name_of_room }}
                      @endif</b>
                </td>
        </tr>
        <tr>
            <td colspan="4">Details :
            <b>{{ $wo->details }}</b></td>
        </tr>
        <tr>
            <td colspan="2" style="text-transform: capitalize;">
                @if($wo->status == 0)rejected@elseif($wo->status == 1) accepted @else processed  by : @endif <b>{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</b>
            </td>
            <td> Mobile Number :  <b>{{ $wo['user']->phone }}</b></td>
            <td>Email : <b> {{ $wo['user']->email }} </b></td>
        </tr>
    </tbody>
</table>
<br>
 @if($wo->emergency == 1)
    <table>
        <tr>
            <td colspan="4">   <h6 align="center" style="color: red;"><b> This Works Order Is Emergency</b></h6>
            </td>
        </tr>
    </table>
    <br>
 @endif

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th colspan="4" style="text-transform: capitalize;"> Assigned technicians for inspection </th>
        </tr>
        <tr>
            <th>#</th>
            <th colspan="2">Name</th>
            <th colspan="1">Leader</th>
        </tr>
    </thead>
    <tbody>

    <?php

    $idwo=$wo->id;
    $techforms = techasigned::with('technician_assigned_for_inspection')->where('work_order_id',$idwo)->get();

   $leaders = techasigned::with('technician_assigned_for_inspection')->where('work_order_id',$idwo)->where('leader2', 3)->first();
 ?>
  @php
  $ad = 1;
@endphp
   @foreach($techforms as $techform)

        <tr>
        <td> {{$ad}}</td>
            <td colspan="2">
              <b style="text-transform: capitalize;">{{$techform['technician_assigned_for_inspection']->lname.' '.$techform['technician_assigned_for_inspection']->fname}}</b>
            </td>
            <td colspan="1">
                @if($techform->leader2 == 3 )
                Yes
                @else
                No
                @endif
            </td>
        </tr>
        @php
            $ad++;
        @endphp
    @endforeach
    </tbody>
</table>
<br>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Inspection Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="height: 200px;">

            </td>
        </tr>
    </tbody>
</table>

<br>

<table>
    <tr>
        <td>Head of Section : <b style="text-transform: capitalize;">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</b></td>
        <td>Lead Technician : <b style="text-transform: capitalize;">{{$leaders['technician_assigned_for_inspection']->lname.' '.$leaders['technician_assigned_for_inspection']->fname}}</b></td>
    </tr>
    <tr>
        <td>Signature : __________________ <br>
            Date : _________________________ </td>
        <td>Signature : __________________ <br>
        Date : _________________________ </td>
    </tr>

</table>


