<title><?php
    echo $header;
     ?></title>
<div style="margin-top: 20px" align="center"><h2>University of Dar es salaam</h2>
    <img src="{{ public_path('/images/logo_ud.png') }}" height="100px" style="margin-top: 5px;" alt="udsm">
    <p> <h4>Directorate of Estates Services</h4></p><p><b style="text-transform: uppercase;"><?php
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
<?php use App\User; ?>
       @foreach($entry as $produced)
 <?php  $added_by = $produced->added_by;
    $tag_ = $produced->tag_;
?>
       @endforeach
      <center>
      Added By :

  <?php $officer = User::where('id',$added_by )->get(); ?>
   @foreach($officer as $offier) {{ $offier->fname }} {{ $offier->lname }}
   @endforeach &nbsp;&nbsp;&nbsp;on :
   <?php $time = strtotime($tag_); echo date('d/m/Y',$time);  ?>

   </center><br>



<table>
  <thead  align="center">
    <tr style="color: white;">
      <th scope="col">#</th>
      <th scope="col">Material Name</th>

      <th scope="col">Description</th>
      <th scope="col">Type</th>
      <th scope="col">Total</th>
    <th scope="col">Unit Measure</th>


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
    @foreach($entry as $procure)
    <tr>
      <th scope="row">{{ $i++ }}</th>
      <td>{{ $procure->material_name }}</td>

      <td>{{ $procure->material_description }}</td>
      <td>{{ $procure->type }}</td>
      <td>{{ $procure->total_input }}</td>
         <td>{{ $procure->unit_measure }}</td>


      </td>
    </tr>
    @endforeach
  </tbody>


</table>

</div>
  <div id='footer'>
    <p class="page"></p>
</div>
