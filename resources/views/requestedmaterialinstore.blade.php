   @extends('layouts.master')

   @section('title')
    Accepted Material by Iow
    @endSection

@section('body')


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

<div ><h5 style=" "><b style="text-transform: capitalize;">Material accepted by inspector of works</b></h5></div>

<br>
<hr>


                         <table class="table table-striped display" id="myTable" style="width:100%">
                <thead >
  <tr style="color: white;">
    <th>No</th>
    <th>Material Name</th>
    <th>Material Description</th>
    <th>Type</th>
     <th>Quantity Requested</th>
      <th>Quantity in Store</th>
      <th>Quantity Reserved</th>

       <th>Quantity to Purchase</th>
       <th>Action</th>


  </tr>
</thead>

  <?php $k=0; $i=1;
  $p= array("t");
  ?>

  <tbody>

    @foreach($wo_materials as $matform)
    <?php $k++?>
     <tr>
    <td>{{$k}}</td>
    <td>{{$matform['material']->name }}</td>
     <td>{{$matform['material']->description }}</td>
    <td>{{$matform['material']->type }}</td>
     <td>{{number_format($matform->quantity) }}</td>
    <?php  $x=$matform['material']->stock - $matform['material']->quantity_reserved; ?>
     @if($x<=0)
      <td>0</td>
      @else
      <td>{{number_format($matform['material']->stock  - $matform['material']->quantity_reserved) }}</td>
      @endif



     @if(($matform['material']->stock- $matform['material']->quantity_reserved)>=($matform->quantity))
          <td>{{number_format($matform->quantity) }}</td>


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
      <td style="color: blue;"><span> <a style="color: blue;"  href="{{ route('store.material.reserve', [$matform->id]) }}" data-toggle="tooltip" title="Reserve and Send to Head of Procurement"><i class="fas fa-retweet"></i></a>
                   </span> </td>
      @else
      <td><span> <a style="color: green;"  href="{{ route('store.materialtohos', [$matform->id]) }}" data-toggle="tooltip" title="Send to Head of Section"><i class="far fa-check-circle"></i></a>
                   </span> </td>
      @endif



      </tr>
      @endforeach
      </tbody>
</table>
<br>



                    @if(in_array("yes", $p) and (in_array("no", $p)))


                    
                    @elseif(in_array("yes", $p))

                     <button class="btn btn-primary" > <a  href="/store/material_reserve/{{$wo->id}}"  style="color: white" > Reserve and send purchasing order </a></button>
                     
                    @else


                      <button   class="btn btn-success"> <a href="/store/material_request/{{$wo->id}}" style="color: white" >Notify HoS to take material in store</a></button>


                     @endif

                        <br><br><br><br><br><br><br>
                     @else
<br>
<br>
<br>
<br>
<div align="center"> <h2>Currently no works order material accepted by Inspector of Works.</h2></div>


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
