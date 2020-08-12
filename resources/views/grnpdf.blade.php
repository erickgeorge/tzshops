<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h5>DIRECTORATE OF ESTATES SERVICES</h5></p>
    <p><b><u>GOODS RECEIVED NOTE</u></b></p>
    </div>
<p>This is to confirm that we have today received the following goods in good condition</p>
<p>UNLESS OTHERWISE STATED IN THE "REMARKS" COLUMN from (NAME OF SUPPLIER)___________________________________</p>

<style>
    body { background-image:  url('/images/estategrn.jpg');

    /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

    }

   .box{
    width:710px;
    height: 130px;
     border: 2px solid #b0aca0;
   }




   .container-name div {
  display: inline-block;
  width: 400px;
  min-height: 50px;

  height: auto;
  }



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



   <body>

      <table border = "2" cellpadding = "5" cellspacing = "5">
          <tr>
              <th>#</th>
              <th>QUANTITY</th>
              <th>UNIT OF QUANTITY</th>
              <th>DESCRIPTION OF GOODS</th>
              <th>SUPPLIER'S INVOICE No.</th>
              <th>UNIT RATE</th>
              <th>VALUE</th>
              <th>L.P.O No.</th>
              <th>CODE No.</th>
              <th>REMARKS</th>
          </tr>
          <tbody>

            <?php $i=0;  ?>
           @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item->quantity - $item->reserved_material }}</td>
                    <td style="'min-width:20px;"></td>
                    <td>{{ $item['material']->description }}</td>
                    <td style="'min-width:40px;"></td>
                    <td style="'min-width:40px;"></td>
                    <td>{{ $item['material']->brand }}</td>
                    <td style="'min-width:40px;"></td>
                    <td style="'min-width:40px;"></td>
                    <td>{{ $item['material']->type }}</td>
                </tr>

            </tbody>
            @endforeach

      </table>


<div >
    <br>


    <div class="container-name">
     <div class="div1">Material Purchased By: <u style="padding-left: 12px;"> {{ $item['user']->fname.' '.$item['user']->lname }}</u></div>
    <div class="div2"> Store Manager:<u style="padding-left: 40px;"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}  </u> </div>
   </div>
<br>
   <div class="container-name">
    <div class="div1">Signature  <u style="padding-left: 85px; width: 55px"> </u>  .................................</div>
    <div class="div2">Signature  <u style="padding-left: 65px; width: 55px"> </u>         .................................</div>


   </div>
<br>

     <div class="container-name">
     <div  class="div1" > Works Order No:<u style="padding-left: 65px; width: 45px"> 00{{ $item->work_order_id }}</u> </div>


         <div class="div2">Date:<i style="padding-left: 100px; width: 80px">...........................</i>   </div>
    </div>


      <br>

      <div>
          <div> Remarks : ..................................................................................................................................................................................................................................................
          </div>
      </div>
      <br>
      <br>


        <!--<br>
         <br>
        <div style="padding-left: 400px">
      Official Stamp:  ..........................................................
       </div>-->

   </body>






<div id='footer'>
    <p class="page">page</p>
</div>
