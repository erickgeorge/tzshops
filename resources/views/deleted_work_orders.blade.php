@extends('layouts.master')

@section('title')
    work orders
    @endSection
@section('body')
<?php use App\workorder; ?>

<div class="container">
    <br>
     @if(count($wo) > 0)
    <div class="row container-fluid"  style="margin-left:2%; margin-right:2%;">
        <div class="col-md-8">
            <h5 style="text-transform: capitalize;" >Rejected works orders</h5>
        </div>
    </div>
    <hr>






        <table class="table table-hover  table-responsive table-striped table-condensed table-scrollable" id="myTable">
            <thead >
           <tr style="color: white;">
                <th scope="col">#</th>
		<th scope="col">ID</th>
                <th scope="col">Details</th>
                <th scope="col">Type</th>
                <th scope="col">From</th>
                <th scope="col">Status</th>
                <th scope="col">Created date</th>
                <th scope="col">Location</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>

            <tbody>

            <?php $i = 0;  ?>
            @foreach($wo as $work)
                <?php $i++ ?>

                <tr>
                    <th scope="row">{{ $i }}</th>
		   <th scope="row">00{{ $work->id }}</th>
                    <td id="wo-details">{{ $work->details }}</td>
                    <td>{{ $work->problem_type }}</td>
                    <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                    <td><span class="badge badge-danger">rejected</span></td>
                    <td><?php $time = strtotime($work->created_at); echo date('d/m/Y',$time);  ?></td>
                    <td>
                        @if($work->location ==null)
                            {{ $work['room']['block']->location_of_block }}
                    @else

                            {{ $work->location }}
                    @endif
                    </td>
                    <td>
                        <a onclick="myfunc('{{ $work->reason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h1 class="text-center" style="margin-top: 150px">You have no rejected works orders</h1>
        <div class="container" align="center">
            <br>
            <div class="col-sm-3">
              <a href="{{ url('work_order') }}" class="btn btn-primary">Return to works orders</a>
            </div>
          </div>
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reason for rejecting work order</h5>
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
</div>
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
    </script>
    @endSection
