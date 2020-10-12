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
<title>@php echo ' Asset Assessment Records'; @endphp</title>
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
<div>
    <div>
        <center>
            <h1>University of Dar es Salaam</h1>
            <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">

            <h3>Directorate of Estates Services</h3>
        </center>
    </div>
</div>
<center> @php echo ' Asset Assessment Records'; @endphp </center>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>SN</th>
            <th>Asset #</th>
            <th>Description</th>
            <th>Location</th>
            <th style="text-align:right;">Cost (Tshs)</th>
            <th>Condition</th>
            <th>Date of Acquistion </th>
            <th>Date in Use </th>
            <th>Ending Depreciation Date </th>
            <th>Quantity</th>
            <th>Assessment Year </th>
            <th>Total Depreciated Years </th>
            <th style="text-align:right;">Acumulated Depreciation </th>
            <th style="text-align:right;">Impairment Loss </th>
            <th style="text-align:right;">Disposal Cost </th>
        </tr>
    </thead>
    <tbody>
        @php
        $d = 1;
    @endphp
    @foreach ($land as $asses)
        <tr>
        <td>{{$d}}</td>
                <td>{{$asses->assetNumber}}</td>
                <td>{{$asses->assetDescription}}</td>
                <td>{{$asses->assetLocation}}</td>
                <td>{{$asses->Cost}}</td>
                <td>{{$asses->_condition}}</td>


                <?php  $time = strtotime($asses->assetacquisitionDate)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <?php  $time = strtotime($asses->assetDateinUse)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <?php  $time = strtotime($asses->assetEndingDepreciationDate)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <td>{{$asses->assetQuantity}}</td>
                @php
                    if ($_GET['type'] == 'building') {
                        $info = assetsassesbuilding::where('assetID',$asses->id)->first();
                    }else  if ($_GET['type'] == 'land') {
                        $info = assetsassesland::where('assetID',$asses->id)->first();
                    }else  if ($_GET['type'] == 'motorvehcile') {
                        $info = assetsassesmotorvehicle::where('assetID',$asses->id)->first();
                    }else  if ($_GET['type'] == 'plantandmachinery') {
                        $info = assetsassesplantandmachinery::where('assetID',$asses->id)->first();
                    }else  if ($_GET['type'] == 'computerequipment') {
                        $info = assetsassescomputerequipment::where('assetID',$asses->id)->first();
                    }else  if ($_GET['type'] == 'equipment') {
                        $info = assetsassesequipment::where('assetID',$asses->id)->first();
                    }else  if ($_GET['type'] == 'furniture') {
                        $info = assetsassesfurniture::where('assetID',$asses->id)->first();
                    }else {
                        $info = assetsassesintangible::where('assetID',$asses->id)->first();
                    }
                @endphp
                <td>{{$info['assesmentYear']}}</td>
                <td>{{$info['totalDepreciatedYears']}}</td>
                <td>{{number_format($info['accumulatedDepreciation'])}}  </td>
                <td>{{number_format($info['impairmentLoss'])}}  </td>
                <td>{{number_format($info['DisposalCost'])}}  </td>
            </tr>
        @endforeach
    </tbody>
</table>
