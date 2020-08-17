<title>NON - CURRENT ASSET REGISTER AS ON @php echo date('d F, Y'); @endphp</title>
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
    <center>

        <h1>University of Dar es salaam</h1>
        <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
        <h2>Direcorate of Estates Services</h2>
        <h3>NON - CURRENT ASSET REGISTER AS ON @php echo date('d F, Y'); @endphp</h3>
    </center>
</div>
<table class="table table-light">
    <thead class="thead-light">

        <tr>
            <th><b>SN</b></th>
            <th><b >Asset #</b></th>
            <th><b  >Asset Description </b></th>
            <th><b  >Site Location </b></th>
            <th><b  >Date Of Acquistion </b></th>
            <th><b >Date In Use </b></th>
            <th><b  >Ending Depreciation Date </b></th>
            <th><b  >Quantity</b></th>
            <th style="text-align:right;"><b >Cost/Repair Cost (Tshs)</b></th>
            <th><b >Condition</b></th>
            <th><b  >Useful Life</b></th>
            <th><b  >Depreciation Rate </b></th>
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
