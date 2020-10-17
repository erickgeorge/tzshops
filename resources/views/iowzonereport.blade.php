<title>List of zones assigned to Inspector of Work</title>
<div style="margin-top: 20px" align="center"><h2>University of Dar es Salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <div style="background-image: url('img_girl.jpg');">


    <p><h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;">List of Inspectors of Works for each Zone</b></p>
</div><br>
@php
    use App\User;
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
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>
<table>
 <thead class="thead-dark" align="center">

    <tr>
                    <th>#</th>
                    <th>Name of zone</th>
                    <th>Inspector of works</th>


    </tr>
 </thead>
 <tbody align="center">

                <?php $i = 0;  ?>
                @foreach($iowzone as $sect)
                        <tr>
                       <?php $i++;?>
                        <td>{{$i}}</td>
                       <td class="nameee">{{ ucwords(strtolower($sect->zone)) }}</td>
                            <td> @php
                                $him = User::where('zone', $sect->zone)->get();
                             @endphp @foreach ($him as $him)
                                         {{$him->fname}} {{$him->mid_name}} {{$him->lname}} <br>

                             @endforeach </td>
                       </tr>
                        @endforeach
                </tbody>
</table>
<div id='footer'>
    <p class="page">Page-</p>
</div>
