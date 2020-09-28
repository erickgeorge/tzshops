
<title><?php
    echo $header;
     ?></title>
<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2>
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p><h4>Directorate of Estates Services</h4></p><p><b><?php
     echo $header;
      ?></b></p>

</div><br>
<p>This is to confirm that we have today received the following goods in good condition</p>
<p>UNLESS OTHERWISE STATED IN THE "REMARKS" COLUMN from (NAME OF SUPPLIER)___________________________________</p>
<br>
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

  #footer{position:fixed; right:0px; bottom:10px; text-align:center; border-top:1px solid black; }
#footer .page:after{content:counter(page, decimal);}
@page {margin:20px 30px 40px 50px;}
</style>
<?php use App\User; ?>
       @foreach($procure as $produced)
 <?php  $procured_by = $produced->procured_by;
    $tag_ = $produced->tag_;
    $store_received = $produced->store_received
?>
       @endforeach

        <?php $officer = User::where('id',$procured_by )->get(); ?>





<table>
  <thead style=" background-color: #376ad3; color: white; ">
   <tr style="color: white;">
       <th>#</th>
       <th>MATERIAL NAME</th>
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
  </thead>
  <tbody align="center">
  <?php

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
    @foreach($procure as $procure)
    <tr>
      <th scope="row">{{ $i++ }}</th>
      <td>{{ $procure->material_name }}</td>
        <td>{{ number_format($procure->total_input) }}</td>
        <td>{{ $procure->unit_measure }}</td>

      <td>{{ $procure->material_description }}</td>
        <td></td>
        <td>{{ number_format($procure->price_tag) }}</td>

        <td>{{ number_format($procure->price_tag*$procure->total_input) }}</td>
        <td></td>
        <td></td>
      <td>{{ $procure->type }}</td>


      </td>
    </tr>
    @endforeach
  </tbody>


</table>
<br><br>

<div class="container-name">

     <div class="div1">Material(s) Sent By: <u style="padding-left: 12px;"> @foreach($officer as $offier) {{ $offier->fname }} {{ $offier->lname }}
   @endforeach</u></div>
    <div class="div2">  @if($store_received == 0) Store Manager:<u style="padding-left: 40px;"> {{ Auth::user()->fname }} {{ Auth::user()->lname }} </u> @else Received By:<u style="padding-left: 40px;"> <?php $store =  User::where('id',$store_received )->get(); ?>
@foreach($store as $officcer) {{ $officcer->fname }} {{ $officcer->lname }}
@endforeach </u>   @endif  </div>
   </div>

<div class="container-name">
    <div class="div1">Signature  <u style="padding-left: 85px; width: 55px"> </u>  .................................</div>
    <div class="div2">Signature  <u style="padding-left: 65px; width: 55px"> </u>         .................................</div>


   </div>
<div class="container-name">
    <div class="div1"></div>

    <div class="div2">Date<u style="padding-left: 65px; width: 55px"> </u>         .................................</div>
</div>

 <br>

      <div>
          <div> Remarks : ..................................................................................................................................................................................
          </div>
      </div>
      <br>
      <br>

      <div id='footer'>
        <p class="page">Page-</p>
    </div>
