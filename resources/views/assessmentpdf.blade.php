<div style="margin-top: 20px" align="center">
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <p><h2>University of Dar es salaam</h2> <h5>DIRECTORATE OF ESTATES SERVICES</h5></p>
    <p><b><u>ASSESSMENT FORM</u></b></p>
</div>
<style>
    body { background-image:  url('/images/estatfegrn.jpg');

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
    <br>
    @foreach($assessmmentcompany as $assesment)
    @endforeach

    <div class="container-name">
     <div class="div1">Name of company assessed:<u style="padding-left: 12px;"> {{$assesment['companyname']->company_name}} </u></div>
    <div class="div2"> </div>
   </div>
     <br>


    <div class="container-name">
     <div class="div1">Date: <u style="padding-left: 12px;">{{$assesment->assessment_month}} </u></div>
    <div class="div2"> Area:  <u style="padding-left: 40px;">  {{$assesment['areaname']->cleaning_name}} </u> </div>
   </div>


  <?php  
   $sum = 0;
   $summ = 0;
   ?>
      <table border = "2" cellpadding = "5" cellspacing = "5">
 <tr>
    <th>Activity</th>
  <th>Percentage(%)</th>
    <th>Score</th>
     <th>Remark</th>

  </tr>

  @foreach($assessmmentactivity as $assesment)
   <?php   $sum += $assesment->percentage;  $summ += $assesment->score;?>
  <tr>
   <td>{{$assesment->activity}}</td>
   <td>{{$assesment->percentage}}</td>
    <td>{{$assesment->score}}</td>
    <td>{{$assesment->remark}}</td>
 </tr>

  @endforeach

    <th><b>Tottal</b></th>
  <th><b><?php echo $sum ?>%</b></th>
  <th><b><?php echo $summ ?>%</b></th>
  <th></th>
      </table>  
<br><br><br><br><br><br>
    <div class="container-name">
     <div class="div1">ASSESSED BY:<u style="padding-left: 12px;">  </u></div>
    <div class="div2"> </div>
   </div>
     <br>

    <div class="container-name">
     <div class="div1">Name of Assessor: <u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Signature:  <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date:  <u style="padding-left: 40px;">   </u> </div>
   </div>
<br>
   <div class="container-name">
     <div class="div1">Name of company Supervisor: <u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Title:  <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Signature:  <u style="padding-left: 40px;">   </u> </div>
   </div>

<br>
   <div class="container-name">
     <div class="div1">Approved by DVC Admin: <u style="padding-left: 12px;"> </u></div>
    <div class="div2"> Signature:  <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date:  <u style="padding-left: 40px;">   </u> </div>
   </div>   

   <br>
   <div class="container-name">
     <div class="div1">Payment: <u style="padding-left: 12px;"> {{$assesment->payment}}</u></div>
     <div class="div2"> Signature:  <u style="padding-left: 40px;">   </u> </div>
    <div class="div2"> Date:  <u style="padding-left: 40px;"> </u> </div>
   
   </div>  

  
      
   </body>



             


<div id='footer'>
    <p class="page">page</p>
</div>   