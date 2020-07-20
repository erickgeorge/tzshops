@php
use App\assetsland;
use App\assetsbuilding;
use App\assetscomputerequipment;
use App\assetsequipment;
use App\assetsfurniture;
use App\assetsintangible;
use App\assetsmotorvehicle;
use App\assetsplantandmachinery;
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
                <h1 style="text-transform: capitalize;">
                    <?php  $time = strtotime($_GET['date'])?>
                    ALL {{strtoupper($_GET['asset'])}} ASSETS ASSESSMENT RECORDS AS ON {{date('d/m/Y',$time)  }}
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
            <th style="text-align:right;"><b>Cost/Rep.Cost (Tshs)</b></th>
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
        @foreach ($assetdata as $items)
            @php
                if($_GET['asset']=='Intangible')
            {
                $data = assetsintangible::where('id',$items->assetID)->first();
            }else if($_GET['asset']=='Furniture')
            {
                $data = assetsfurniture::where('id',$items->assetID)->first();
            }else if($_GET['asset']=='Equipment')
            {
                $data = assetsequipment::where('id',$items->assetID)->first();
            }else if($_GET['asset']=='ComputerEquipment')
            {
                $data = assetscomputerequipment::where('id',$items->assetID)->first();
            }else if($_GET['asset']=='MotorVehicle')
            {
                $data = assetsmotorvehicle::where('id',$items->assetID)->first();
            }else if($_GET['asset']=='PlantMachinery')
            {
                $data = assetsplantandmachinery::where('id',$items->assetID)->first();
            }else if($_GET['asset']=='Building')
            {
                $data = assetsbuilding::where('id',$items->assetID)->first();
            }else if($_GET['asset']=='Land')
            {
                $data = assetsland::where('id',$items->assetID)->first();
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
                <td>{{$items->totalDepreciatedYears}}</td>

                <?php  $time = strtotime($items->assesmentYear)?>
                <td>{{date('d/m/Y',$time)}}</td>

                <td style="text-align:right;">{{number_format($items->accumulatedDepreciation)}} </td>
                <td>{{$items->impairmentLoss}}</td>
                <td>{{$items->DisposalCost}}</td>
                <td style="text-align:right;">
                    @php
                        $net = $data['Cost'] - $items->accumulatedDepreciation;
                    @endphp
                    {{number_format($net)}}
                </td>
            </tr>
            @php
                $d++;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
        </tr>
    </tfoot>
</table>
