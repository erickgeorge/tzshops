<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <div style="background-image: url('img_girl.jpg');">


    <p><h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;">List of zones assigned to Inspector of Work</b></p>
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
.nameee{
    text-transform:uppercase;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:before { content: "Page " counter(page); } @page {margin:20px 30px 40px 50px;}
</style>
<table>
 <thead class="thead-dark" align="center">

    <tr>
                    <th>#</th>
                    <th>Name of zone</th>
                    <th>Inspector of work</th>


    </tr>
 </thead>
 <tbody align="center">

                <?php $i = 0;  ?>
                @foreach($iowzone as $sect)
                        <tr>
                       <?php $i++;?>
                        <td>{{$i}}</td>
                       <td class="nameee"> {{$sect->zone}}</td>
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
    <p class="page"></p>
</div>
