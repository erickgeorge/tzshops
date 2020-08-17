<title>Completed Works Orders With Time taken</title>
<div style="margin-top: -7px" align="center"><h2>University of Dar es salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h5>Director of Estates Services</h5></p><p><b style="text-transform: uppercase;">Completed Works Orders With Time taken</b></p>
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
                    <th>Time</th>

                    <th>Location</th>


    </tr>
 </thead>
 <tbody align="center">

                <?php $i = 0;  ?>
                @foreach($unattended_work as $work)

                    @if($work->status !== 0)
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-details">{{ $work->details }}</td>
                            <td>{{ $work->problem_type }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                            <?php
                            $datetime1 = $work->created_at;
                            $datetime2 = $work->updated_at;

                            $interval = date_diff($datetime1, $datetime2);


                         ?>
                         <td>{{ $interval->format('%a') }} <small>Week(s)</small>  </td>
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
