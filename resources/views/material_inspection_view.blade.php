@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

@if(auth()->user()->type == 'Maintenance coordinator')

@if(count($mcitems) > 0)

<div class="container">
    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h5  ><b>Materials Needed For Works Order </b></h5>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr>
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif


    <div class="container " style="margin-right: 2%; margin-left: 2%;">
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
            <tr style="color: white;">
                <th >#</th>

                <th >Material Name</th>
                <th >Material Description</th>
                <th>Unit Measure</th>
                <th >Type</th>
                <th >Quantity</th>
                <th >Action</th>
                <th >Status</th>


            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>



            @foreach($mcitems as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->brand }}</td>

                    <td>{{ $item['material']->type }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>   <span>

                        &nbsp;&nbsp;&nbsp;&nbsp;<a style="color: green;"
                                       onclick="myfunc1( '{{ $item->id }}','{{ $item->reason }}')"



                                       data-toggle="modal" data-target="#exampleModali" title="reject"><i
                       class="fas fa-times-circle" style="color: red"></i></a>


                        <!--<a style="color: black;" title="Reject" data-toggle="modal" data-toggle= "tooltip" data-target="#exampleModal"><i class="fas fa-times-circle" style="color: red"></i></a>-->
                    </span> </td>
                    @if($item->matedited == 1)
                    <td><span class="badge badge-warning">Edited</span>
                        @if($item->status > $item->matedited) <br>
                        <span class="badge badge-danger">Rejected Again</span>
                        @endif
                    </td>
                    @elseif($item->status == 9)
                    <td><span class="badge badge-danger">Rejected</span></td>
                    @elseif($item->status == 0)
                    <td><span class="badge badge-primary">Waiting</span></td>
                    @endif
                    </tr>
                    @endforeach
                </tbody>
                   </table>
                </br>

                    <div>
              @if($item->check_return == NULL)
                     <h5>Accept and send to Store Manager <span> <a style="color: green;" href="{{ route('store.materialacceptmc', [$item->work_order_id , $item->zone] ) }}"  data-toggle="tooltip" title="Send to store Manager"><i class="far fa-check-circle"></i></a>
                   </span>

                 &nbsp;&nbsp;&nbsp;&nbsp;  Reject all material <span> <a style="color: black;" title="Reject all Material" data-toggle="modal" data-toggle= "tooltip" data-target="#exampleModalu"><i class="fas fa-times-circle" style="color: red"></i></a>
                </span>

              @endif

              @if($item->check_return != NULL)

               <h5 style="padding-left: 600px;"> Return to HoS with accepted and rejected Material <span > <a style="color: green;" href="{{ route('store.materialaccept.reject', [$item->work_order_id]) }}"  data-toggle="tooltip" title="Return to HoS"><i class="fas fa-times-circle" style="color: red"></i></a>
                   </span></h5>
                   @endif




                   </h5> </div>

                   <br>   <br>    <br>




  <div class="modal fade" id="exampleModalu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" >Not satisfied with material requested</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject all material requested by Head of Section.</p>
                    <form method="POST"  action ="{{ route('store.materialreject', [$item->work_order_id]) }}"  >
                        @csrf
                        <textarea name="reason" required maxlength="400" class="form-control"  rows="5" id="reason" placeholder="Enter Reason for rejecting all material... "></textarea>
                        <br>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


  <!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" >Not satisfied with material requested</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject this material requested by Head of Section.</p>
                    <form method="POST"  action ="{{ route('store.materialrejectonebyone', [$item->material_id]) }}"  >
                        @csrf
                        <textarea name="reason" required maxlength="400" class="form-control"  rows="5" id="reason"></textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


                -->





    <div class="modal fade" id="exampleModali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" >Not satisfied with material requested</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject this material requested by Head of Section.</p>
                   <form method="POST"   action="{{ route('material_onebyone',[$item->work_order_id ])}}" class="col-md-6">
                        @csrf


                         <div class="form-group">
                          <textarea style="overflow: auto; width: 420px;" name="reason" required maxlength="400" class="form-control"  rows="5" id="editmaterial" wrap="off" placeholder="Enter Reason for rejecting this material...">
                          </textarea>
                            <input id="edit_mat" name="edit_mat" hidden>
                         </div>


                        <br>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


   @else
               <div class="container" align="center">

                   <br><div> <h2 style="padding-top: 300px;">Currently No Material needed for Works order</h2></div>

            </div>
                   @endif




                   <script type="text/javascript">

                         function myfunc1(U, V, W) {


            document.getElementById("edit_mat").value = U;

            document.getElementById("editmaterial").value = V;

             document.getElementById("material").value = W;

       }
                   </script>
@endif
@if(auth()->user()->type == 'Inspector Of Works')
@if(count($items) > 0)

<div class="container">
    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
             <h5  ><b>Materials Needed For Works Order </b></h5>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr>
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif


    <div class="container " style="margin-right: 2%; margin-left: 2%;">
        <table class="table table-striped display" id="myTablee"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >#</th>

                <th >Material Name</th>
                <th >Material Description</th>
                <th>Unit Measure</th>
                <th >Type</th>
                <th >Quantity</th>
                <th >Action</th>
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
                    <td>   <span>

                        &nbsp;&nbsp;&nbsp;&nbsp;<a style="color: green;"
                                       onclick="myfunc1( '{{ $item->id }}','{{ $item->reason }}')"



                                       data-toggle="modal" data-target="#exampleModali" title="reject"><i
                       class="fas fa-times-circle" style="color: red"></i></a>


                        <!--<a style="color: black;" title="Reject" data-toggle="modal" data-toggle= "tooltip" data-target="#exampleModal"><i class="fas fa-times-circle" style="color: red"></i></a>-->
                    </span> </td>
                    @if($item->matedited == 1)
                    <td><span class="badge badge-warning">Edited</span>
                        @if($item->status > $item->matedited) <br>
                        <span class="badge badge-danger">Rejected Again</span>
                        @endif
                    </td>
                    @elseif($item->status == 9)
                    <td><span class="badge badge-danger">Rejected</span></td>
                    @elseif($item->status == 0)
                    <td><span class="badge badge-primary">Waiting</span></td>
                    @endif
                    </tr>
                    @endforeach
                </tbody>
                   </table>


                </br>

                    <div>


                  @if($item->check_return == NULL)

                     <h5>Accept and send to Store Manager <span> <a style="color: green;" href="{{ route('store.materialaccept', [$item->work_order_id]) }}"  data-toggle="tooltip" title="Send to store Manager"><i class="far fa-check-circle"></i></a>
                   </span>




                 &nbsp;&nbsp;&nbsp;&nbsp;  Reject all material <span> <a style="color: black;" title="Reject all Material" data-toggle="modal" data-toggle= "tooltip" data-target="#exampleModalu"><i class="fas fa-times-circle" style="color: red"></i></a>
                </span>

              @endif


              @if($item->check_return != NULL)

               <h5 style="padding-left: 600px;"> Return to HoS with accepted and rejected Material <span > <a style="color: green;" href="{{ route('store.materialaccept.reject', [$item->work_order_id]) }}"  data-toggle="tooltip" title="Return to HoS"><i class="fas fa-times-circle" style="color: red"></i></a>
                   </span></h5>

              @endif




                   </h5> </div>

                   <br>   <br>    <br>








  <div class="modal fade" id="exampleModalu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" >Not satisfied with material requested</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject all material requested by Head of Section.</p>
                    <form method="POST"  action ="{{ route('store.materialreject', [$item->work_order_id]) }}"  >
                        @csrf
                        <textarea name="reason" required maxlength="400" class="form-control"  rows="5" id="reason" placeholder="Enter Reason for rejecting all material... "></textarea>
                        <br>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


  <!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" >Not satisfied with material requested</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject this material requested by Head of Section.</p>
                    <form method="POST"  action ="{{ route('store.materialrejectonebyone', [$item->material_id]) }}"  >
                        @csrf
                        <textarea name="reason" required maxlength="400" class="form-control"  rows="5" id="reason"></textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


                -->





    <div class="modal fade" id="exampleModali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" >Not satisfied with material requested</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please provide reason as to why you want to reject this material requested by Head of Section.</p>
                   <form method="POST" action="reject/Material/{{ $item->work_order_id }}" class="col-md-6">
                        @csrf


                         <div class="form-group">
                          <textarea style="overflow: auto; width: 420px;" name="reason" required maxlength="400" class="form-control"  rows="5" id="editmaterial" wrap="off" placeholder="Enter Reason for rejecting this material...">
                          </textarea>
                            <input id="edit_mat" name="edit_mat" hidden>
                         </div>


                        <br>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


   @else
               <div class="container" align="center">

                   <br><div> <h2 style="padding-top: 300px;">Currently No Material needed for Works order</h2></div>

            </div>
                   @endif




                   <script type="text/javascript">

                         function myfunc1(U, V, W) {


            document.getElementById("edit_mat").value = U;

            document.getElementById("editmaterial").value = V;

             document.getElementById("material").value = W;

       }
                   </script>
 @endif
    @endSection
