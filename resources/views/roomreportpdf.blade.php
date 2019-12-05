<div style="margin-top: 20px" align="center">
    <img src="{{ public_path('/images/index.png') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <p><h2>University of Dar es salaam</h2> <h5>Directorate of Estates Services</h5></p><p><b><?php
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
#footer .page:before { content: "Page " counter(page); } @page {margin:20px 30px 40px 50px;}
</style>
<table>
    <?php use App\WorkOrder; ?>
 <thead class="thead-dark" align="center">
    
    <tr>
                    <th>#</th>
                    <th>location</th>
                    <th>Total work order requests</th>
                    
        
    </tr>
 </thead>
 <tbody align="center">

                <?php $i = 0;  ?>
                @foreach($local as $work)

                    @if($work->status !== 0)
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-details">{{ $work->location }}</td>
                            <td> <?php 
                                $count = WorkOrder::select(DB::raw('count(location) as total_location'))->Where('location',$work->location)->get();
                                foreach ($count as $counted) {
                                    echo $counted['total_location'];
                                }
                            ?></td>
                        </tr>
                        @endif
                        @endforeach
                </tbody>
</table>
<div id='footer'>
    <p class="page"></p>
</div>