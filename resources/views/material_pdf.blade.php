
<title><?php
    echo $header;
    ?></title>
<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;"><?php
     echo $header;
     ?></b></p>
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
</div>
        <table>
            <thead align="center">
            <tr>
               <th >#</th>
                <th >ItemID</th>
                <th >Description</th>
                <th >Value/Capacity</th>
                <th >Type</th>
                <th >Stock</th>

            </tr>
            </thead>

            <tbody align="center">

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item->name }}</td>
                    <td id="wo-details">{{ $item->description }}</td>
                     <td>{{ $item->brand }}</td>
                    <td>{{ $item->type }}</td>


                    <td>{{ $item->stock }}</td>

                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <div id='footer'>
        <p class="page">Page-</p>
    </div>
