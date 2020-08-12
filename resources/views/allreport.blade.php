<div style="margin-top: 20px" align="center">
    <h2>University of Dar es salaam</h2>
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

tr:nth-child(even) {
  background-color: #dddddd;
}
#footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:before { content: "Page " counter(page); } @page {margin:20px 30px 40px 50px;}
</style>
<table>
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th title="phone" scope="col">Phone</th>
          @if($section!='0') @else <th scope="col">Section/type</th>@endif
        </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
        @foreach($fetch as $tech)

         <?php   if($_GET['change']=='hos')
            {
                $hotype = $tech->type;
        if(substr($hotype,0,4) == 'HOS '){
                ?>
                     <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $tech->fname . ' ' . $tech->lname }}</td>
                        <td>{{ $tech->email }}</td>
                        <td>

              <?php $phonenumber = $tech->phone;
                if(substr($phonenumber,0,1) == '0'){

                  $phonreplaced = ltrim($phonenumber,'0');
                  echo '+255'.$phonreplaced;

                }else { echo $tech->phone;}

              ?></td>
                        @if($section!='0') @else <td>{{ ucwords(strtolower($tech->type)) }}</td>@endif

                    </tr>
                <?php } }else if($_GET['change']=='iow')
            {  $hotype = $tech->type;
        if(substr($hotype,0,10) == 'Inspector '){ ?>
                         <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $tech->fname . ' ' . $tech->lname }}</td>
                            <td>{{ $tech->email }}</td>
                            <td>

                  <?php $phonenumber = $tech->phone;
                    if(substr($phonenumber,0,1) == '0'){

                      $phonreplaced = ltrim($phonenumber,'0');
                      echo '+255'.$phonreplaced;

                    }else { echo $tech->phone;}

                  ?></td>
                            @if($section!='0') @else <td>{{ ucwords(strtolower($tech->type)) }}</td>@endif

                        </tr>
                <?php } } else if($_GET['change']=='technician')
            { ?>
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $tech->fname . ' ' . $tech->lname }}</td>
                    <td>{{ $tech->email }}</td>
                    <td>

          <?php $phonenumber = $tech->phone;
            if(substr($phonenumber,0,1) == '0'){

              $phonreplaced = ltrim($phonenumber,'0');
              echo '+255'.$phonreplaced;

            }else { echo $tech->phone;}

          ?></td>
                    @if($section!='0') @else <td>{{ ucwords(strtolower($tech->type)) }}</td>@endif

                </tr>
                <?php  } ?>

        @endforeach
        </tbody>


        </table>

<div id='footer'>
    <p class="page"></p>
</div>
