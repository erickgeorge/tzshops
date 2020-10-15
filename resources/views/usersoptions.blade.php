


<!DOCTYPE html>
<html lang="en">

<head>

  <style>
    #loader {
      border: 12px solid #376ad3;
      border-radius: 50%;
      border-top: 12px solid #444444;
      width: 70px;
      height: 70px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      100% {
        transform: rotate(360deg);
      }
    }

    .center {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      margin: auto;
    }
  </style>
</head>

<body>
  <div id="loader" class="center"></div>













    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ESMIS - Users</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="icon" type="image/png" href="{{ url('/images/index.jpg') }}"/>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/fontawesome/css/all.css') }}">
    <!-- code mpya -->
    <link rel="stylesheet" href="{{asset('/tables/datatables.css')}}">
    <!-- code mpya -->

    <link rel="stylesheet" type="text/css" href="{{asset('/tables/Bootstrap-4-4.1.1/css/bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/tables/DataTables-1.10.21/css/dataTables.bootstrap4.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/tables/Buttons-1.6.2/css/buttons.bootstrap4.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/tables/SearchPanes-1.1.1/css/searchPanes.bootstrap4.css')}}"/>


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
              <li class="nav-item" style="margin-top: -10px;">

                <a class="nav-link" style="color:white" >
                    <img src="{{ asset('images/logo_ud.png') }}" style="height: 45px; width: 45px;"></a>
              </li>

<?php
                use App\WorkOrderMaterial;
        use App\PurchasingOrder;
                use App\WorkOrderTransport;
                use App\Material;
                use App\WorkOrder;
                use App\ppuproject;


                use Carbon\Carbon;

// closing work order by default
$woclo = WorkOrder::where('status',2)->get();
$leohii = Carbon::now();

foreach ($woclo as $woclo) {
    $sikuhii = Carbon::parse($woclo->updated_at);
    $tofautihii = $sikuhii->diffInDays($leohii);

    if ($tofautihii > 6) {
        $wokioda = WorkOrder::where('id',$woclo->id)->first();
        $wokioda->status = 30;
        $wokioda->save();
    }
}
//
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



@if(($role['user_role']['role_id'] != 1) and (auth()->user()->type != 'Maintenance coordinator') and (auth()->user()->type != 'DVC Admin') and (auth()->user()->type != 'Estates Director'))
                  <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>
@endif

   @if(auth()->user()->type == 'Estates Director')

    <li style="width: 80px;">

                    </li>

       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu dropdown-menu-left top-dropdown" aria-labelledby="navbarDropdown" style="background-color: #376ad3;">

              <a class="dropdown-item" style="color:white" href="{{ url('Manage/directorate')}}">College/Directorate</a>
               <a style="color:white" class="dropdown-item" href="{{ url('Manage/department')}}">Department</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/locations')}}">Locations</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Areas')}}">Areas</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Blocks')}}">Blocks</a>   
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Rooms')}}">Rooms</a>

               <a style="color:white" class="dropdown-item" href="{{ url('Manage/IoWZones/with/iow')}}">Zones</a>

        </div>
       </li>

<li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>


  <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Assessment/form')}}">Cleaning Services</a>
                    </li>




                    @endif



  @if((auth()->user()->type == 'Maintenance coordinator')||(auth()->user()->type == 'DVC Admin'))



               <li style="width: 80px;">

                    </li>

                      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu dropdown-menu-left top-dropdown" aria-labelledby="navbarDropdown" style="background-color: #376ad3;">
  <a class="dropdown-item" style="color:white" href="{{ url('Manage/directorate')}}">College/Directorates</a>
               <a style="color:white" class="dropdown-item" href="{{ url('Manage/department')}}">Departments</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/locations')}}">Locations</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Areas')}}">Areas</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Blocks')}}">Blocks</a>   
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Rooms')}}">Rooms</a>

               <a style="color:white" class="dropdown-item" href="{{ url('Manage/IoWZones/with/iow')}}">Zones</a>




        </div>
       </li>


       <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>


       @endif


 @if((auth()->user()->type == 'DVC Admin')||(auth()->user()->type == 'Estates Director'))

                    <li class="nav-item">
                        <a class="nav-link" style="color:white;" href="{{ url('stores')}}">Store <span
                                    class="badge badge-light">{{ count($m) }}</span></a>
                    </li>

 @endif


@if ((auth()->user()->type =='Maintenance coordinator')||(auth()->user()->type =='Housing Officer')||(auth()->user()->type =='USAB')||(auth()->user()->type =='DVC Admin')||(auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'Bursar')||(auth()->user()->type == 'Assets Officer'))
<li class="nav-item">
    <a class="nav-link" style="color:white"  href="{{ url('assetsManager')}}">Assets</a>
</li>
@endif

@if(((auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'DVC Admin')||auth()->user()->type == 'Director DPI')||(auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Architect & Draftsman')||(auth()->user()->type == 'Quality Surveyor'))

<!--<li class="nav-item">
    <a class="nav-link" style="color:white"  href="{{ url('infrastructureproject')}}">
        Planning
        <span class="badge badge-light">
            @if(auth()->user()->type == 'Estates Director')
                @php
                    $statusPPU = ppuproject::where('status','10')->orwhere('status','7')->orwhere('status','11')->orwhere('status','2')->get();
                @endphp
            @elseif(auth()->user()->type == 'DVC Admin')
                @php
                    $statusPPU = ppuproject::where('status','1')->orwhere('status','6')->orwhere('status','13')->get();
                @endphp
            @elseif(auth()->user()->type == 'Director DPI')
                @php
                    $statusPPU = ppuproject::where('status','0')->orwhere('status','-1')->get();
                @endphp
            @elseif(auth()->user()->type == 'Head PPU')
                @php
                    $statusPPU = ppuproject::where('status','3')->orwhere('status','5')->orwhere('status','12')->orwhere('status','9')->get();
                @endphp
            @elseif(auth()->user()->type == 'Architect & Draftsman')
                @php
                    $statusPPU = ppuproject::where('status','4')->get();
                @endphp
            @else
                @php
                    $statusPPU = ppuproject::where('status','8')->get();
                @endphp
            @endif
            {{ count($statusPPU) }}
        </span>
    </a>
  </li>-->
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

                      <!-- <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('infrastructureproject')}}">Planning</a>
                       </li>-->

                        <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Assessment/form')}}">Cleaning Services</a>
                    </li>
                       @endif



                   @if(auth()->user()->type == 'Dvc Accountant')

                      <!-- <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('infrastructureproject')}}">Planning</a>
                       </li>-->

                        <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Assessment/form')}}">Cleaning Services</a>
                    </li>
                       @endif



                    @if((auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Supervisor Landscaping'))

                    <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Assessment/form')}}">Cleaning Services</a>
                    </li>

                    @endif








                @if(auth()->user()->type == 'STORE')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white;" href="{{ url('stores')}}">Store <span
                                    class="badge badge-light">{{ count($m) }}</span></a>
                    </li>

                @endif


              @if($role['user_role']['role_id'] == 1)

               <li style="width: 80px;">

                    </li>


                      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu dropdown-menu-left top-dropdown" aria-labelledby="navbarDropdown" style="background-color: #376ad3;">

               <a class="dropdown-item" style="color:white" href="{{ url('Manage/directorate')}}">College/Directorates</a>
               <a style="color:white" class="dropdown-item" href="{{ url('Manage/department')}}">Departments</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/locations')}}">Locations</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Areas')}}">Areas</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Blocks')}}">Blocks</a>   
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Rooms')}}">Rooms</a>

               <a style="color:white" class="dropdown-item" href="{{ url('Manage/IoWZones/with/iow')}}">Zones</a>


        </div>
       </li>


        <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>


            <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('stores')}}">Store<span
                                    class="badge badge-light">{{ count($m) }}</span></a>
            </li>


             <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('assetsManager')}}">Assets</a>
            </li>


             <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Assessment/form')}}">Cleaning Services</a>
            </li>





                 @endif


                @if(auth()->user()->type == 'Accountant')
                <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Assessment/form')}}">Cleaning Services</a>
                </li>
                @endif




                            @if(auth()->user()->type == 'USAB')





                <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Assessment/form')}}">Cleaning Services</a>
                </li>



              @endif








            </ul>



    <span class="navbar-text">
      <ul class="navbar-nav mr-auto">

        <?php use App\usertype;
         $usertypes = usertype::where('user_id', auth()->user()->id)->get();

        $check = auth()->user()->id; ?>
           @foreach($usertypes as $type)

            @if($type->type2 == NULL)
            @else

              <form action="{{route('changeusertype' , [$check])}}" method="POST">
                   @csrf
             <div >
              @foreach($usertypes as $type)
               <select style="background-color: #376ad3; color: white;font-weight:bold;margin-top: 8px; " name="usertype" onchange="this.form.submit();">
                 <option>Role</option>
                 <option value="{{$type->type}}"> {{$type->type}}</option>
                 <option value="{{$type->type2}}">{{$type->type2}}</option>
                </select>
              @endforeach
             </div>
             </form>

             @endif

             @endforeach


             <li class="nav-item">
              <a class="nav-link text-light" href="{{route('downloads')}}"> Documents </a>
              </li>

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
                    <div class="dropdown-menu dropdown-menu-right" style="background-color: #376ad3; color: white;"  aria-labelledby="navbarDropdown">
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








<div  class="container">







<?php
use App\Technician;
use App\User;
use App\Directorate;
use App\Department;
use App\Section;
 ?>

 <?php  $directoratenew = Directorate::where('name','<>',null)->OrderBy('name','ASC')->get(); ?>  

 @if($role['user_role']['role_id'] == 1)
<br>
<div class="row container-fluid" >
  <div class="col">
    <h5 style=" text-transform: capitalize;">Available Registered Users - <b> Directorate of Estates Services</b></h5>


  </div>

  {{--<div class="col-md-5">
    <form class="form-inline my-2 my-lg-0">
      <input style="width:220px;" class="form-control mr-sm-2" type="search" placeholder="Search by Fullname, email" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>--}}
</div>
  @if(Session::has('message'))
    <br>
    <p class="alert alert-success">{{ Session::get('message') }}</p>
  @endif

  @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger" style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><?php echo $error; ?></li>
                @endforeach
            </ul>
        </div>
    @endif

<hr>





    <div>


  <div class="row">
     <div class="col-md-5">
    <a style="margin-left: 2%;" href="{{ route('createUserView') }}">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new user</button></a>
  </div>
  <div class="col-md-3" align="right">


</div>
@if(!$display_users->isEmpty())

<!-- SOMETHING STRANGE HERE -->

<div class="col">
    <a href="" data-toggle="modal" class="btn btn-primary mb-2" data-target="#exampleModals"> Filter Users</a>
 </div>
 {{--  --}}
 <div class="modal fade" id="exampleModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter Users </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{--  --}}
        <form action="{{route('usersfiltered')}}" method="get">
            <p class="card-text">
                <a href="{{ url('viewusers')}}" class="btn btn-primary" type="button">All Users</a>
                <div class="form-group">
                    <label for="my-input">Filter By School/College/Directorate</label>
         <select  style="color: black; " class="custom-select" name="col" id="directorate" onchange="getDepartments()" value="{{ old('directorate') }}">
                <option selected="selected" value="">Select Directorate</option>
                <option selected value="" >All Directorates</option>
              @foreach($directoratenew as $directorate)
              <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
              @endforeach
            </select>
                </div>
                <div class="form-group">
                    <label for="my-input">Filter By Department</label>
                 <select  style="color: black;"  class="custom-select" name="dep" id="department"  value="{{ old('department') }}">
                 <option selected value="" >All Directorates</option>
            </select>
                    </select>
                </div>
                <div class="form-group">
                    <label for="my-input">Filter By User Type</label>
                    <select id="my-select" class="custom-select" name="typ">
                        <option value="">All Types</option>
                        <?php
                            $allofem = User::select('type')->distinct()->where('type','<>','')->orderBy('type','ASC')->get();
                            foreach($allofem as $alls){?>
                              <option value="{{$alls->type}}">{{$alls->type}}</option>
                            <?php }?>

                    </select>
                </div>
            </p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Filter </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </form>
      </div>
    </div>
  </div>
 {{--  --}}
                <div class="col" align="right">
           <a href="" data-toggle="modal" class="btn btn-primary mb-2" data-target="#exampleModal"> Export <i class="fa fa-file-pdf-o"></i></a>
        </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('userpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="college" class="form-control mr-sm-2">
                    <option selected="selected" value="">Select name</option>
                    <option value="">All users</option>
        <?php
                 $userfetch = user::get();
  foreach($userfetch as $userfetch)
  {



      $departmentor = department::where('id',$userfetch->section_id)->get();
      foreach($departmentor as $departmentor)
      {

          $directora = directorate::where('id',$departmentor->directorate_id)->get();
          foreach($directora as $directora){?>
<option value="{{ $userfetch->id }}">{{ $userfetch->fname }} {{ $userfetch->mid_name }} {{ $userfetch->lname }} - ( {{ $departmentor->name }}, {{ $directora->name }})</option>
          <?php }
      }


  }
        ?>


                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="type" class="form-control mr-sm-2">
                    <option selected="selected" value="">Select Type</option>
                    <option value="">All Types</option>
                    <?php
                    $type = User::select('type')->distinct()->get();
                    foreach ($type as $typed) {
                      echo " <option  value='".$typed->type."'>".$typed->type."</option>";
                    }
                   ?>

                </select>
            </div>
        </div>
      </div>

      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="directorate" class="form-control mr-sm-2">
                    <option selected="selected" value="">Select Directorate</option>
                    <option value="">All Directorates</option>
                    <?php

                    $directoras = directorate::orderBy('name','ASC')->get();
                    foreach($directoras as $directoras){?>
            <option value=" {{ $directoras->id }}">{{ $directoras->name }}</option>
                    <?php }
                               ?>

                </select>
            </div>
        </div>
      </div>

      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="department" class="form-control mr-sm-2">
                    <option selected="selected" value="">Select Department</option>
                    <option value="">All Departments</option>
                    <?php
                    $departmen  = department::orderBy('name','ASC')->get();
    foreach($departmen  as $departm )
    {

        $director  = directorate::where('id',$departm ->directorate_id)->get();
        foreach($director  as $director ){?>
<option value="{{ $departm ->id }} ">  {{ $departm ->description }} - {{ $director ->name }}</option>
        <?php }
    }
                   ?>

                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Export</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->
  </div>

<table class="table table-responsive  table-striped" id="myTablee" >
  <thead style="background-color: #376ad3" >
    <tr style="color: white;">
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th title="phone" scope="col">Phone</th>
      <th scope="col">Type</th>
    <th scope="col">Directorate</th>
      <th scope="col">Department</th>
      <!--<th scope="col">Section</th>-->
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php

 if (isset($_GET['page'])){
if ($_GET['page']==1){

  $i=1;
}else{
  $i = ($_GET['page']-1)*5+1; }
}
else {
 $i=1;
}
 $i=1;

   ?>
    @foreach($display_users as $user)
    @if ($user['department']['directorate']->name=='DES')



    <tr>
      <th scope="row">{{ $i++ }}</th>
      <td>{{ $user->fname . ' '.$user->mid_name.' ' . $user->lname }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>

      <?php $phonenumber = $user->phone;
        if(substr($phonenumber,0,1) == '0'){

          $phonreplaced = ltrim($phonenumber,'0');
          echo '+255'.$phonreplaced;

        }else { echo $user->phone;}

      ?></td>

      @if( $user->type == "Inspector Of Works")
      <td style="text-transform: capitalize;">{{ $user->type }} ,  @if( $user->IoW == 2) <h7 style="color: green;" >{{ $user->zone }}</h7>@elseif( $user->IoW == 1 ) <h7 style="color: red;" >{{ $user->zone }}</h7> @endif</td>

      @else
         @if(strpos( $user->type, "HOS") !== false)
             <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($user->type), 4, 14)?> </td>
             @else
               <td style="text-transform: capitalize;">{{strtolower( $user->type) }} </td>
             @endif

      @endif


         <td>{{ $user['department']['directorate']->name }}</td>
        <td>{{ $user['department']->name }}</td>
        <td>
        <div class="row"> &nbsp; &nbsp; &nbsp;
        <a style="color: green;" href="{{ route('user.edit.view', [$user->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>  &nbsp;


         <form  method="POST" onsubmit="return confirm('Are you sure you want to deactivate {{ $user->fname . ' '.$user->mid_name.' ' . $user->lname }}?')" action="{{ route('user.delete', [$user->id]) }}" >
          {{csrf_field()}}


        <button type="submit" data-toggle="tooltip" title="Deactivate"   > <a style="color: red;" href=""  data-toggle="tooltip" ><i class="fas fa-trash-alt"></i></a>


       </button>
     </form>
   </div>
      </td>
    </tr>
    @else
    @endif
    @endforeach
  </tbody>


</table>

</div>
  @endif

  @endif
</div>








<script>
$(document).ready(function(){

  $('[data-toggle="tooltip"]').tooltip();



$('#myTable').DataTable({
   "drawCallback": function ( settings ) {

    /*show pager if only necessary
    console.log(this.fnSettings());*/
    if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
        $('#dataTable_ListeUser_paginate').css("display", "block");
    } else {
        $('#dataTable_ListeUser_paginate').css("display", "none");
    }

    }
});


  jQuery('#myTable').DataTable({
    fnDrawCallback: function(oSettings) {
        var totalPages = this.api().page.info().pages;
        if(totalPages == 1){
            jQuery('.dataTables_paginate').hide();
        }
        else {
            jQuery('.dataTables_paginate').show();
        }
    }
});



});


function warning (){
  alert("Are you sure you want to delete this?");
}
</script>








</div>


<style type="text/css">
    html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .form-control{


                font-weight: bold;
            }


            .custom-select{


                font-weight: bold;
            }


            td{
                font-weight: bold;

            }



}

            .dataTables_filter {

     padding: 0;
          margin: 0px;
          width:999px;
           align-items: right;

}




            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

.top-dropdown{
    background-color: #676464;
}


.dropdown-item:hover{
    background-color: #046475;
}

.navbar-nav > .nav-item > .nav-link:hover{
    color: white;
}

#login-view{
    background-color: rgba(66, 62, 62, 0.79);
    border-radius: 10px;
    padding: 20px;
    color: white;
    position: absolute;
    right: 33%;
    bottom: 25%;
}

#login-viewold{
    background-color: #423e3e;
    padding: 20px;
    color: white;
    position: absolute;
    right: 33%;
    bottom: 25%;
    border-radius: 10px;
}

.estate-title{
    position: absolute;
    right: 6%;
    top: 10%;
    font-size: 50px;
}


hr {
  margin-top: 0rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 5px solid rgb(169,169,169);
}

/* Style the tab */
div.tab {
    overflow: hidden;
}

.tab-group{
    border-bottom: 1px solid #cccccc;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    outline: none;
    cursor: pointer;
    width: 240px;
    padding: 14px 16px;
    transition: 0.3s;
    color: #cccccc;
    border: none;
    font-weight: bold;
    font-size: small;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    color: black;
}

/* Create an active/current tablink class */
div.tab button.active {
    color: black;
    border-bottom: 2px solid #cccccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    margin-top: 50px;
}

.tabcontent {
    -webkit-animation: fadeEffect 1s;
    animation: fadeEffect 1s; /* Fading effect takes 1 second */
}

.dataTables_filter {
   width: 80%;
   float: right;
padding: 20px 60px;
   text-align: right;
}

#wo-details{
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    /*line-height: 16px;     !* fallback *!*/
    /*max-height: 32px;      !* fallback *!*/
    -webkit-line-clamp: 3; /* number of lines to show */
}




    table {

            font: 17px Calibri;
        }
        table, th, td {
            border: solid 1px #DDD;
            border-collapse: collapse;
            padding: 2px 3px;

        }

tr {
 width:12px;
}

thead{
      background-color: #376ad3;
}
tr{



}

img {
  object-fit: cover;
  width:250px;
  height:250px;
}

</style>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>

<script type="text/javascript" src="{{asset('/tables/jQuery-3.3.1/jquery-3.3.1.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/Bootstrap-4-4.1.1/js/bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/JSZip-2.5.0/jszip.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/pdfmake-0.1.36/pdfmake.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/pdfmake-0.1.36/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/DataTables-1.10.21/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/DataTables-1.10.21/js/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/Buttons-1.6.2/js/dataTables.buttons.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/Buttons-1.6.2/js/buttons.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/Buttons-1.6.2/js/buttons.html5.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/Buttons-1.6.2/js/buttons.print.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/SearchPanes-1.1.1/js/dataTables.searchPanes.js')}}"></script>
<script type="text/javascript" src="{{asset('/tables/SearchPanes-1.1.1/js/searchPanes.bootstrap4.js')}}"></script>
<script src="{{ asset('/js/main.js') }}"></script>

<script>
    $('#myTable').DataTable();
    $('#myTablee').DataTable();
    $('#myTableee').DataTable();
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


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

      $("#directoraterr").select2({
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

      $("#departmentrr").select2({
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
            placeholder: "Choose technician for work...",
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

<script type="text/javascript">

      $("#secondtype").select2({
            placeholder: "Choose second user type...",
            allowClear: true
        });
</script>






</body>
</html>












  <script>
    document.onreadystatechange = function() {
      if (document.readyState !== "complete") {
        document.querySelector(
        "body").style.visibility = "hidden";
        document.querySelector(
        "#loader").style.visibility = "visible";
      } else {
        document.querySelector(
        "#loader").style.display = "none";
        document.querySelector(
        "body").style.visibility = "visible";
      }
    };
  </script>
</body>

</html>


<script type="text/javascript">
  document.onreadystatechange = function() {
  if (document.readyState !== "complete") {
    document.querySelector("body").style.visibility = "hidden";
    document.querySelector("#loader").style.visibility = "visible";
  } else {
    document.querySelector("#loader").style.display = "none";
    document.querySelector("body").style.visibility = "visible";
  }
};

</script>


<script type="text/javascript">
  

var selecteddep = null;
var selectedsection = null;

function getDepartments() {
    selecteddep = document.getElementById('directorate').value;

    console.log('ID: ' + selecteddep);
    $.ajax({
            method: 'GET',
            url: 'departments/',
            data: { id: selecteddep }
        })
        .done(function(msg) {
            console.log(msg['departments']);
            var object = JSON.parse(JSON.stringify(msg['departments']));
            $('#department').empty();

            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('department').appendChild(option);




            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].description;
                option.value = object[i].id;
                document.getElementById('department').appendChild(option);
            }
        });
}



</script>

