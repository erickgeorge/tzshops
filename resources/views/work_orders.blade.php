@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-md-6">
            <h3><b>Work orders list </b></h3>
        </div>

        @if(count($wo) > 0)
        <div class="col-md-6">
            <form method="GET" action="work_order" class="form-inline my-2 my-lg-0">
                <div class="row">
                    <input name="start" value="<?php
                    if (request()->has('start')) {
                        echo $_GET['start'];
                    } ?>" required class="form-control mr-sm-2" type="month" placeholder="Start Month">
                    <input value="<?php
                    if (request()->has('end')) {
                        echo $_GET['end'];
                    } ?>"
                           name="end" required class="form-control mr-sm-2" type="month" placeholder="End Month">
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Filter</button>
                </div>
            </form>
        </div>
            @endif

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
    <div class="row ">
        <div class="col-md-3">
            <a href="{{url('createworkorders')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-success">Create new Work Order</button>
            </a>
        </div>
        <div class="col-md-6">
        </div>
        <div class="col-md-3">
            <a href="{{url('deleted/work/orders')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-danger">View rejected Work Orders
                </button>
            </a>
        </div>
    </div>
    <div class="container">


        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Status</th>
                    <th>Created date</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>

                <?php $i = 0;  ?>
                @foreach($wo as $work)

                    @if($work->status !== 0)
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-details">{{ $work->details }}</td>
                            <td>{{ $work->problem_type }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                            @if($work->status == -1)
                                <td><span class="badge badge-warning">new</span></td>
                            @else
                                <td><span class="badge badge-success">accepted</span></td>
                            @endif
                            <td>{{ $work->created_at }}</td>
                            <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}</td>
                            @else

                                {{ $work->location }}
                            @endif
                            <td>
                                @if(strpos(auth()->user()->type, "HOS") !== false)

                                    @if($work->status == -1)
                                        <a href=" {{ route('workOrder.view', [$work->id]) }} "><span
                                                    class="badge badge-success">View</span></a>
                                    @else

                                        <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                                        <a style="color: black;" href="" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                    @endif
                                @else
                                    @if($work->status == -1)
                                        <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                    @else
                                        <a href="" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>
                                        &nbsp;
                                        <a style="color: black;" href="" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>&nbsp;
                                    @endif
                                @endif

                                @endif
                            </td>
                        </tr>
                        @endforeach
                </tbody>

            </table>
            @else
            <h1 class="text-center" style="margin-top: 150px">You have no work oder</h1>
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
    @endSection