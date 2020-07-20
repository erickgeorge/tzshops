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
        <tr >
            <th colspan="12" >
               <center>
                    <h1 style="margin-left: 27%;">UNIVERSITY OF DAR ES SALAAM - (UDSM)</h1>
                </center>
            </th>
        </tr>
        <tr>
            <th colspan="12">
                <h1 style="text-transform: capitalize;">
                    DIRECTORATE OF ESTATES SERVICES
                </h1>
            </th>
        </tr>
        <tr >
            <th colspan="12">
                <h2 style="margin-left: 28%;">NON - CURRENT ASSET REGISTER - AS ON @php echo date('d F, Y'); @endphp </h2>
            </th>
        </tr>
        <tr>
            <th><b>SN</b></th>
            <th><b>Asset Number</b></th>
            <th><b>Asset Description</b></th>
            <th><b>Site Location</b></th>
            <th><b>Date of Acquisition</b></th>
            <th><b>Date in Use</b></th>
            <th><b>Ending depreciation Rate</b></th>
            <th><b>Quantity</b></th>
            <th style="text-align:right;"><b>Cost/ Rep cost (Tshs)</b></th>
            <th><b>Condition</b></th>
            <th><b>Useful Life</b></th>
            <th><b>Depreciation Rate</b></th>
        </tr>
    </thead>
    <tbody>
        @php
            $X=1;
        @endphp
        @foreach ($assetdata as $user)
        <tr>
            <td>{{$X}}</td>
            <td>{{$user->assetNumber}}</td>
            <td>{{$user->assetDescription}}</td>
            <td>{{$user->assetLocation}}</td>
            <?php  $time = strtotime($user->assetAcquisitionDate)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <?php  $time = strtotime($user->assetDateinUse)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <?php  $time = strtotime($user->assetEndingDepreciationDate)?>
                <td>{{date('d/m/Y',$time)  }}</td>

            <td>{{$user->assetQuantity}}</td>
            <td style="text-align:right;">{{number_format($user->Cost)}}  </td>
            <td>{{$user->_condition}}</td>
            <td>{{$user->usefulLife}}</td>
            <td>{{number_format($user->depreciationRate,2)}}</td>
        </tr>
        @php
            $X++;
        @endphp

        @endforeach
    </tbody>
</table>
