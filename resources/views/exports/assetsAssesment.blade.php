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
            <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">
            <h1>University of Dar es salaam</h1>
            <h3>Directorate of Estates Services</h3>
        </center>
    </div>
</div>
<center> @php echo ' Asset Assesment Record'; @endphp </center>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>SN</th>
            <th>ASSET #</th>
            <th>DESCRIPTION</th>
            <th>LOCATION</th>
            <th style="text-align:right;">COST</th>
            <th>CONDITION</th>
            <th>D O A </th>
            <th>D I U </th>
            <th>E D D </th>
            <th>QN</th>
            <th>A D </th>
            <th>T D Y </th>
            <th style="text-align:right;">A D </th>
            <th style="text-align:right;">I L </th>
            <th style="text-align:right;">D C </th>
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
