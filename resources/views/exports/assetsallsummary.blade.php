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
<style>
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
</style>
<center>
    <h1>University of Dar es salaam</h1>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">

    <h3>Directorate of Estates Services</h3>
</center>
<hr>
<p>All Assets Summary Report</p>


<table class="table table-striped display" id="myTable" style="width:100%">
    <thead style="text-transform: uppercase;">
        <tr>
            <th>#</th>
            <th>Asset Group</th>
            <th>Total</th>
            <th style="text-align:right;">Asset Value (Tshs)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Building Assets</td>
            <td>
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
            <td>
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
            <td>
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
            <td>
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
            <td>
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
            <td>
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
            <td>
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
            <td>
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
            <td>
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
