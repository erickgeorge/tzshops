<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2> 
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h5>DIRECTORATE OF ESTATES SERVICES</h5></p>
    <p><b><u>GOODS RECEIVED NOTE</u></b></p>
</div>
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
         <tr >
             <th >No</th>
                <th >HoS Name</th>
                <th >Material Name</th>
                <th >Description</th>
                <th >Value/Capacity</th>
                <th >Type</th>

                <th >Quantity Purchased</th>>
         </tr>
          <tbody>

            <?php $i=0;  ?>
           @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['staff']->fname.' '.$item['staff']->lname }}</td>
                    <td>{{ $item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->brand }}</td>
                    <td>{{ $item['material']->type }}</td>

                   <td style="color: blue"> {{ $item->quantity - $item->reserved_material }}</td>

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

   <div class="container-name">
    <div class="div1">Signature  <u style="padding-left: 85px; width: 55px"> </u>  .................................</div>
    <div class="div2">Signature  <u style="padding-left: 65px; width: 55px"> </u>         .................................</div>


   </div>


     <div class="container-name">
     <div  class="div1" > Works Order No:<u style="padding-left: 65px; width: 45px"> 00{{ $item->work_order_id }}</u> </div>


     <div class="div2">Purchased at:<u style="padding-left: 100px; width: 80px">    <?php $time = strtotime($item['material']->updated_at); echo date('d/m/Y',$time);  ?> </u> </div>
    </div>


      <br>

      <div>
          <div> Remark </div><br>

        <div> ..................................................................................................................................................................................
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
