@extends('layouts.asset')

@section('title')
Assets Management
    @endSection

@section('body')
@php

use App\assetsland;
use App\assetsbuilding;
use App\assetscomputerequipment;
use App\assetsequipment;
use App\assetsfurniture;
use App\assetsintangible;
use App\assetsmotorvehicle;
use App\assetsplantandmachinery;
use App\assetsworkinprogress;

$land = assetsland::get();
$building = assetsbuilding::get();
$computerequipment = assetscomputerequipment::get();
$equipment = assetsequipment::get();
$furniture = assetsfurniture::get();
$intangible = assetsintangible::get();
$motorvehicle = assetsmotorvehicle::get();
$plantmachinery = assetsplantandmachinery::get();
$workinprogress = assetsworkinprogress::get();

@endphp
@if (($role['user_role']['role_id'] == 1)||(auth()->user()->type =='Assets Officer'))
      
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Assets Management</b></h5>
        </div>
    </div>
    <hr class="container">
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ Session::get('message') }}</li>
                </ul>
            </div>
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

        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-text">
                    <div class="row">
                            <a href="{{url('assetsNewLand')}}" class="btn col btn-outline-dark" type="button"><b>Add new Land asset</b></a>
&nbsp;&nbsp;
                            <a href="{{url('assetsNewFurniture')}}" class="btn col btn-outline-dark" type="button"><b>Add new Furniture asset</b></a>

                    </div><br>
                    <div class="row">
                            <a href="{{url('assetsNewEquipment')}}" class="btn col btn-outline-dark" type="button"><b>Add new Equipment asset</b></a>
                            &nbsp;&nbsp;
                            <a href="{{url('assetsNewPlantMachinery')}}" class="btn col btn-outline-dark" type="button"><b>Add new Plant & Machinery asset</b></a>

                    </div><br>
                    <div class="row">
                            <a href="{{url('assetsNewMotorVehicle')}}" class="btn col btn-outline-dark" type="button"><b>Add new Motor Vehicle asset</b></a>
                            &nbsp;&nbsp;
                            <a href="{{url('assetsNewComputerEquipment')}}" class="btn col btn-outline-dark" type="button"><b>Add new Computer Equipment asset</b></a>

                    </div><br>
                    <div class="row">
                            <a href="{{url('assetsNewBuilding')}}" class="btn col btn-outline-dark" type="button"><b>Add new Building asset</b></a>
                            &nbsp;&nbsp;
                            <a href="{{url('assetsNewIntangible')}}" class="btn col btn-outline-dark" type="button"><b>Add new Intangible asset</b></a>

                    </div><br>
                    <div class="row">
                            <a href="{{url('assetsNewWorkinProgress')}}" class="btn col-md-6 btn-outline-dark" type="button"><b>Add new Work in Progress</b></a>

                    </div>
                </div>
            </div>
        </div>
        <br>
</div>
<br>
@endif
<div class="container">
    <br>
    <div class="card">
        <div class="card-header">
          Assets Summary
        </div>
    </div>

        <div class="card">
            <div class="card-body">
                <p class="card-text">
                    <table class="table table-striped display" id="myTable" style="width:100%">
                        <thead  >
                            <tr style="color:white;">
                                <th>#</th>
                                <th>Asset Group</th>
                                <th>New</th>
                                <th>Good</th>
                                <th>Fair</th>
                                <th>Poor</th>
                                <th>Very Poor</th>
                                <th>Obsolete</th>
                                <th>Disposed</th>
                                <th>Sold</th>
                                <th>Expiring Soon</th>
                                <th>Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Building Assets</td>
                                @php
                                    $build = assetsbuilding::where('_condition','New')->get();
                                    $build2 = assetsbuilding::where('_condition','Good')->get();
                                    $build3 = assetsbuilding::where('_condition','Fair')->get();
                                    $build4 = assetsbuilding::where('_condition','Poor')->get();
                                    $build5 = assetsbuilding::where('_condition','Very Poor')->get();
                                    $build6 = assetsbuilding::where('_condition','Obsolete')->get();
                                    $build7 = assetsbuilding::where('_condition','Disposed')->get();
                                    $build8 = assetsbuilding::where('_condition','Sold')->get();
                                    $build10 = assetsbuilding::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                    $build9 = assetsbuilding::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();

                                @endphp
                                <td>
                                @if (count($build)>0)
                                        {{count($build)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build2)>0)
                                        {{count($build2)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build3)>0)
                                        {{count($build3)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build4)>0)
                                        {{count($build4)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build5)>0)
                                        {{count($build5)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build6)>0)
                                        {{count($build6)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build7)>0)
                                        {{count($build7)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build8)>0)
                                        {{count($build8)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build10)>0)
                                        {{count($build10)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($build9)>0)
                                        {{count($build9)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($build9)}}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Computer Equipment Assets</td>
                                @php
                                $computerequipment = assetscomputerequipment::where('_condition','New')->get();
                                $computerequipment2 = assetscomputerequipment::where('_condition','Good')->get();
                                $computerequipment3 = assetscomputerequipment::where('_condition','Fair')->get();
                                $computerequipment4 = assetscomputerequipment::where('_condition','Poor')->get();
                                $computerequipment5 = assetscomputerequipment::where('_condition','Very Poor')->get();
                                $computerequipment6 = assetscomputerequipment::where('_condition','Obsolete')->get();
                                $computerequipment7 = assetscomputerequipment::where('_condition','Disposed')->get();
                                $computerequipment8 = assetscomputerequipment::where('_condition','Sold')->get();
                                $computerequipment9 = assetscomputerequipment::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                                $computerequipment10 = assetscomputerequipment::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();

                            @endphp
                                   <td>
                                    @if (count($computerequipment)>0)
                                            {{count($computerequipment)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment2)>0)
                                            {{count($computerequipment2)}}
                                            &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment2)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment3)>0)
                                            {{count($computerequipment3)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment3)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment4)>0)
                                            {{count($computerequipment4)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment4)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment5)>0)
                                            {{count($computerequipment5)}}
                                            &nbsp;<a href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment5)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment6)>0)
                                            {{count($computerequipment6)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment6)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment7)>0)
                                            {{count($computerequipment7)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment7)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment8)>0)
                                            {{count($computerequipment8)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment8)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment10)>0)
                                            {{count($computerequipment10)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment10)}}
                                    @endif
                                    </td>
                                    <td>
                                        @if (count($computerequipment9)>0)
                                            {{count($computerequipment9)}}
                                            &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=computerequipments&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                        @else
                                            {{count($computerequipment9)}}
                                    @endif
                                    </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Equipment Assets</td>
                                @php
                                $equipment = assetsequipment::where('_condition','New')->get();
                                $equipment2 = assetsequipment::where('_condition','Good')->get();
                                $equipment3 = assetsequipment::where('_condition','Fair')->get();
                                $equipment4 = assetsequipment::where('_condition','Poor')->get();
                                $equipment5 = assetsequipment::where('_condition','Very Poor')->get();
                                $equipment6 = assetsequipment::where('_condition','Obsolete')->get();
                                $equipment7 = assetsequipment::where('_condition','Disposed')->get();
                                $equipment8 = assetsequipment::where('_condition','Sold')->get();
                                $equipment10 = assetsequipment::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                $equipment9 = assetsequipment::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                            @endphp
                                                                <td>
                                @if (count($equipment)>0)
                                        {{count($equipment)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment2)>0)
                                        {{count($equipment2)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment3)>0)
                                        {{count($equipment3)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment4)>0)
                                        {{count($equipment4)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment5)>0)
                                        {{count($equipment5)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment6)>0)
                                        {{count($equipment6)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment7)>0)
                                        {{count($equipment7)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment8)>0)
                                        {{count($equipment8)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment10)>0)
                                        {{count($equipment10)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($equipment9)>0)
                                        {{count($equipment9)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=equipments&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($equipment9)}}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Furniture Assets</td>
                                @php
                                $furniture = assetsfurniture::where('_condition','New')->get();
                                $furniture2 = assetsfurniture::where('_condition','Good')->get();
                                $furniture3 = assetsfurniture::where('_condition','Fair')->get();
                                $furniture4 = assetsfurniture::where('_condition','Poor')->get();
                                $furniture5 = assetsfurniture::where('_condition','Very Poor')->get();
                                $furniture6 = assetsfurniture::where('_condition','Obsolete')->get();
                                $furniture7 = assetsfurniture::where('_condition','Disposed')->get();
                                $furniture8 = assetsfurniture::where('_condition','Sold')->get();
                                $furniture10 = assetsfurniture::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                $furniture9 = assetsfurniture::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                            @endphp
                                                               <td>
                                @if (count($furniture)>0)
                                        {{count($furniture)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture2)>0)
                                        {{count($furniture2)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture3)>0)
                                        {{count($furniture3)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture4)>0)
                                        {{count($furniture4)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture5)>0)
                                        {{count($furniture5)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture6)>0)
                                        {{count($furniture6)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture7)>0)
                                        {{count($furniture7)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture8)>0)
                                        {{count($furniture8)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture10)>0)
                                        {{count($furniture10)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($furniture9)>0)
                                        {{count($furniture9)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=furniture&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($furniture9)}}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Intangible Assets</td>
                                @php
                                $intangible = assetsintangible::where('_condition','New')->get();
                                $intangible2 = assetsintangible::where('_condition','Good')->get();
                                $intangible3 = assetsintangible::where('_condition','Fair')->get();
                                $intangible4 = assetsintangible::where('_condition','Poor')->get();
                                $intangible5 = assetsintangible::where('_condition','Very Poor')->get();
                                $intangible6 = assetsintangible::where('_condition','Obsolete')->get();
                                $intangible7 = assetsintangible::where('_condition','Disposed')->get();
                                $intangible8 = assetsintangible::where('_condition','Sold')->get();
                                $intangible10 = assetsintangible::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                $intangible9 = assetsintangible::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                            @endphp
                                                               <td>
                                @if (count($intangible)>0)
                                        {{count($intangible)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible2)>0)
                                        {{count($intangible2)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible3)>0)
                                        {{count($intangible3)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible4)>0)
                                        {{count($intangible4)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible5)>0)
                                        {{count($intangible5)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible6)>0)
                                        {{count($intangible6)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible7)>0)
                                        {{count($intangible7)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible8)>0)
                                        {{count($intangible8)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible10)>0)
                                        {{count($intangible10)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($intangible9)>0)
                                        {{count($intangible9)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=intangible&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($intangible9)}}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Land Assets</td>
                                @php
                                $land = assetsland::where('_condition','New')->get();
                                $land2 = assetsland::where('_condition','Good')->get();
                                $land3 = assetsland::where('_condition','Fair')->get();
                                $land4 = assetsland::where('_condition','Poor')->get();
                                $land5 = assetsland::where('_condition','Very Poor')->get();
                                $land6 = assetsland::where('_condition','Obsolete')->get();
                                $land7 = assetsland::where('_condition','Disposed')->get();
                                $land8 = assetsland::where('_condition','Sold')->get();
                                $land10 = assetsland::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                $land9 = assetsland::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                            @endphp
                                                                <td>
                                @if (count($land)>0)
                                        {{count($land)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land2)>0)
                                        {{count($land2)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land3)>0)
                                        {{count($land3)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land4)>0)
                                        {{count($land4)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land5)>0)
                                        {{count($land5)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land6)>0)
                                        {{count($land6)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land7)>0)
                                        {{count($land7)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land8)>0)
                                        {{count($landd8)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land10)>0)
                                        {{count($land10)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($land9)>0)
                                        {{count($land9)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=land&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($land9)}}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Motor Vehicle Assets</td>
                                @php
                                $motorvehicle = assetsmotorvehicle::where('_condition','New')->get();
                                $motorvehicle2 = assetsmotorvehicle::where('_condition','Good')->get();
                                $motorvehicle3 = assetsmotorvehicle::where('_condition','Fair')->get();
                                $motorvehicle4 = assetsmotorvehicle::where('_condition','Poor')->get();
                                $motorvehicle5 = assetsmotorvehicle::where('_condition','Very Poor')->get();
                                $motorvehicle6 = assetsmotorvehicle::where('_condition','Obsolete')->get();
                                $motorvehicle7 = assetsmotorvehicle::where('_condition','Disposed')->get();
                                $motorvehicle8 = assetsmotorvehicle::where('_condition','Sold')->get();
                                $motorvehicle10 = assetsmotorvehicle::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                $motorvehicle9 = assetsmotorvehicle::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                            @endphp
                                                                <td>
                                @if (count($motorvehicle)>0)
                                        {{count($motorvehicle)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle2)>0)
                                        {{count($motorvehicle2)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle3)>0)
                                        {{count($motorvehicle3)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle4)>0)
                                        {{count($motorvehicle4)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle5)>0)
                                        {{count($motorvehicle5)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle6)>0)
                                        {{count($motorvehicle6)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle7)>0)
                                        {{count($motorvehicle7)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle8)>0)
                                        {{count($motorvehicle8)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle10)>0)
                                        {{count($motorvehicle10)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle9)>0)
                                        {{count($motorvehicle9)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle9)}}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Plant and Machinery Assets</td>
                                @php
                                $plantandmachinery = assetsplantandmachinery::where('_condition','New')->get();
                                $plantandmachinery2 = assetsplantandmachinery::where('_condition','Good')->get();
                                $plantandmachinery3 = assetsplantandmachinery::where('_condition','Fair')->get();
                                $plantandmachinery4 = assetsplantandmachinery::where('_condition','Poor')->get();
                                $plantandmachinery5 = assetsplantandmachinery::where('_condition','Very Poor')->get();
                                $plantandmachinery6 = assetsplantandmachinery::where('_condition','Obsolete')->get();
                                $plantandmachinery7 = assetsplantandmachinery::where('_condition','Disposed')->get();
                                $plantandmachinery8 = assetsplantandmachinery::where('_condition','Sold')->get();
                                $plantandmachinery10 = assetsplantandmachinery::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                $plantandmachinery9 = assetsplantandmachinery::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                            @endphp
                                                                <td>
                                @if (count($plantandmachinery)>0)
                                        {{count($plantandmachinery)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery2)>0)
                                        {{count($plantandmachinery2)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery3)>0)
                                        {{count($plantandmachinery3)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery4)>0)
                                        {{count($plantandmachinery4)}}
                                        &nbsp;<a  title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery5)>0)
                                        {{count($plantandmachinery5)}}
                                        &nbsp;<a title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery6)>0)
                                        {{count($plantandmachinery6)}}
                                        &nbsp;<a title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery7)>0)
                                        {{count($plantandmachinery7)}}
                                        &nbsp;<a title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery8)>0)
                                        {{count($plantandmachinery8)}}
                                        &nbsp;<a title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery10)>0)
                                        {{count($plantandmachinery10)}}
                                        &nbsp;<a title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($plantandmachinery9)>0)
                                        {{count($plantandmachinery9)}}
                                        &nbsp;<a title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=plantandmachinery&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($plantandmachinery9)}}
                                @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </p>
            </div>
        </div>
<hr>
    <div class="card">
        <div class="card-body">
            <p class="card-text">
                <p>
                    <a href="{{route('assetssummaryall')}}" class="btn btn-primary" id="btnExport" > Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    </p>
                    <table class="table table-striped display" id="myTable" style="width:100%">
                        <thead  >
                            <tr style="color:white;">
                                <th>#</th>
                                <th>Asset Group</th>
                                <th>Total</th>
                                <th>Asset Value</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Building Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @foreach ($building as $buildings)
                                     @php   $total1 = $total1 +1; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php $total2 = 0; @endphp
                                    @foreach ($building as $buildingd)
                                    @php $total2 =  $total2 +$buildingd->Cost; @endphp
                                    @endforeach
                                    @php echo number_format($total2); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsBuilding')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Computer Equipment Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @foreach ($computerequipment as $computerequipments)
                                     @php   $total1 =  1+$total1; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php $total2 = 0; @endphp
                                    @foreach ($computerequipment as $computerequipment)
                                    @php $total2 = $total2 +$computerequipment->Cost; @endphp
                                    @endforeach
                                    @php echo number_format($total2); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsComputerEquipment')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Equipment Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @foreach ($equipment as $equipments)
                                     @php   $total1 =  1+$total1; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php $total3 = 0; @endphp
                                    @foreach ($equipment as $equipmentd)
                                    @php $total3 =  $total3+$equipmentd->Cost; @endphp
                                    @endforeach
                                    @php echo number_format($total3); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsEquipment')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Furniture Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @php $total4 = 0; @endphp
                                    @foreach ($furniture as $furnitures)
                                     @php   $total1 =  1+$total1; @endphp
                                     @php $total4 =$total4  +$furnitures->Cost; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php echo number_format($total4); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsFurniture')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Intangible Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @php $total5 = 0; @endphp
                                    @foreach ($intangible as $intangibles)
                                     @php   $total1 =  1+$total1; @endphp
                                     @php $total5 = $total5 +$intangibles->Cost; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php echo number_format($total5); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsIntangible')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Land Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @php $total6 = 0; @endphp
                                    @foreach ($land as $land)
                                     @php   $total1 =  1+$total1; @endphp
                                     @php $total6 = $total6 +$land->Cost; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php echo number_format($total6); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsLand')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Motor Vehicle Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @php $total7 = 0; @endphp
                                    @foreach ($motorvehicle as $motorvehicle)
                                     @php   $total1 =  1+$total1; @endphp
                                     @php $total7 = $total7 +$motorvehicle->Cost; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php echo number_format($total7); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsMotorVehicle')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Plant and Machinery Assets</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @php $total8 = 0; @endphp
                                    @foreach ($plantmachinery as $plantmachinery)
                                     @php   $total1 =  1+$total1; @endphp
                                     @php $total8 =  $total8+$plantmachinery->Cost; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td  style="text-align:right;">
                                    @php echo number_format($total8); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsPlantMachinery')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Work in Progress</td>
                                <td style="text-align:right;">
                                    @php $total1 = 0; @endphp
                                    @php $total9 = 0; @endphp
                                    @foreach ($workinprogress as $workinprogress)
                                     @php   $total1 =  1+$total1; @endphp
                                     @php $total9 = $total9  +$workinprogress->Cost; @endphp
                                    @endforeach
                                    @php echo $total1; @endphp
                                </td>
                                <td style="text-align:right;">
                                    @php echo number_format($total9); @endphp
                                </td>
                                <td>
                                <a style="margin-left: 50%" class="btn btn-primary" title="view" href="{{route('assetsWorkinProgress')}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="text-right thead-light text-bold">
                                <th>TOTAL</th>
                                <th></th>
                                <th id="totalhere"></th>
                                <th  style="text-align:right;">
                                    @php
                                        $total10 = $total1+$total2+$total3+$total4+$total5+$total6+$total7+$total8+$total9;

                                        echo number_format($total10);
                                    @endphp   </th>
                                    <th></th>
                            </tr>
                        </tfoot>
                    </table>
            </p>
        </div>
    </div>
</div>
<script>
   var sum1 = 0;
    $("#myTable tr").not(':first').not(':last').each(function() {


    sum1 +=  getnum($(this).find("td:eq(2)").text());
   function getnum(t){
       if(isNumeric(t)){
           return parseInt(t,10);
       }
       return 0;
        function isNumeric(n) {
          return !isNaN(parseFloat(n)) && isFinite(n);
    }
   }
   });
   $("#totalhere").text(sum1);

   //

</script>
@endSection
