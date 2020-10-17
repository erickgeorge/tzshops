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
        label{
            font-weight: bold;
            color: #000;
        }
    </style>


    <style type="text/css">

input[type="date"]::-webkit-datetime-edit, input[type="date"]::-webkit-inner-spin-button, input[type="date"]::-webkit-clear-button {
  color: #fff;
  position: relative;
}

input[type="date"]::-webkit-datetime-edit-year-field{
  position: absolute !important;
  border-left:1px solid #8c8c8c;
  padding: 2px;
  color:#000;
  left: 56px;
}

input[type="date"]::-webkit-datetime-edit-month-field{
  position: absolute !important;
  border-left:1px solid #8c8c8c;
  padding: 2px;
  color:#000;
  left: 26px;

}


input[type="date"]::-webkit-datetime-edit-day-field{
  position: absolute !important;
  color:#000;
  padding: 2px;
  left: 4px;

}


</style>

<div>
    <nav class="navbar fixed-top navbar-expand-lg navbar-primary " style="border-bottom: #fff 2px solid; background-color:#376ad3;">


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
        use Carbon\Carbon;

        // closing work order by default
        $woclo = WorkOrder::where('status',2)->get();
        $leohii = Carbon::now();

        use App\Notification;

               $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        foreach ($woclo as $woclo) {
            $sikuhii = Carbon::parse($woclo->updated_at);
            $tofautihii = $sikuhii->diffInDays($leohii);

            if ($tofautihii > 6) {
                $wokioda = WorkOrder::where('id',$woclo->id)->first();
                $wokioda->status = 30;
                $wokioda->systemclosed = date('Y-m-d');
                $wokioda->save();
            }
        }
        //

                      use App\ppuproject;


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


                $material_requests = WorkOrderMaterial::where('zone', auth()->user()->id)->select(DB::raw('work_order_id'))->where('status',0)->groupBy('work_order_id')->get();


                 $material_requestsmc = WorkOrderMaterial::select(DB::raw('work_order_id'))->where('status',0)->groupBy('work_order_id')->get();
                $material_requests = WorkOrderMaterial::where('zone', auth()->user()->id)->
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


                @if(auth()->user()->type == 'Estates Director')
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>
                      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu dropdown-menu-right top-dropdown" aria-labelledby="navbarDropdown" style="background-color: #376ad3;">

             <a class="dropdown-item" style="color:white" href="{{ url('Manage/directorate')}}">Colleges/Directorate</a>
               <a style="color:white" class="dropdown-item" href="{{ url('Manage/department')}}">Department</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/locations')}}">Locations</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Areas')}}">Areas</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Blocks')}}">Blocks</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Rooms')}}">Rooms</a>

               <a style="color:white" class="dropdown-item" href="{{ url('Manage/IoWZones/with/iow')}}">Zones</a>



        </div>
       </li>


                    @endif
                    @if ((auth()->user()->type =='Maintenance coordinator')||(auth()->user()->type =='Housing Officer')||(auth()->user()->type =='USAB')||(auth()->user()->type =='DVC Admin')||(auth()->user()->type == 'Bursar')||(auth()->user()->type == 'Assets Officer'))
                    <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('assetsManager')}}">Assets</a>
            </li>
                    @endif
                    @if(((auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'DVC Admin')||auth()->user()->type == 'Director DPI')||(auth()->user()->type == 'Estates officer')||(auth()->user()->type == 'Architect & Draftsman')||(auth()->user()->type == 'Quality Surveyor'))

      <li class="nav-item">
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
                  @elseif(auth()->user()->type == 'Estates officer')
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
        </li>
       @endif

             <!--   @if(auth()->user()->type == 'DVC Admin')
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work orders  </a>
                    </li>
                @endif -->

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

                @if(auth()->user()->type == 'Acountant')
                <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('minutesheets')}}">Minutesheets</a>
                    </li>
                @endif

                @if(auth()->user()->type == 'STORE')
                 <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work orders  </a>
                    </li>

                   <!-- <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_approved_material')}}">Materials needed <span
                                    class="badge badge-light">{{ count($wo_material_approved) }}</span></a>
                    </li>-->

                    <!--<li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_released_material')}}">All Requests </a>
                    </li>-->

                       <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('material_received_with_workorder')}}" >Material Taken From Store <span
                                    class="badge badge-light">{{ count($material_used) }}</span></a>
                    </li>






                    <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('wo_material_reserved') }}" >Reserved Materials <span
                                    class="badge badge-light">{{ count($woMaterialreserved) }}</span></a>
                    </li> ``

                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('wo_material_accepted_by_iow')}}">Material requests<span
                                    class="badge badge-light">{{ count($wo_material_accepted_iow) }}</span></a>
                    </li>




                    <!--<li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('wo_material_purchased_by_head_of_procurement') }}" >Material Purchased <span
                                    class="badge badge-light">{{ count($wo_material_procured_by_iow) }}</span></a>
                    </li>-->


                    <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('work_order_material_purchased') }}" >Material Purchased <span
                                    class="badge badge-light">{{ count($material_to_purchased) }}</span></a>
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


                 @if(auth()->user()->type == 'Head Procurement')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_with_missing_material')}}">Materials to purchase <span
                                    class="badge badge-light">{{ count($material_to_estatedirector) }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('minutesheets')}}">Minutesheets</a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('stores')}}">Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color:white" ></a>
                    </li>

                    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
         Procurement
        </a>
        <div class="dropdown-menu dropdown-menu-right top-dropdown" aria-labelledby="navbarDropdown">

               <a class="dropdown-item" style="color:white" href=" {{ url('procurementAddMaterial') }}">Add new procurement list</a>
               <a class="dropdown-item" style="color:white" href="{{ url('ProcurementHistory') }}">View Procurement History</a>
               <a class="dropdown-item" style="color:white" href="">Send Materials to store</a>
        </div>
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
                   @if(auth()->user()->type == 'Inspector Of Works')

                    <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work orders  </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_material_needed')}}">Work order needs material <span
                                    class="badge badge-light">{{ count($material_requests) }}</span></a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('wo_material_accepted')}}">Accepted Materials<span
                                    class="badge badge-light">{{ count($woMaterialAccepted) }}</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('material_rejected_with_workorder')}}">Rejected Materials
                        <span
                                    class="badge badge-light">{{ count($woMaterialrejected) }}</span></a>
                    </li>


                    <!--
           <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('work_order_purchasing_request')}}">Procurement Requests <span
                                    class="badge badge-light">{{ count($procurement_request) }}</span></a>
                    </li>
                    -->

                @endif


                @if(auth()->user()->type == 'Estates Director')
 <!-- <li class="nav-item">
     <a href="{{ url('comp') }}" title="Complaints" style="color:white" class="nav-link"><i style="color: yellow;" class="fa fa-exclamation-triangle"></i>Complaints</a>
 </li> -->
 @elseif(auth()->user()->type == 'DVC Admin')
 <!-- <li class="nav-item">
     <a href="{{ url('comp') }}" title="Complaints" style="color:white" class="nav-link"><i style="color: yellow;" class="fa fa-exclamation-triangle"></i>Complaints</a>
 </li> -->
            <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>
 @endif
 @if(auth()->user()->type == 'Maintenance coordinator')

  <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work orders  </a>
  </li>



  <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('redirected_work_order')}}">Redirected Works order  </a>
  </li>

  <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('roomreport')}}">Room Report</a>
                    </li>
   <li class="nav-item">   <a href="{{ url('comp') }}" class="nav-link" style="color:white"><i style="color: yellow;" class="fa fa-exclamation-triangle"></i>Complaints</a>
 </li>

   <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('technicians') }}">Technicians</a>
   </li>


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Material Requests Update
        </a>
        <div class="dropdown-menu dropdown-menu-right top-dropdown" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" style="color:white" href="{{ url('work_order_material_needed')}}">Work order needs material <span
                                    class="badge badge-light">{{ count($material_requestsmc) }}</span></a>
                 <a  class="dropdown-item" style="color:white" href="{{ url('wo_material_accepted')}}">Accepted Materials<span
                                    class="badge badge-light">{{ count($woMaterialAccepted) }}</span></a>

               <a class="dropdown-item" style="color:white" href="{{ url('material_rejected_with_workorder')}}">Rejected Materials
                        <span
                                    class="badge badge-light">{{ count($woMaterialrejected) }}</span></a>



        </div>
       </li>



  @endif





                @if(strpos(auth()->user()->type, "HOS") !== false or $role['user_role']['role_id'] == 1)

                      <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Maintenance</a>
                    </li>




                @endif



                @if((auth()->user()->type == 'CLIENT')&&($role['user_role']['role_id'] != 1))
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work orders  </a>
                    </li>
               @endif


                @if(auth()->user()->type == 'STORE')
                    <li class="nav-item">
                        <a class="nav-link" style="color:white;" href="{{ url('stores')}}">Store <span
                                    class="badge badge-light">{{ count($m) }}</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" style="color: white;" href="{{ url('ProcurementHistory') }}">Procurement</a>
                    </li>
                @endif


              @if($role['user_role']['role_id'] == 1)

            <li class="nav-item">
                        <a class="nav-link" style="color:white" href="{{ url('stores')}}">Store<span
                                    class="badge badge-light">{{ count($m) }}</span></a>
            </li>



               <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('assetsManager')}}">Assets</a>
            </li>

             <li class="nav-item">
                        <a class="nav-link" style="color:white"  href="{{ url('Land/work_order')}}">Land Scapping</a>
            </li>


        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu dropdown-menu-right top-dropdown" aria-labelledby="navbarDropdown">

              <a class="dropdown-item" style="color:white" href="{{ url('Manage/directorate')}}">Colleges/Directorate</a>
               <a style="color:white" class="dropdown-item" href="{{ url('Manage/department')}}">Department</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/locations')}}">Locations</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Areas')}}">Areas</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Blocks')}}">Blocks</a>
                 <a style="color:white" class="dropdown-item" href="{{ url('Manage/Rooms')}}">Rooms</a>

               <a style="color:white" class="dropdown-item" href="{{ url('Manage/IoWZones/with/iow')}}">Zones</a>



        </div>
       </li>



                 @endif




            </ul>
            <span class="navbar-text">

      <ul class="navbar-nav mr-auto"><li class="nav-item">
        <a class="nav-link text-light" href="{{route('downloads')}}">Documents </a>
        </li>
        <li>
             @if($role['user_role']['role_id'] == 1)
                    <li class="nav-item">
                        <a class="nav-link" style="color:white " href="{{ url('usersoptions')}}">Users</a>
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
  text-decoration: none;
  top: 0;
  left: 0;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 4px 6px 4px 10px;
  text-decoration: none;
  display: block;
  border: none;
  text-decoration: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;





}

.sidenav button{
  color: white;
  text-decoration: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
  text-decoration: none;
}



.sidenav a {
  background-color: #c2bebe;
  color: white;
  text-decoration: none;





}

.sidenav a, .dropdown-btn, .sidenav button {
  color: #f1f1f1;
    margin-top: 2px;
    text-decoration: none;
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
  text-decoration: none;


}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: white;
  text-decoration: none;



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

<div class="sidenav bg-light" style="padding-top:90px;">

  <a class="bg-primary" href="{{ url('infrastructureproject')}}" >
    Infrastructure Projects <span class="badge badge-light">{{ count($statusPPU) }}</span>
</a>
  @if(auth()->user()->type == 'Architect & Draftsman')
  <a class="bg-primary" href="{{ url('ppudrawingslibrary')}}" >
    Drawings Library
</a>
    @endif
    @if(auth()->user()->type == 'Quality Surveyor')
  <a class="bg-primary" href="{{ url('ppubudgetlibrary')}}" >
    Budgets Library
</a>
    @endif
    <a class="bg-primary" href=" ">
        Tender Documents
    </a>
    <a class="bg-primary" href=" ">
        Consultant ToRs
    </a>
    <a class="bg-primary" href=" ">
        Reports
    </a>

</div>

<div class="main">
  @if(auth()->user()->change_password == 2)
        @yield('body')

     @endif
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


</body>
</html>
