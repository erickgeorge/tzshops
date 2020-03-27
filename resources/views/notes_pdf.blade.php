<div style="margin-top: 20px" align="center">
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <div style="background-image: url('img_girl.jpg');">


    <p><h2>University of Dar es salaam</h2> <h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;"><?php
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
 <thead class="thead-dark" align="center">
    
    <tr>
                    <th>#</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Status</th>
               
                    <th>Location</th>
                    
        
    </tr>
 </thead>
 <tbody align="center">

                <?php $i = 0;  ?>
                @foreach($wo as $work)

                    @if($work->status !== 0)
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-details">{{ $work->details }}</td>
                            <td>{{ $work->problem_type }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                            @if($work->status == -1)
                                <td><span class="badge badge-warning">new</span></td>
                            @elseif($work->status == 1)
                                <td><span class="badge badge-success">accepted</span></td>
                
              @elseif($work->status == 2)
                                <td><span class="badge badge-success">CLOSED</span></td>
              @elseif($work->status == 3)
                                <td><span class="badge badge-info">technician assigned</span></td>
              @elseif($work->status == 4)
                                <td><span class="badge badge-info">transportation stage</span></td>
              @elseif($work->status == 5)
                              <td><span class="badge badge-info">pre-implementation</span></td>
              @elseif($work->status == 6)
                              <td><span class="badge badge-info">post=implementation</span></td>
              @elseif($work->status == 7)
                              <td><span class="badge badge-info">material requested</span></td>
              @else
                                <td><span class="badge badge-success">procurement stage</span></td>               
                            @endif
                       
                            <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}
                            @else

                                {{ $work->location }}
                            @endif
                            </td>
                               
                                @endif
                        </tr>
                        @endforeach
                </tbody>
</table>
<div id='footer'>
    <p class="page"></p>
</div>