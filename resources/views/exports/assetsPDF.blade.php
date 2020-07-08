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
        <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">
        <h1>University of Dar es salaam</h1>
        <h2>Direcorate of Estates Services</h2>
        <h3>NON - CURRENT ASSET REGISTER - AS AT @php echo date('d M, Y'); @endphp</h3>
    </center>
</div>
<table class="table table-light">
    <thead class="thead-light">

        <tr>
            <th><b style="text-transform: capitalize;">SN</b></th>
            <th><b style="text-transform: capitalize;">ASSET #</b></th>
            <th><b style="text-transform: capitalize;">ASSET DESCRIPTION </b></th>
            <th><b style="text-transform: capitalize;">SITE LOCATION </b></th>
            <th><b style="text-transform: capitalize;">DATE OF ACQUISITION </b></th>
            <th><b style="text-transform: capitalize;">DATE IN USE </b></th>
            <th><b style="text-transform: capitalize;">ENDING DPRECIATION DATE </b></th>
            <th><b style="text-transform: capitalize;">QUANTITY</b></th>
            <th><b style="text-transform: capitalize;">COST/REPAIR COST</b></th>
            <th><b style="text-transform: capitalize;">CONDITION</b></th>
            <th><b style="text-transform: capitalize;">USEFUL LIFE</b></th>
            <th><b style="text-transform: capitalize;">DEPRECIATION RATE </b></th>
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
            <td>{{$user->assetAcquisitionDate}}</td>
            <td>{{$user->assetDateinUse}}</td>
            <td>{{$user->assetEndingDepreciationDate}}</td>
            <td>{{$user->assetQuantity}}</td>
            <td style="text-align:right;">{{number_format($user->Cost)}}  Tshs</td>
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
