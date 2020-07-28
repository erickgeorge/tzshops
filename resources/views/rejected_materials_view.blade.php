@extends('layouts.master')

@section('title')
    works orders
    @endSection

@section('body')


       <?php
       use App\Material;
    $materials = Material::get();

                         ?>

    <br>
     @if(count($items) > 0)
    <div class="row container-fluid">
       @if(auth()->user()->type != 'Inspector Of Works')
        <div class="col-lg-12">
            <h5 style=" "  ><b style="text-transform: capitalize;">Material Rejected by Inspector of Works  </b></h5>
        </div>
        @else
        <div class="col-lg-12">
            <h5 align="center"><b>REJECTED MATERIAL </b></h5>
        </div>
        @endif

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


        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead>
           <tr style="color: white;">
        <th >No</th>


				<th >Material Name</th>
				<th >Material Description</th>
        <th>Unit Measure</th>
				<th >Type</th>
				<th >Quantity</th>
                <th >Reason</th>
                @if(auth()->user()->type != 'Inspector Of Works')
                <th>Action</th>
                @endif
				<th >Status</th>

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
                  @if(auth()->user()->type != 'Inspector Of Works')
                    <td>
                          <div class="row">

                             &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<a style="color: green;"
                                       onclick="myfunc1( '{{ $item->id }}','{{ $item->quantity }}', '{{$item->name}}')"
                                       data-toggle="modal" data-target="#exampleModali" title="Edit"><i
                                                class="fas fa-edit"></i></a> &nbsp;&nbsp;
                            <form method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this Material from the list? ')"
                                          action="{{ route('material.delete', [$item->id , $item->work_order_id ]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        ><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                      </div>
                    </td>
                    @else
                    <td><span class="badge badge-danger">Rejected</span></td>
                    @endif
                    @endif
                    @if(auth()->user()->type != 'Inspector Of Works')

                       @if($item->reason == NULL)
                       <td><span class="badge badge-success">Accepted</span></td>
                       @elseif($item->status == 44)
                       <td><span class="badge badge-warning">Edited..</span></td>
                       @elseif($item->status == 17)
                       <td><span class="badge badge-danger">Rejected</span>
                               @if($item->matedited == 1)
                       <span class="badge badge-danger">Again</span>
                               @endif
                       </td>
                       @else
                       <td><span class="badge badge-danger">Rejected</span></td>
                       @endif
                    @endif

                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>


        <br>
        <br>
          @if($item->check_return == NULL)
          @if(auth()->user()->type != 'Inspector Of Works')
           <div style="color: black; "> <h5> Resend material request back to inspector of works <span> <a style="color: green;" href="/send/material_rejected_again/{{$item->work_order_id}}"  data-toggle="tooltip" title="Request back to inspector of works"><i class="far fa-check-circle"></i></a>
                   </span> </h5></div>  @endif
                   @endif



    </div>





    <!-- Modals-->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red">Reason of Rejecting Material Request.</h5>
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
             



                      <form method="POST" action="edit/Material/{{ $item->work_order_id }}" class="col-md-6">
                        @csrf


                       <div class="form-group">
                            <select  required class="custom-select"  id="materialedit" name="material" style="width: 550px">
                                <option   selected value=" @foreach($items as $item)
  {{ $item['material']->id }}"> {{$item['material']->name }}, Description: ({{ $item['material']->description }}), Value: ({{ $item['material']->brand }}), Type: ({{ $item['material']->type }})@endforeach</option>
                                @foreach($materials as $material)
                                   <option value="{{ $material->id }}">{{ $material->name.', Description:('.$material->description.') ,Value:( '.$material->brand.' ) ,Type:( '.$material->type.' )' }}</option>
                                @endforeach
                            </select>
                        </div>


                         <div class="form-group">
                            <label for="name_of_house">Quantity  </label>
                            <input style="color: black;width:550px" type="number" required class="form-control"      id="editmaterial"
                                   name="quantity" placeholder="Enter quantity again">
                            <input id="edit_mat" name="edit_mat" hidden>
                         </div>
                                                    <div>
                                                       <button style=" width: 205px;" type="submit" class="btn btn-primary">Save
                                                       </button>
                                                    </div>

                                            </form>




                                       




                </div>



                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>




    @else
            <h4 class="text-center" style="margin-top: 150px ; text-transform: uppercase;">no material rejected by Inspector of Works</h4>
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

            $('#myTableeee').dataTable({
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
