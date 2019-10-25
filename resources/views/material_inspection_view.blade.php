@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')
<div class="container">
    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Work Orders that need material </b></h3>
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
            <thead class="thead-dark">
            <tr>
                <th >#</th>
              
                <th >Material Name</th>
                <th >Material Description</th>
                <th >Type</th>
                <th >Quantity</th>
                <th >Action</th>
                
                
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
                    <td>  <span> <a style="color: green;" href="{{ route('store.materialacceptonebyone', [$item->material_id]) }}"  data-toggle="tooltip" title="Accept"><i class="far fa-check-circle"></i></a>
                   </span>  &nbsp;&nbsp; <span> <a style="color: black;" title="Reject" data-toggle="modal" data-toggle= "tooltip" data-target="#exampleModal"><i class="fas fa-times-circle" style="color: red"></i></a>
                </span> </td>
                    </tr>



                    @endforeach


                </br>

                    <div> <h5> ACCEPT  <span> <a style="color: green;" href="{{ route('store.materialaccept', [$item->work_order_id]) }}"  data-toggle="tooltip" title="Accept"><i class="far fa-check-circle"></i></a>
                   </span>  &nbsp;&nbsp;&nbsp;&nbsp;  REJECT <span> <a style="color: black;" title="Reject" data-toggle="modal" data-toggle= "tooltip" data-target="#exampleModalu"><i class="fas fa-times-circle" style="color: red"></i></a>
                </span> </h5> </div> 
            </tbody>
        </table>
    </div>
    </div>


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
                    <p>Please provide reason as to why you want to reject material requested by Head of Section.</p>
                    <form method="POST"  action ="{{ route('store.materialreject', [$item->work_order_id]) }}"  >
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


        

        
         <script type="text/javascript">
        


    </script>

    @endSection