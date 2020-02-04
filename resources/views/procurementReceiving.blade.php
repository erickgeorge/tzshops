<div style="margin-top: 20px" align="center">
    <img src="{{ public_path('/images/index.jpg') }}" height="100px" style="margin-top: 5px;" alt="udsm"> 
    <p><h2>University of Dar es salaam</h2> <h4>Directorate of Estates Services</h4></p><p><b><?php
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
#footer .page:before { content: "Page " counter(page); } @page {margin:20px 30px 40px 50px;}
</style>
<?php use App\User; ?>
       @foreach($procure as $produced)
 <?php  $procured_by = $produced->procured_by;
    $tag_ = $produced->tag_;
    $store_received = $produced->store_received
?>
       @endforeach
      <div> 
        <?php $officer = User::where('id',$procured_by )->get(); ?> 

 Materials Sent on :
   <?php $time = strtotime($tag_); echo date('d/m/Y',$time);  ?>
 &nbsp;&nbsp;&nbsp;  
 @if($store_received == 0) 
  @if(auth()->user()->type == 'Head Procurement') status: Not Received by store 
  @else status: Not Confirmed 
  @endif
@else 
   Received by :
    <?php $store =  User::where('id',$store_received )->get(); ?>
@foreach($store as $officcer) {{ $officcer->fname }} {{ $officcer->lname }} 
@endforeach
   @endif</div><br>
                            
      

<table>
  <thead class="thead-dark" align="center">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Material Name</th>
     
      <th scope="col">Description</th>
      <th scope="col">Type</th>
      <th scope="col">Total</th>
    <th scope="col">Unit Measure</th>
      <th scope="col">Price</th>
  
 
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
   
      <td>{{ $procure->material_description }}</td>
      <td>{{ $procure->type }}</td>
      <td>{{ $procure->total_input }}</td>
         <td>{{ $procure->unit_measure }}</td>
        <td>{{ $procure->price_tag }}</td>
   
     
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


 <br>

      <div>
          <div> Remark </div><br>

        <div> ..................................................................................................................................................................................
          </div>
      </div>
      <br>
      <br> 

  <div id='footer'>
    <p class="page"></p>
</div>