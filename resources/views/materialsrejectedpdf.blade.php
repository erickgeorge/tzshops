<title><?php
    echo $header;
    ?></title>
    @php
        use App\User;
    @endphp
<div style="margin-top: 20px" align="center"><h2>University of Dar es Salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <div style="background-image: url('img_girl.jpg');">


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

#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th colspan="3">Works Order Details</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                WO# : {{$wo->woCode}}
            </td>
            <td style="text-transform: capitalize;">
                Submitted By : @php
                    $user = User::where('id',$wo->client_id)->first();
                @endphp {{$user['fname']}} {{$user['mid_name']}} {{$user['lname'] }}

            </td>
            <td>
                On : {{ date('d F Y', strtotime($wo->created_at)) }}
            </td>
        </tr>
        <tr>
            <td> Type of problem : {{$wo->problem_type}}  </td>
            <td colspan="2"> Location : @if(empty($wo->room_id) ) {{ $wo->location }} @else {{ $wo['room']['area']['location']->name }}, {{ $wo['room']['area']->name_of_area }}, {{ $wo['room']->name_of_block }}.@endif  </td>
        </tr>
        <tr>
            <td colspan="3">
                Problem Description : {{$wo->details}}
            </td>
        </tr>
    </tbody>
</table>
<br>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th colspan="7">
                Materials Request Details
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Material ID</th>
            <th>Material Description</th>
            <th>Unit Measure</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Reason</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 0;
        @endphp
        @foreach($materials as $item)

        <?php $i++ ?>
        <tr>
            <td> {{$i}} </td>
            <td>{{$item['material']->name }}</td>
            <td>{{ $item['material']->description }}</td>
            <td>{{ $item['material']->brand }}</td>
            <td>{{ $item['material']->type }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{$item->reason}}</td>
        </tr>
        @endforeach
       
    </tbody>
</table>

<div id='footer'>
    <p class="page">Page-</p>
</div>
