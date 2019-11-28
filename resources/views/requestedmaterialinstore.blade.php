   @extends('layouts.master')

   @section('title')
    Accepted Material by Iow
    @endSection

@section('body')


<br>
<br>
<br>
<br>
@if(COUNT($wo_materials)>0)
<div class="container">
 @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
</div>
  
<div class="container">

<div style="text-align: center"><h3><b>Material accepted by inspector of work</b></h3></div>

<br>  
<hr>

                         
                         <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
  <tr>
    <th>No</th>
    <th>Material Name</th>
    <th>Material Description</th>
    <th>Type</th>
     <th>Quantity Requested</th>
      <th>Quantity in Store</th>
      <th>Quantity to Reserve</th>
      
       <th>Quantity to be Purchased</th>
       <th>Action</th>
       
       
  </tr>
</thead>

  <?php $i=1; 
  $p= array("t");
  ?>

  <tbody>

    @foreach($wo_materials as $matform)
     <tr>
    <td>{{$i++}}</td>
    <td>{{$matform['material']->name }}</td>
     <td>{{$matform['material']->description }}</td>
    <td>{{$matform['material']->type }}</td>
     <td>{{$matform->quantity }}</td>
    <?php  $x=$matform['material']->stock - $matform['material']->quantity_reserved; ?>
     @if($x<=0)
      <td>0</td>
      @else
      <td>{{$matform['material']->stock  - $matform['material']->quantity_reserved }}</td>
      @endif
     


     @if(($matform['material']->stock- $matform['material']->quantity_reserved)>=($matform->quantity))
          <td>{{$matform->quantity }}</td>
       <?php $procured=0;
       $p[$i]= "no";
       $i++;
       ?>


       @else
      <?php 
       $p[$i]= "yes";
       $i++;
       ?>

      <?php $procured=$matform->quantity- $matform['material']->stock +  $matform['material']->quantity_reserved; ?>
         <td style="color:blue">{{$matform['material']->stock-  $matform['material']->quantity_reserved}}</td>
      @endif
      <td>{{$procured }}</td>


      @if(($matform['material']->stock- $matform['material']->quantity_reserved)<($matform->quantity))
      <td style="color: blue;">Reserve<span> <a style="color: blue;"  href="{{ route('store.material.reserve', [$matform->id]) }}" data-toggle="tooltip" title="Reserve Material"><i class="fas fa-retweet"></i></a>
                   </span> </td>
      @else
      <td>Send to HoS<span> <a style="color: green;"  href="{{ route('store.materialtohos', [$matform->id]) }}" data-toggle="tooltip" title="Send to Head of Section"><i class="far fa-check-circle"></i></a>
                   </span> </td>
      @endif

      

      </tr>
      @endforeach
      </tbody>            
</table> 
<br>
          
         

                    @if(in_array("yes", $p))


                     <button class="btn btn-primary" > <a  href="/store/material_reserve/{{$wo->id}}"  style="color: white" > RESERVE AND SEND PURCHASING ORDER TO DES </a></button>  
                    @else
                     

                      <button   class="btn btn-warning"> <a href="/store/material_request/{{$wo->id}}" style="color: white" >NOTIFY HoS TO TAKE MATERIAL </a></button>


                        @endif

                        <br><br><br><br><br><br><br>
                        @else
<br>
<br>
<br>
<br>
<div align="center"> <h1>No Workorder Material accepted by Inspector of Work</h1></div>


                         @endif

                         </div>



                      <script>

                           $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });
                           </script>
                 @endsection