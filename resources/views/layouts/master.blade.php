<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- code mpya -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

    <!-- code mpya -->

    <link rel="stylesheet" href="/css/main.css">

</head>
<body>


<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">ESMIS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <b> <a class="nav-link" style="color:white" href="{{ url('dashboard')}}">Dashboard <span
                                    class="sr-only">(current)</span></a> </b>
                </li>
<?php 
                use App\WorkOrderMaterial;
				use App\PurchasingOrder;
                use App\WorkOrderTransport;
				
				
				$material_requests = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',0)->groupBy('work_order_id')->get();
                
				
				
                $wo_material_needed = WorkOrderMaterial::where('status', 0)->get();
                
                $wo_material_approved = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',3)->groupBy('work_order_id')->get();;
				$procurement_request = PurchasingOrder::select(DB::raw('work_order_id'))->where('status',0)->groupBy('work_order_id')->get();
                	$procurement_request_acceptedbyiow = PurchasingOrder::select(DB::raw('work_order_id'))->where('status',1)->groupBy('work_order_id')->get();
                
                $wo_transport = WorkOrderTransport::where('status',0)->get();
                
                
                ?>
                
                @if(auth()->user()->type == 'Estates Director')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('unattended_work_orders')}}">Unattended Work-orders</a>
                    </li>
                    
                    
                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('completed_work_orders')}}">Completed Work-orders</a>
                    </li>
                    
                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('roomreport')}}">Room report</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('woduration')}}">WO Duration</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('hoscount')}}">HOS count</a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('techniciancount')}}">Technician on progress count</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('techniciancountcomp')}}">Technician completed count</a>
                    </li>
                    
                @endif
                
                 @if(auth()->user()->type == 'Transport Officer')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('wo_transport_request')}}">Transport Requests <span
                                    class="badge badge-light">{{ count($wo_transport) }}</span></a>
                    </li>
                    
                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('wo_transport_request_accepted')}}">Accepted Transports</a>
                    </li>
                 <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('wo_transport_request_rejected')}}">Rejected Transports</a>
                    </li>   
                    
                    
                @endif
                
                @if(auth()->user()->type == 'STORE')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_approved_material')}}">Materials needed <span
                                    class="badge badge-light">{{ count($wo_material_approved) }}</span></a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_released_material')}}">All Requests </a>
                    </li>
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
                   @if(auth()->user()->type == 'Inspector Of Works')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_material_needed')}}">WO that needs material <span
                                    class="badge badge-light">{{ count($material_requests) }}</span></a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_material_accepted')}}">Accepted Work Orders</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_material_rejected')}}">Rejected Work Orders</a>
                    </li>
                    <!--
					 <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_purchasing_request')}}">Procurement Requests <span
                                    class="badge badge-light">{{ count($procurement_request) }}</span></a>
                    </li>
                    -->
                    
                @endif
                
                @if(auth()->user()->type != 'STORE')
                @if(auth()->user()->type != 'Transport Officer')
                @if(auth()->user()->type != 'Inspector Of Works')
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work order</a>
                </li>
                @ENDIF
                
                @ENDIF
                @ENDIF


                @if($role['user_role']['role_id'] == 1)
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('viewusers')}}">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('manage_directorates')}}">Manage
                            Directorates</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('stores')}}">Store</a>
                    </li>
                @endif

                @if(strpos(auth()->user()->type, "HOS") !== false)
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('technicians') }}">Manage Technicians</a>
                    </li>
					
					@if($role['user_role']['role_id'] != 1)
					 <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('storeshos')}}">Current Store</a>
                    </li>
					@endif
                @endif

                @if(auth()->user()->type == 'STORE')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('stores')}}">Store</a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Notifications <span class="badge badge-light">{{ count($notifications) }}</span></a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
            </ul>
            <span class="navbar-text">
      <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu top-dropdown" aria-labelledby="navbarDropdown">
           <!--SETTING AND CHANGE PASSWORD 
          <a class="dropdown-item" style="color:white" href="{{ url('settings')}}">Settings</a>-->

               <a class="dropdown-item" style="color:white" href="{{ url('myprofile')}}">My Profile</a>
          <a class="dropdown-item" href="{{ url('password')}}">Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}"
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
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
    </ul>
    </span>
            <!-- <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </nav>
    <div class="container">
        @yield('body')
    </div>
</div>
<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="{{ asset('/js/main.js') }}"></script>


<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>

    $('#myTable').DataTable();
    $('#myTablee').DataTable();
    $('#myTableee').DataTable();
</script>

</body>
</body>
</html>
