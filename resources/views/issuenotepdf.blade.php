<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2> 
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h5>DIRECTORATE OF ESTATE SERVICES</h5></p>
    <p><b style="text-transform: uppercase;"><u>ISSUE NOTE</u></b></p>
</div>
<style>
    body { background-image:  url('/images/essuenote.jpg');

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

        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
        <th >No</th>

        <th >Material Name</th>
        <th >Material Description</th>
        <th >Type</th>
        <th >Quantity Received</th>
       
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
            <td>{{ $item->quantity }}</td>


                    
                    </tr>
                    @endforeach
            </tbody>
        </table>


<div >
    <br>


    <div class="container-name">

    <div class="div1"> Material Received By:<u style="padding-left: 40px;"> {{ $item['userreceiver']->fname.' '.$item['userreceiver']->lname }} </u> </div>
    <div class="div2"> Store Manager:  <u style="padding-left: 12px;"> {{ Auth::user()->fname }} {{ Auth::user()->lname }} </u></div>
   </div>
   <br>


   <div class="container-name">
     <div  class="div1" >  Signature:      .........................................</div>


      <div  class="div2" >  Signature:      ........................................</div>


    </div>





     <div class="container-name">
     <div  class="div1" > Works Order No:<u style="padding-left: 100px; width: 45px"> 00{{ $item->work_order_id }}</u> </div>


     <div class="div2">Date Received From Store:<u style="padding-left: 40px; width: 80px">    <?php $time = strtotime($item['material']->updated_at); echo date('d/m/Y',$time);  ?> </u> </div>
    </div>


     <div  class="div1" > Works Order Details:<u style="padding-left: 60px; width: 45px"> {{ $item['workorder']->details }}</u> </div>



      <br>
    
     <div  style="color: blue"> Status: <span class="badge badge-info">  Received</span>
                    </div><br>

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
