@foreach($iowlocation as $iow)
@endforeach

<title>List of available location for {{ $iow['iow']->zone}}</title>
<div style="margin-top: 20px" align="center"><h2>University of Dar es Salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <div style="background-image: url('img_girl.jpg');">


    <p><h4>Directorate of Estates Services</h4></p>
    <p><b style="text-transform: uppercase;">
        List of available locations for {{ $iow['iow']->zone  }} </b></p>
</div><br>

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
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>
<table>
 <thead class="thead-dark" align="center">

    <tr>
                    <th>#</th>
                    <th>Location  Name</th>



    </tr>
 </thead>
 <tbody align="center">

                <?php $i = 0;  ?>
                @foreach($iowlocation as $sect)
                        <tr>
                       <?php $i++;?>
                        <td>{{$i}}</td>
                       <td class="nameee"><?php echo ucwords(strtolower( $sect->location )); ?></td>

                       </tr>
                        @endforeach
                </tbody>
</table>
<div id='footer'>
    <p class="page">Page-</p>
</div>
