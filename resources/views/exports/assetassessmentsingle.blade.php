@php

use App\assetsassesbuilding;
use App\assetsassescomputerequipment;
use App\assetsassesequipment;
use App\assetsassesfurniture;
use App\assetsassesintangible;
use App\assetsassesland;
use App\assetsassesmotorvehicle;
use App\assetsassesplantandmachinery;

@endphp
<title>Asset Assessment Report</title>
<center>
    <h1>University of Dar es salaam</h1>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">

    <h3>Directorate of Estates Services</h3>
</center>
<hr>
<p>Asset Assessment Report</p>
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
<table  style="width: 100%;">
        @foreach ($land as $asses)
        <thead>
            <tr>
                <th colspan="2" style="margin-bottom: 4px;">

                    <b style="color: black;">Description : </b>  {{$asses->assetDescription}} <br>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
            </tr>
        <tr>
            <td>
                <b style="color: black;">Asset Number :</b> {{$asses->assetNumber}}
            </td>
            <td>
                <b style="color: black; "> Asset Location : </b> {{$asses->assetLocation}}
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;"> Asset Quantity : </b>  {{$asses->assetQuantity}}
            </td>
            <td>
                <b style="color">Cost/Repairing Cost : </b>   {{number_format($asses->Cost)}} .
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;">Assets Useful Life : </b> {{$asses->usefulLife}} Years
            </td>

            <td>
                <b style="color: black;">Asset Condition : </b> {{$asses->_condition}}
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;">Depreciation Rate : </b> {{number_format($asses->depreciationRate,2)}}%
            </td>
            <td>
                <b style="color: black;">Asset Acquisition Date : </b>  <?php  $time = strtotime($asses->assetAcquisitionDate)?>  {{date('d/m/Y',$time)  }}
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;"> Asset in Use Date : </b>  <?php  $time = strtotime($asses->assetDateinUse)?>  {{date('d/m/Y',$time)  }}
            </td>
            <td>
                <b style="color: black;"> Asset Ending Depreciation Date : </b>  <?php  $time = strtotime($asses->assetEndingDepreciationDate)?>  {{date('d/m/Y',$time)  }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br><br><br>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Assessment Year</th>
            <th>Total Depreciated Years</th>
            <th style="text-align:right;">Accumulated Depreciation (Tshs)</th>
            <th style="text-align:right;">Impairment Loss (Tshs)</th>
            <th style="text-align:right;">Disposal Cost (Tshs)</th>
        </tr>
    </thead>
    @php
        if ($_GET['type'] == 'building') {
            $info = assetsassesbuilding::where('assetID',$asses->id)->get();
        }else  if ($_GET['type'] == 'land') {
            $info = assetsassesland::where('assetID',$asses->id)->get();
        }else  if ($_GET['type'] == 'motorvehcile') {
            $info = assetsassesmotorvehicle::where('assetID',$asses->id)->get();
        }else  if ($_GET['type'] == 'plantandmachinery') {
            $info = assetsassesplantandmachinery::where('assetID',$asses->id)->get();
        }else  if ($_GET['type'] == 'computerequipment') {
            $info = assetsassescomputerequipment::where('assetID',$asses->id)->get();
        }else  if ($_GET['type'] == 'equipment') {
            $info = assetsassesequipment::where('assetID',$asses->id)->get();
        }else  if ($_GET['type'] == 'furniture') {
            $info = assetsassesfurniture::where('assetID',$asses->id)->get();
        }else {
            $info = assetsassesintangible::where('assetID',$asses->id)->get();
        }
    @endphp
    <tbody>
        @php
         $d = 1;
        @endphp
        @foreach ($info as $info)
        <tr>
            <td>{{$d}}</td>
            <?php  $time = strtotime($info->assesmentYear)?>
            <td> {{date('d/m/Y',$time)  }}</td>
            <td>{{$info->totalDepreciatedYears}}</td>
            <td style="text-align:right;">{{number_format($info->accumulatedDepreciation)}}</td>
            <td style="text-align:right;">{{number_format($info->impairmentLoss)}}</td>
            <td style="text-align:right;">{{number_format($info->DisposalCost)}}</td>
        </tr>
        @php
            $d++;
        @endphp
        @endforeach
    </tbody>
    </tfoot>
</table>
