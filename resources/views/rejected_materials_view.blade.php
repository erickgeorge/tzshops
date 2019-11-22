@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')

      
       <?php use App\Material;
             
                        $materials = Material::get(); 
                     
                         ?>

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Material Rejected by Inspector of Work  </b></h3>
        </div>

      <!--<div class="col-md-6" align="left">
            <form method="GET" action="work_order_material_accepted" class="form-inline my-2 my-lg-0">
                From <input name="start" value="<?php
                //if (request()->has('start')) {
                   // echo $_GET['start'];
               // } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php// echo date('Y-m-d'); ?>">
                To <input value="<?php
                //if (request()->has('end')) {
                    //echo $_GET['end'];
               // } ?>"
                            // name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             //max="<?php //echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>-->


        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr class="container">
    <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
  

    <div class="container">
        @if(count($items) > 0)
             
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
        <th >No</th>
        
				<th >Workorder Detail</th>
				<th >Material Name</th>
				<th >Material Description</th>
        <th>Unit Measure</th>
				<th >Type</th>
				<th >Quantity</th>
                <th >Reason</th>
                <th>Action</th>
				<th >Status</th>
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                
                   
                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                     <td>{{ $item['material']->brand }}</td>
                    <td>{{ $item['material']->type }}</td>
					       <td>{{ $item->quantity }}</td>
                 @if($item->reason == NULL)
                 <td><span class="badge badge-info">No Reason</span></td>
                 @else
                   <td>
                      <a onclick="myfunc('{{ $item->reason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View Reason</span></a>  </td>
                                                                             @endif

                  @if($item->reason == NULL)
                  <td><span class="badge badge-warning">Approved</span></td>
                  @else
                    <td>
                          <div class="row">

                             &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<a style="color: green;"
                                       onclick="myfunc1( '{{ $item->id }}','{{ $item->quantity }}', '{{$item->name}}')"
                                       data-toggle="modal" data-target="#exampleModali" title="Edit"><i
                                                class="fas fa-edit"></i></a> &nbsp;&nbsp;
                            <form method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this Material from the list? ')"
                                          action="{{ route('material.delete', [$item->id]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        ><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                      </div>
                    </td>
                    @endif
                  
                       @if($item->reason == NULL)
                       <td><span class="badge badge-success">Accepted</span></td>
                       @elseif($item->status == 44)                                               
                       <td><span class="badge badge-warning">Edited..</span></td>
                       @else
                       <td><span class="badge badge-danger">Rejected</span></td>
                       @endif
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
     <!--<div class="container">    <button  type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalu">Send Material request again</button>
        </div>-->

        <br>
        <br>

           <div style="color: black; "> <h5> Request Material  again to inspector of work <span> <a style="color: green;" href="/send/material_rejected_again/{{$item->work_order_id}}"  data-toggle="tooltip" title="Request back to inspector of work"><i class="far fa-check-circle"></i></a>
                   </span> </h5></div> 

   
        
    </div>
     
   



    <!-- Modals-->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red">Reason as why Inspector of Work Rejecting Material Request.</h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h3 id="reason"><b> </b></h3>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!-- Modals-->

   <!--  <div class="modal fade" id="exampleModalu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div >
         <div class="modal-dialog" style="padding-right: 955px; background-color: white" role="document">
         <div class="modal-content">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-left:900px; ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                    <div class="modal-header ">
                     <div>
                        <h5  style="width: 900px;" id="exampleModalLabel">Request material again.</h5>
                        <hr>
                    </div>


                   
                </div>
                <div class="modal-body">
    <div class="container">  
     <form method="POST"  >
                    @csrf  
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >WorkOrder ID</th>
                <th >Workorder Detail</th>
                <th >Material Name</th>
                <th >Material Description</th>
                <th >Type</th>
                <th >previous quantity requested</th>
                <th >Request quantity again</th>  
            </tr>
            </thead>

            <tbody>
                

            <?php// $i=0;  ?>
            @foreach($items as $item)

                <?php// $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   <td>00{{ $item->work_order_id }}</td>
                   
                    <td>{{ $item['workorder']->details }}</td>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
                    <td>{{ $item->quantity }}</td>
                  
                    <td><input type="number"  style="color: black; width: 150px" name="quantity"  class="form-control"  rows="5" id="quantity"></input></td>
                    
                   
                                       
                    </tr>
                    @endforeach

            </tbody>

        </table>
        <hr>
        <br>

       <button style="background-color: darkgreen; color: white; width: 205px;" type="submit" class="btn btn-success">Request Material again</button>
         </form>
    </div>   
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>-->

<!-- Modal for edit material again-->



     <div class="modal fade" id="exampleModali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div >
         <div class="modal-dialog" style="padding-right: 655px; background-color: white" role="document">
         <div class="modal-content">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-left:600px; ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                    <div class="modal-header ">
                     <div>
                        <h5  style="width: 600px;" id="exampleModalLabel">Request material again.</h5>
                        <hr>
                    </div>  
                  </div>
                <div class="modal-body">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />


                   

                      <form method="POST" action="edit/Material/{{ $item->work_order_id }}" class="col-md-6">
                        @csrf
                       

                       <div class="form-group">
                            <select  required class="custom-select"  id="materialedit" name="material" style="width: 550px">
                                <option   selected value=" @foreach($items as $item)
  {{ $item['material']->id }}"> {{$item['material']->name }}, Brand: ({{ $item['material']->description }}), Value: ({{ $item['material']->brand }}), Type: ({{ $item['material']->type }})@endforeach</option>
                                @foreach($materials as $material)
                                   <option value="{{ $material->id }}">{{ $material->name.', Brand:('.$material->description.') ,Value:( '.$material->brand.' ) ,Type:( '.$material->type.' )' }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    
                         <div class="form-group">
                            <label for="name_of_house">Quantity <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:550px" type="number" required class="form-control"      id="editmaterial"
                                   name="quantity" placeholder="Enter quantity again">
                            <input id="edit_mat" name="edit_mat" hidden>
                         </div>
                                                    <div> 
                                                       <button style=" width: 205px;" type="submit" class="btn btn-primary">Save
                                                       </button>
                                                    </div>
                                         
                                            </form>


           
                  
                                                       <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


     <script type="text/javascript">

      $("#materialedit").select2({
            placeholder: "Choose materia..",
            allowClear: true
        });
     </script>

   
                </div>



                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>




    @else
            <h1 class="text-center" style="margin-top: 150px">You have no material rejected by Inspector of Work</h1>
        @endif
    <!-- End Modals-->




<!--end of material -->
<br>
<br>


     <div class="container">
        <script src=
"https://code.jquery.com/jquery-1.12.4.min.js">
    </script>
    <style type="text/css">
        .selectt {
            color: #fff;
            padding: 30px;
            margin-top: 30px;
            width: 100%;
           
        }
       
        label {
            margin-right: 20px;
        }
    </style>
</head>

<body>
    
       
  
      <!--  <div>
            <label>
                <input type="checkbox" name="colorCheckbox"
                    value="C"> <b>List of Edited Materials</b></label>
          
        </div>-->
        <div class="C selectt">


          <div class="container">
                 <div >
                
                        <?php
                        
                        use App\WorkOrderMaterial;
                        $wo_materials= WorkOrderMaterial::where('work_order_id',$wo->id)->where('status',23)->get();
                        
                        ?>
                        @if(count($wo_materials) > 0)
                       
                        <table class="table table-striped" style="width:100%">
  <tr>
     <th>No</th>
    <th>Material Name</th>
    <th>Material Description</th>
    <th>Unit Measure</th>
    <th>Type</th>
     <th>Quantity Requested</th>
   

  </tr>

  <?php $i=1; 
 

  ?>
    @foreach($wo_materials as $matform)
    
  <tr>
    <td>{{$i++}}</td>
    <td>{{$matform['material']->name }}</td>
     <td>{{$matform['material']->description }}</td>
      <td>{{$matform['material']->brand }}</td>
     <td>{{$matform['material']->type }}</td>
     <td>{{$matform->quantity }}</td>
     
  </tr>   
    @endforeach                                      
</table>   
    <button class="btn btn-primary"  > <a  href="/send/material_rejected_again/{{$wo->id}}"   > REQUEST MATERIAL AGAIN</a></button> 


</div>

</div>

@else
            <h1 class="text-center" style="margin-top: 150px">You have no material edited, Please edit your Materials and send again to Inspector of Work</h1>
        @endif




       </div>
       
        <script type="text/javascript">
            $(document).ready(function() {
                $('input[type="checkbox"]').click(function() {
                    var inputValue = $(this).attr("value");
                    $("." + inputValue).toggle();

                });
            });
        </script>
   
</body>
 
   
  

     
 <br>
        <br>
            <br>
<!--end of material -->
    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });
    
   

         function myfunc(x) {
            document.getElementById("reason").innerHTML = x;
        }




        function myfunc1(U, V, W) {


            document.getElementById("edit_mat").value = U;

            document.getElementById("editmaterial").value = V;

             document.getElementById("material").value = W;

       }

    </script>
    @endSection