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
@if ((auth()->user()->type =='Maintenance coordinator')||(auth()->user()->type =='Housing Officer')||(auth()->user()->type =='USAB')||(auth()->user()->type =='DVC Admin'))
        @else
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
        <div class="card-body">
            <p class="card-text">
                <p>
                    <a href="{{route('assetssummaryall')}}" class="btn btn-primary" id="btnExport" > Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    </p>
                    <table class="table table-striped display" id="myTable" style="width:100%">
                        <thead style="text-transform: uppercase;">
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
