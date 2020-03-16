    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ESMIS - @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="icon" type="image/png" href="{{ url('/images/index.jpg') }}"/>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/fontawesome/css/all.css') }}">
    <!-- code mpya -->


    <!-- code mpya -->




    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />


</head>
<body  onload="createTable()">
<style type="text/css">
    .nav-item:hover{
        background-color:#0acb;
    }

        .tablinks:hover{
            background-color:#4d6788;
        }
        div{
            font-weight: bold;
        }
    </style>

<div>
     <nav class="navbar fixed-top navbar-expand-lg "  style="border-bottom: #ebe9e6 8px solid; background-color: #376ad3;">


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto text-center">
                <li class="nav-item">
                    <b> <a class="nav-link" style="color:white" href="{{ url('dashboard')}}">Dashboard <span
                                    class="sr-only">(current)</span></a> </b>
                </li>
<?php
                use App\WorkOrderMaterial;
        use App\PurchasingOrder;
                use App\WorkOrderTransport;
                use App\Material;
                use App\WorkOrder;


        use App\zoneinspector;
        $iozone =  zoneinspector::where('inspector',auth()->user()->id)->first();

                $w = WorkOrder::select(DB::raw('id'))->get();

                $m = Material::select(DB::raw('name'))->get();

                $wo_material_reservedd = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',55)->orwhere('reservestatus', 1)->groupBy('work_order_id')->get();

                $woMaterialAccepted = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',1)->orwhere('copyforeaccepted' , 1)
                    ->groupBy('work_order_id')->get();

                $woMaterialrejected = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',-1)->orwhere('status',17)
                    ->groupBy('work_order_id')->get();

               $woMaterialreserved = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',5)->orwhere('reservestatus',1)
                    ->groupBy('work_order_id')->get();



                $wo_material_procured_by_iow = WorkOrderMaterial::select(DB::raw('material_id'))->where('status',15)->groupBy('material_id')->get();

                $material_to_estatedirector = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',5)->groupBy('work_order_id')->get();

                $material_to_purchased = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',15)->groupBy('work_order_id')->get();

                 $material_used = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',3)->groupBy('work_order_id')->get();


                $material_requests = WorkOrderMaterial::where('zone', $iozone['zone'])->select(DB::raw('work_order_id'))->where('status',0)->groupBy('work_order_id')->get();


                 $material_requestsmc = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',0)->groupBy('work_order_id')->get();
                $material_requests = WorkOrderMaterial::where('zone', $iozone['zone'])->
                       select(DB::raw('work_order_id'),'hos_id' )
                     ->where('status',0)
                     ->orwhere('status', 9)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')

                     ->get();


                 $material_requestsmc = WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'hos_id' , 'zone')
                     ->where('status',0)
                     ->orwhere('status', 9)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')
                     ->groupBy('zone')
                     ->get();


                 $wo_material_accepted_iow = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',1)->groupBy('work_order_id')->get();

                $wo_materialreceive=   WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'receiver_id')
                     ->where('status',3)
                     ->groupBy('work_order_id')
                     ->groupBy('receiver_id')
                     ->get();



                $wo_material_needed = WorkOrderMaterial::where('status', 0)->get();

                $wo_material_approved = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',3)->groupBy('work_order_id')->get();;
        $procurement_request = PurchasingOrder::select(DB::raw('work_order_id'))->where('status',0)->groupBy('work_order_id')->get();
                $procurement_request_acceptedbyiow = PurchasingOrder::select(DB::raw('work_order_id'))->where('status',1)->groupBy('work_order_id')->get();

                $wo_transport = WorkOrderTransport::where('status',0)->get();

                ?>

@if(auth()->user()->type == 'Director DPI')
  <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('infrastructureproject')}}">PPU</a>
            </li>
 @endif


                @if(auth()->user()->type == 'DVC Admin')
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work orders  </a>
                    </li>
                @endif



                @if(auth()->user()->type == 'Acountant')
                <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('minutesheets')}}">Minutesheets</a>
                    </li>
                @endif






                 @if(auth()->user()->type == 'Head Procurement')
                   <!-- <li class="nav-item">
                        <a class="nav-link" style="color:white">Materials to be purchased <span
                                    class="badge badge-light"></span></a>
                    </li>-->


                     <!--
                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_grn')}}">Sign GRN For PO </a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('wo_release_grn')}}">Release Procured Material </a>
                    </li>
                    -->

                @endif



           @if(auth()->user()->type == 'Procurement and Supplies Officer')
             <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_procurement_request')}}">Procurement Requests <span
                                    class="badge badge-light">{{ count($procurement_request_acceptedbyiow) }}</span></a>
                    </li>



                 @endif



 @if(auth()->user()->type == 'DVC Admin')
 <li class="nav-item">
     <a href="{{ url('comp') }}" title="Complaints" style="color:white" class="nav-link"><i style="color: yellow;" class="fa fa-exclamation-triangle"></i>Complaints</a>
 </li>
 <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('infrastructureproject')}}">PPU</a>
            </li>
 @endif






                      <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>








                @if(auth()->user()->type == 'STORE')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white;" href="{{ url('stores')}}">Store <span
                                    class="badge badge-light">{{ count($m) }}</span></a>
                    </li>

                @endif


              @if($role['user_role']['role_id'] == 1)

            <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('stores')}}">Store<span
                                    class="badge badge-light">{{ count($m) }}</span></a>
            </li>


 <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('manage_Campus')}}">Assets</a>
            </li>


             <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Land/work_order')}}">Landscaping</a>
            </li>

        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu dropdown-menu-right top-dropdown" aria-labelledby="navbarDropdown" style="background-color: #376ad3;">

               <a class="dropdown-item" style="color:white" href="{{ url('Manage/directorate')}}">College/Directorate</a>
               <a style="color:white" class="dropdown-item" href="{{ url('Manage/department')}}">Department</a>

               <a style="color:white" class="dropdown-item" href="{{ url('Manage/IoWZones/with/iow')}}">Zones</a>





        </div>
       </li>



                 @endif


                    @if(auth()->user()->type == 'Estates Director')
                      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu dropdown-menu-right top-dropdown" aria-labelledby="navbarDropdown" style="background-color: #376ad3;">

               <a class="dropdown-item" style="color:white" href="{{ url('Manage/directorate')}}">College/Directorate</a>
               <a style="color:white" class="dropdown-item" href="{{ url('Manage/department')}}">Department</a>

               <a style="color:white" class="dropdown-item" href="{{ url('Manage/IoWZones')}}">IoW Zones</a>
 <a style="color:white" class="dropdown-item" href="{{ url('excelinsertusers')}}">Import Excel</a>




        </div>
       </li>
       <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('infrastructureproject')}}">PPU</a>
            </li>

                    @endif




            </ul>
            <span class="navbar-text">

      <ul class="navbar-nav mr-auto">
        <li>
             @if($role['user_role']['role_id'] == 1)
                    <li class="nav-item">
                        <a class="nav-link" style="color:white " href="{{ url('viewusers')}}">Users</a>
                    </li>
               @endif
               </li>
        <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="color:white;" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                         <span class="badge badge-light">{{ count($notifications) }}</span></a>
                    <div class="dropdown-menu dropdown-menu-right" style="background-color: #676464; color:#212529;" aria-labelledby="navbarDropdown">
                        @foreach($notifications as $notification)
                            @if($notification->type == 'wo_rejected')
                                <a class="dropdown-item"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{ 'reject-'.$notification->id }}').submit();">
                                    {{ $notification->message }}
                                </a>

                                <form id="{{ 'reject-'.$notification->id }}"
                                      action="{{ route('notify.read', [$notification->id, 'reject']) }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a class="dropdown-item"
                                   onclick="event.preventDefault();
                                           document.getElementById('{{ 'accept-'.$notification->id }}').submit();">
                                    {{ $notification->message }}
                                </a>

                                <form id="{{ 'accept-'.$notification->id }}"
                                      action="{{ route('notify.read', [$notification->id, 'accept']) }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @endif
                        @endforeach
                        {{--<div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Clear notifications</a>--}}
                        @if(count($notifications) <= 0)
                            <p class="dropdown-item"> No new notification</p>
                        @endif
                    </div>
                </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle"></i>
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-right top-dropdown" aria-labelledby="navbarDropdown" style="background-color: #376ad3;" >
           <!--SETTING AND CHANGE PASSWORD
          <a class="dropdown-item" style="color:white" href="{{ url('settings')}}">Settings</a>-->

               <a class="dropdown-item" style="color:white" href="{{ url('myprofile')}}">My Profile</a>
          <a class="dropdown-item" style="color:white"  href="{{ url('password')}}">Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" style="color:white"  href="{{ route('logout') }}"
             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>

        </div>
      </li>
    </ul>
    </span>
            <!-- <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </nav>
    <div>
    <div style="padding-top:78px;">



<style>


/* Fixed sidenav, full height */
.sidenav {
  height: 100%;
  width: 150px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: none;
  overflow-x: hidden;
  padding-top: 20px;
  border-right: #ebe9e6 8px solid
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 4px 6px 4px 10px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;





}

.sidenav button{
  color: white;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
   background: #046475;
}



.sidenav a {
  background-color: #c2bebe;
  color: white;



}

.sidenav a, .dropdown-btn, .sidenav button {
  color: #f1f1f1;
  border: none;
   background: #376ad3;
    margin-top: 2px; 
}


/* Main content */
.main {
  margin-left: 150px; /* Same as the width of the sidenav */
 
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: #046475;
  color: white;
  
  border: 2px solid white;


}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: white;



}

.dropdown-container a {
  background-color: black;

}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</head>
<body>

<div class="sidenav" style="padding-top:90px;">
  <a  href="{{ url('work_order')}}" ><h6>Works order </h6></a>
 @if($role['user_role']['role_id'] == 1)


   <a  href="{{ url('Manage/section')}}"><h6>DES Sections</h6></a>
 @endif

 @if(strpos(auth()->user()->type, "HOS") !== false )
 <a  href="{{ url('technicians') }}"><h6>Technicians</h6></a>
 <button class="dropdown-btn"><h6>Material Update
    <i class="fa fa-caret-down"></i></h6>
  </button>
  <div class="dropdown-container">
    <a  href="{{ url('material_rejected_with_workorder')}}"><h6>Rejected Materials <span
                                    class="badge badge-light">{{ count($woMaterialrejected) }}</h6></span></a>
    <a  href="{{ url('material_received_with_workorder')}}"><h6>Received Material from Store</h6><span class="badge badge-light">{{ count($wo_materialreceive) }}</span></a>

  </div>

 @endif


 @if(auth()->user()->type == 'Maintenance coordinator')

  <a  href="{{ url('redirected_work_order')}}"><h6>Redirected Works order</h6></a>

  <a  href="{{ url('roomreport')}}"><h6>Room Report</h6></a>

   <a  href="{{ url('comp') }}" ><h6>Complaints<i style="color: yellow;" class="fa fa-exclamation-triangle"></i></h6></a>
   <a  href="{{ url('technicians') }}"><h6>Technicians</h6></a>
   <a  href="{{ url('workzones')}}"><h6>Zones</h6></a>

    <button  class="dropdown-btn"><h6>Material Requests Update
    <i class="fa fa-caret-down"></i></h6>
  </button>
  <div class="dropdown-container">
    <a  href="{{ url('work_order_material_needed')}}"><h6>Work order needs material <span
                                    class="badge badge-light">{{ count($material_requestsmc) }}</span></h6></a>
    <a  class="dropdown-item" style="color:white" href="{{ url('wo_material_accepted')}}"><h6>Accepted Materials<br><span class="badge badge-light">{{ count($woMaterialAccepted) }}</span></h6></a>
     <a  href="{{ url('material_rejected_with_workorder')}}"><h6>Rejected Materials
                        <span
                                    class="badge badge-light">{{ count($woMaterialrejected) }}</span></h6></a>


  </div>



  @endif



                @if(auth()->user()->type == 'Estates Director')



                 <!--    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('completed_work_orders')}}">Completed Work-orders</a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('woduration')}}">WO Duration</a>
                    </li>
                    -->


  <button  class="dropdown-btn"><h6>Works order Reports
    <i class="fa fa-caret-down"></i></h6>
  </button>
  <div class="dropdown-container">
    <a class="btn" href="{{ url('/unattended_work_orders')}}"><h6>Unattended Work Orders</h6></a>
    <a class="btn" href="{{ url('/completed_work_orders')}}"><h6>Completed Work Orders</h6></a>
    <a class="btn" href="{{ url('/woduration')}}"><h6>Work Orders Duration</h6></a>


  </div>

  <button

  class="dropdown-btn"><h6>Head of Sections
    <i class="fa fa-caret-down"></i></h6>
  </button>
  <div class="dropdown-container">
    <a  href="{{ url('/allhos')}}"><h6>All Head of sections Details</h6></a>
    <a  href="{{ url('hoscount')}}"><h6>HoS with completed works orders</h6></a>
  </div>


   <button class="dropdown-btn"><h6>Technicians
    <i class="fa fa-caret-down"></i></h6>
  </button>
  <div class="dropdown-container">
    <a href="{{ url('/techniciancountcomp')}}"><h6>Technician Completed Work</h6></a>
    <a href="{{ url('/alltechnicians')}}"><h6>All Technicians Details</h6></a>
  </div>


   <a  href="{{ url('/alliow')}}"><h6>Inspectors of work</h6></a>


   <button  class="dropdown-btn"><h6>store
    <i class="fa fa-caret-down"></i></h6>
  </button>
  <div class="dropdown-container">
    <a href="{{ url('stores')}}"><h6>All Materials in Store<span
                            class="badge badge-light">{{ count($m) }}</span></h6></a>
    <a href="{{ url('work_order_with_missing_material')}}"><h6>Purchase <span
                                    class="badge badge-light">{{ count($material_to_estatedirector) }}</span></h6></a>
  </div>




                    <!-- <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('techniciancountcomp')}}">Technician Report</a>
                    </li>-->



                        <a  href="{{ url('roomreport')}}"><h6>Room Report</h6></a>


                        <!--<a href="{{ url('minutesheets')}}"><h6>Minutesheets</h6></a>-->

     <a href="{{ url('comp') }}" title="Complaints" style="color:white" ><h6>Complaints<i style="color: yellow;" class="fa fa-exclamation-triangle"></i></h6></a>



    @endif



    @if(auth()->user()->type == 'STORE')



                   <!-- <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_approved_material')}}">Materials needed <span
                                    class="badge badge-light">{{ count($wo_material_approved) }}</span></a>
                    </li>-->

                    <!--<li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_released_material')}}">All Requests </a>
                    </li>-->


                        <a  href="{{ url('material_received_with_workorder')}}" ><h6>Material Taken From Store <span
                                    class="badge badge-light">{{ count($material_used) }}</span></h6></a>


                        <a href="{{ url('wo_material_reserved') }}" ><h6>Reserved Materials <span
                                    class="badge badge-light">{{ count($woMaterialreserved) }}</span></h6></a>



                        <a  href="{{ url('wo_material_accepted_by_iow')}}"><h6>Material requests<span
                                    class="badge badge-light">{{ count($wo_material_accepted_iow) }}</span></h6></a>





                    <!--<li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('wo_material_purchased_by_head_of_procurement') }}" >Material Purchased <span
                                    class="badge badge-light">{{ count($wo_material_procured_by_iow) }}</span></a>
                    </li>-->



                        <a href="{{ url('work_order_material_purchased') }}" ><h6>Material Purchased <span
                                    class="badge badge-light">{{ count($material_to_purchased) }}</span></h6></a>


                      <a href="{{ url('ProcurementHistory') }}"><h6>Procurement</h6></a>


           <!--
           <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_grn')}}">Sign GRN For PO </a>
                    </li>

           <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('wo_release_grn')}}">Release Procured Material </a>
                    </li>
          -->
               @endif






  @if(auth()->user()->type == 'Head Procurement')

<a href="{{ url('work_order_with_missing_material')}}"><h6>Materials to purchase <span
                                    class="badge badge-light">{{ count($material_to_estatedirector) }}</span></h6></a>
<!--<a href="{{ url('minutesheets')}}"><h6>Minutesheets</h6></a>-->

<a href="{{ url('stores')}}"><h6>Store</h6></a>

  <button  class="dropdown-btn"><h6>Procurement
    <i class="fa fa-caret-down"></h6></i>
  </button>
  <div class="dropdown-container">
    <a href=" {{ url('procurementAddMaterial') }}"><h6>Add new procurement list</h6></a>
    <a href="{{ url('ProcurementHistory') }}"><h6>View Procurement History</h6></a>


  </div>



   @endif


       @if(auth()->user()->type == 'Transport Officer')

                        <a  href="{{ url('wo_transport_request')}}"><h6>Transport Requests <span
                                    class="badge badge-light">{{ count($wo_transport) }}</h6>

                        <a href="{{ url('wo_transport_request_accepted')}}"><h6>Accepted Transports</h6></a>


                        <a href="{{ url('wo_transport_request_rejected')}}"><h6>Rejected Transports</h6></a>



                @endif



    @if(auth()->user()->type == 'Inspector Of Works')

     <a href="{{ url('myzone')}}"><h6>My Zone <span
                                    class="badge badge-light">{{ count($material_requests) }}</span></h6></a>


                        <a href="{{ url('work_order_material_needed')}}"><h6>Work order needs material <span
                                    class="badge badge-light">{{ count($material_requests) }}</span></h6></a>




                        <a href="{{ url('wo_material_accepted')}}"><h6>Accepted Materials<span
                                    class="badge badge-light">{{ count($woMaterialAccepted) }}</span></h6></a>



                        <a  href="{{ url('material_rejected_with_workorder')}}"><h6>Rejected Materials
                        <span
                                    class="badge badge-light">{{ count($woMaterialrejected) }}</span></h6></a>



                    <!--
           <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_purchasing_request')}}">Procurement Requests <span
                                    class="badge badge-light">{{ count($procurement_request) }}</span></a>
                    </li>
                    -->

                @endif






</div>

<div class="main">
 @yield('body')
</div>

<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}
</script>







    </div>
</div><!--
<footer class="py-3 bg-dark" style="margin-bottom: 0;">
    <div class="container">
    <p class="m-0 text-center text-white"> ESMIS &copy; <?php echo date('Y'); ?>, All rights reserved</div>
</footer>-->
<script
        src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="{{ asset('/js/main.js') }}"></script>
<script src="http://code.jquery.com/jquery-2.0.3.min.js" data-semver="2.0.3" data-require="jquery"></script>
<script data-require="jqueryui@*" data-semver="1.10.0" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.js" data-semver="1.9.4" data-require="datatables@*"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script>
    $('#myTable').DataTable();
    $('#myTablee').DataTable();
    $('#myTableee').DataTable();
</script>



<script type="text/javascript">
    function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField.value) == false)
        {
            alert('Invalid Email Address');
            return false;
        }

        return true;

}
</script>
<script type="text/javascript">

      $("#nameid").select2({
            placeholder: "Choose type of problem...",
            allowClear: true
        });
</script>


<script type="text/javascript">

      $("#p_type").select2({
            placeholder: "Choose type of problem...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#area").select2({
            placeholder: "Choose Area...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#location").select2({
            placeholder: "Choose Location...",
            allowClear: true
        });
</script>


<script type="text/javascript">

      $("#block").select2({
            placeholder: "Choose Block...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#room").select2({
            placeholder: "Choose Room...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#materialreq").select2({
            placeholder: "Choose material...",
            allowClear: true
        });
</script>




<script type="text/javascript">

      $("#totalmaterials").select2({
            placeholder: "Choose material...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#directorate").select2({
            placeholder: "Choose College...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#section").select2({
            placeholder: "Choose Section...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#department").select2({
            placeholder: "Choose Department...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#role").select2({
            placeholder: "Choose role...",
            allowClear: true
        });
</script>


<script type="text/javascript">

      $("#techid").select2({
            placeholder: "Choose Section...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#typetechadmin").select2({
            placeholder: "Choose Section...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#directoratee").select2({
            placeholder: "Choose Section...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#type").select2({
            placeholder: "Choose user type...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#des").select2({
            placeholder: "Choose Directorate...",
            allowClear: true
        });
</script>


<script type="text/javascript">

      $("#desp").select2({
            placeholder: "Choose department...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#typeudsm").select2({
            placeholder: "Choose user type...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#techidforinspection").select2({
            placeholder: "Choose Technician...",
            allowClear: true
        });
</script>


<script type="text/javascript">

      $("#zone").select2({
            placeholder: "Choose IoW Zone...",
            allowClear: true
        });
</script>


<script type="text/javascript">

      $("#iow").select2({
            placeholder: "Choose Inspector of Work...",
            allowClear: true
        });
</script>

<script type="text/javascript">

      $("#iowzone").select2({
            placeholder: "Choose zone Location...",
            allowClear: true
        });
</script>






</body>
</body>
</html>
