@php

use App\assetsland;
use App\assetsbuilding;
use App\assetscomputerequipment;
use App\assetsequipment;
use App\assetsfurniture;
use App\assetsintangible;
use App\assetsmotorvehicle;
use App\assetsplantandmachinery;

use App\assetsassesbuilding;
use App\assetsassescomputerequipment;
use App\assetsassesequipment;
use App\assetsassesfurniture;
use App\assetsassesintangible;
use App\assetsassesland;
use App\assetsassesmotorvehicle;
use App\assetsassesplantandmachinery;

            if($_GET['asset']=='Intangible')
            {
                $asses = assetsassesintangible::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }else if($_GET['asset']=='Furniture')
            {
                $asses = assetsassesfurniture::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }else if($_GET['asset']=='Equipment')
            {
                $asses = assetsassesequipment::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }else if($_GET['asset']=='ComputerEquipment')
            {
                $asses = assetsassescomputerequipment::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }else if($_GET['asset']=='MotorVehicle')
            {
                $asses = assetsassesmotorvehicle::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }else if($_GET['asset']=='PlantMachinery')
            {
                $asses = assetsassesplantandmachinery::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }else if($_GET['asset']=='Building')
            {
                $asses = assetsassesbuilding::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }else if($_GET['asset']=='Land')
            {
                $asses = assetsassesland::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();
            }

@endphp
<title><?php  $time = strtotime($_GET['date'])?>
    LATEST {{strtoupper($_GET['asset'])}} ASSETS ASSESSMENT RECORDS</title>
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
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th colspan="18">
                <h1 style="text-transform: capitalize;">
                    UNIVERSITY OF DAR ES SALAAM - (UDSM)
                </h1>
            </th>
        </tr>

        <tr>
            <th colspan="18">
                <h1 style="text-transform: capitalize;">
                    DIRECTORATE OF ESTATES SERVICES
                </h1>
            </th>
        </tr>
        <tr>
            <th colspan="18">
                <h1 style="text-transform:uppercase;">
                    <?php  $time = strtotime($_GET['date'])?>
                    LATEST {{strtoupper($_GET['asset'])}} ASSETS ASSESSMENT RECORDS
                </h1>
            </th>
        </tr>
        <tr>
            <th> <b>S/N</b> </th>
            <th><b>Asset Number</b></th>
            <th><b>Asset Description</b></th>
            <th><b>Site Location</b></th>
            <th><b>Date of Acquisition</b></th>
            <th><b>Date in Use</b></th>
            <th><b>Ending Depreciation Date</b></th>
            <th><b>Qty</b></th>
            <th style="text-align:right;"><b>Cost/Repairing Cost (Tshs)</b></th>
            <th><b>Asset Condition</b></th>
            <th><b>Assets Useful Life</b></th>
            <th><b>Depreciation Rate</b></th>
            <th><b>Total Depreciated years</b></th>
            <th><b>Depreciation For The Year</b></th>
            <th style="text-align:right;"><b>Accumulated Depreciation (Tshs)</b></th>
            <th style="text-align:right;"><b>Impairment Loss (Tshs)</b></th>
            <th style="text-align:right;"><b>Disposal Cost (Tshs)</b></th>
            <th><b>Net Carring Amount</b></th>
        </tr>
    </thead>
    <tbody>
        @php
        $d=1;
    @endphp
        @foreach ($asses as $items)
            @php
            if($_GET['asset']=='Intangible')
            {
            $data = assetsintangible::where('id',$items->assetID)->first();
            $asseted = assetsassesintangible::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }else if($_GET['asset']=='Furniture')
            {
            $data = assetsfurniture::where('id',$items->assetID)->first();
            $asseted = assetsassesfurniture::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }else if($_GET['asset']=='Equipment')
            {
            $data = assetsequipment::where('id',$items->assetID)->first();
            $asseted = assetsassesequipment::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }else if($_GET['asset']=='ComputerEquipment')
            {
            $data = assetscomputerequipment::where('id',$items->assetID)->first();
            $asseted = assetsassescomputerequipment::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }else if($_GET['asset']=='MotorVehicle')
            {
            $data = assetsmotorvehicle::where('id',$items->assetID)->first();
            $asseted = assetsassesmotorvehicle::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }else if($_GET['asset']=='PlantMachinery')
            {
            $data = assetsplantandmachinery::where('id',$items->assetID)->first();
            $asseted = assetsassesplantandmachinery::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }else if($_GET['asset']=='Building')
            {
            $data = assetsbuilding::where('id',$items->assetID)->first();
            $asseted = assetsassesbuilding::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }else if($_GET['asset']=='Land')
            {
            $data = assetsland::where('id',$items->assetID)->first();
            $asseted = assetsassesland::orderBy('assesmentYear','Desc') ->where('assetID',$data->assetID)->first();

            }
            @endphp
            <tr>
                <td>{{$d}}</td>
                <td>{{$data['assetNumber']}}</td>
                <td>{{$data['assetDescription']}}</td>
                <td>{{$data['assetLocation']}}</td>

                <?php  $time = strtotime($data['assetAcquisitionDate'])?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <?php  $time = strtotime($data['assetDateinUse'])?>
                <td>{{date('d/m/Y',$time) }}</td>

                <?php  $time = strtotime($data['assetEndingDepreciationDate'])?>
                <td>{{date('d/m/Y',$time)}}</td>

                <td>{{$data['assetQuantity']}}</td>
                <td style="text-align:right;">{{number_format($data['Cost'])}}  </td>
                <td>{{$data['_condition']}}</td>
                <td>{{$data['usefulLife']}}</td>
                <td>{{number_format($data['depreciationRate'],2)}}</td>
                <td>{{$asseted['totalDepreciatedYears']}}</td>

                <td><?php  $time = strtotime($asseted['assesmentYear'])?>  {{date('d/m/Y',$time)  }}</td>

                <td style="text-align:right;">{{number_format($asseted['accumulatedDepreciation'])}}  </td>
                <td>{{$asseted['impairmentLoss']}}</td>
                <td>{{$asseted['DisposalCost']}}</td>
                <td style="text-align:right;">
                    @php
                        $net = $data['Cost'] - $asseted['accumulatedDepreciation'];
                    @endphp
                    {{number_format($net)}}
                </td>
            </tr>
            @php
                $d++;
            @endphp
        @endforeach

    </tbody>
</table>

