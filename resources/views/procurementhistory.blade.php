@extends('layouts.master')

@section('title')
    Procurement History
    @endSection

@section('body')

<?php use App\User; ?>
    <br>
    <div class="row container-fluid" style=" margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
             <h5 style="text-transform: capitalize;"><b>@if(auth()->user()->type == 'Head Procurement') Procurement Entry History @else Procured Materials @endif </b></h5>
        </div>
@if(count($procured) > 0)
        <div class="col-md-6">
            <form method="GET" action="ProcurementHistory" class="form-inline my-2 my-lg-0">
                From <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>

@endif
@if((count($procured) < 1)&&(isset($_GET['start'])))
        <div class="col-md-6">
            <form method="GET" action="ProcurementHistory" class="form-inline my-2 my-lg-0">
                From <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
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
    @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger" style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><?php echo $error; ?></li>
                @endforeach
            </ul>
        </div>
    @endif

    </div>
    @if(auth()->user()->type == 'Head Procurement')
    <div id="div_print" class="container">
        <div class="row ">
        <div class="col">
            <a href="{{ url('procurementAddMaterial') }}">
                <button style="margin-bottom: 20px" type="button" class="btn btn-success">Add new procured materials</button>
            </a>
        </div>
    </div>
    </div>
    @endif
    <div class="container">
        @if(count($procured) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead >
                <tr style="color: white;">
                    <th>#</th>
          			<th>Date</th>
                    <th>Total Entries</th>
                    <th>Status</th>
                    <th>@if(auth()->user()->type == 'Head Procurement')Added By @else Sent By @endif</th>
                    <th>Action</th>

                </tr>
                </thead>

                <tbody>
                <?php $i = 0;  ?>
                @foreach($procured as $material)


                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-id"><?php $time = strtotime($material->tag_); echo date('d/m/Y',$time);  ?></td>
                            <td id="wo-details">{{ number_format($material->total_materials) }}</td>
                            <td>@if($material->store_received != 0)
                            	<div class="badge badge-warning">@if(auth()->user()->type == 'Head Procurement') Not Received by store @else Not Confirmed @endif</div>
                            	@else<div class="badge badge-success">@if(auth()->user()->type == 'Head Procurement') Received by store @else Received @endif</div>
                            	@endif

                                @if($material->stored == null)
                                @if(auth()->user()->type == 'Head Procurement')  @else <div class="badge badge-warning"> Not Added in Stock </div> @endif
                                @else @if(auth()->user()->type == 'Head Procurement') @else <div class="badge badge-success"> In Stock </div> @endif
                                @endif

                        	</td>
                            <td><?php $officer = User::where('id',$material->procured_by)->get(); ?>
                            	@foreach($officer as $offier) {{ $offier->fname }} {{ $offier->lname }} @endforeach
                            </td>
 							<td><a href="{{ url('procuredMaterials',$material->tag_) }}"><button class="btn btn-success"><i class="fa fa-eye"></i></button></a></td>

                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">No Procured Materials Found</h1>
            <div class="container" align="center">
              <br>
           <!-- <div class='row'>
              <div class="col-sm-3">
                <a href="{{ url('dashboard') }}" class="btn btn-primary">Dashboard</a>
              </div>
            </div>-->
            </div>
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
