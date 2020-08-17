<title>Asset Summary</title>
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
<p>Asset Summary</p>
<table  style="width: 100%;">
        @foreach ($land as $landinfo)
        <thead>
            <tr>
                <th colspan="2" style="margin-bottom: 4px;">

                    <b style="color: black;">Description : </b>  {{$landinfo->assetDescription}} <br>
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
                <b style="color: black;">Asset Number :</b> {{$landinfo->assetNumber}}
            </td>
            <td>
                <b style="color: black; "> Asset Location : </b> {{$landinfo->assetLocation}}
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;"> Asset Quantity : </b>  {{$landinfo->assetQuantity}}
            </td>
            <td>
                <b style="color">Cost/Repairing Cost : </b>   {{number_format($landinfo->Cost)}} .
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;">Assets Useful Life : </b> {{$landinfo->usefulLife}} Years
            </td>

            <td>
                <b style="color: black;">Asset Condition : </b> {{$landinfo->_condition}}
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;">Depreciation Rate : </b> {{number_format($landinfo->depreciationRate,2)}}%
            </td>
            <td>
                <b style="color: black;">Asset Acquisition Date : </b>  <?php  $time = strtotime($landinfo->assetAcquisitionDate)?>  {{date('d/m/Y',$time)  }}
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: black;"> Asset in Use Date : </b>  <?php  $time = strtotime($landinfo->assetDateinUse)?>  {{date('d/m/Y',$time)  }}
            </td>
            <td>
                <b style="color: black;"> Asset Ending Depreciation Date : </b>  <?php  $time = strtotime($landinfo->assetEndingDepreciationDate)?>  {{date('d/m/Y',$time)  }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
