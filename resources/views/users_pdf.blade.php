<title><?php

use App\User;
use App\Directorate;
use App\Department;
use App\Section;
    echo $header;
    $dirsf = '';
     ?></title>
<div style="margin-top: 20px" align="center"><h2>University of Dar es Salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h4>Directorate of Estates Services</h4></p><p><b ><?php
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

<table>
  <thead class="thead-dark" align="center">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
      <th title="phone" scope="col">Phone</th>

      <th scope="col">Email</th>
      <th scope="col">Type</th>
    <th scope="col">Directorate</th>
      <th scope="col">Department</th>


    </tr>
  </thead>
  <tbody align="center">
  <?php

if($_GET['directorate']!='')
        {
            $directora = Directorate::where('id',$_GET['directorate'])->first();
            $dirsf = $directora->name;
        }

 if (isset($_GET['page'])){
if ($_GET['page']==1){

  $i=1;
}else{
  $i = ($_GET['page']-1)*5+1; }
}
else {
 $i=1;
}
 $i=1;

   ?>
    @foreach($load as $user)
    @if ($_GET['directorate']!='')
    @if ( $user['department']['directorate']->name == $dirsf)
    <tr>
      <th scope="row">{{ $i++ }}</th>
      <td>{{ $user->fname . ' '.$user->mid_name.' ' . $user->lname }}</td>

      <td>

        <?php $phonenumber = $user->phone;
          if(substr($phonenumber,0,1) == '0'){

            $phonreplaced = ltrim($phonenumber,'0');
            echo '+255'.$phonreplaced;

          }else { echo $user->phone;}

        ?></td>
      <td><a style="color: #000;" href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>




      @if( $user->type == "Inspector Of Works")
      <td style="text-transform: capitalize;">{{ $user->type }} ,  @if( $user->IoW == 2) <h7 style="color: green;" >{{ $user->zone }}</h7>@elseif( $user->IoW == 1 ) <h7 style="color: red;" >{{ $user->zone }}</h7> @endif</td>

      @else
         @if(strpos( $user->type, "HOS") !== false)
             <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($user->type), 4, 14)?> </td>
             @else
               <td style="text-transform: capitalize;">{{strtolower( $user->type) }} </td>
             @endif

      @endif



         <td>{{ $user['department']['directorate']->name }}</td>
        <td>{{ $user['department']->name }}</td>


      </td>
    </tr>
    @endif
    @else
    <tr>
        <th scope="row">{{ $i++ }}</th>
        <td>{{ $user->fname . ' '.$user->mid_name.' ' . $user->lname }}</td>

        <td><a style="color: #000;" href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>



         <td>

        <?php $phonenumber = $user->phone;
          if(substr($phonenumber,0,1) == '0'){

            $phonreplaced = ltrim($phonenumber,'0');
            echo '+255'.$phonreplaced;

          }else { echo $user->phone;}

        ?></td>

        @if( $user->type == "Inspector Of Works")
        <td style="text-transform: capitalize;">{{ $user->type }} ,  @if( $user->IoW == 2) <h7 style="color: green;" >{{ $user->zone }}</h7>@elseif( $user->IoW == 1 ) <h7 style="color: red;" >{{ $user->zone }}</h7> @endif</td>

        @else
           @if(strpos( $user->type, "HOS") !== false)
               <td style="text-transform: capitalize;"> HoS <?php echo substr(strtolower($user->type), 4, 14)?> </td>
               @else
                 <td style="text-transform: capitalize;">{{strtolower( $user->type) }} </td>
               @endif

        @endif



           <td>{{ $user['department']['directorate']->name }}</td>
          <td>{{ $user['department']->name }}</td>


        </td>
      </tr>
    @endif
    @endforeach
  </tbody>


</table>

</div>
<div id='footer'>
    <p class="page">Page-</p>
</div>
