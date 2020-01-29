@extends('layouts.master')

@section('title')
    Procurement History
    @endSection

@section('body')

<?php use App\User; ?>
    <br>
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h3 style="padding-left: 90px;"><b>Procured material History </b></h3>
        </div>
       
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
    <div class="container">
    	 @foreach($procured as $produced)
 <?php  $procured_by = $produced->procured_by;
		$tag_ = $produced->tag_;
		$store_received = $produced->store_received
?>
    	 @endforeach
    	 <div class="row">
       <div class="col"> Added By: <?php $officer = User::where('id',$procured_by )->get(); ?>
                            	@foreach($officer as $offier) {{ $offier->fname }} {{ $offier->lname }} @endforeach
</div>
<div class="col"> on :
                            	<?php $time = strtotime($tag_); echo date('d/m/Y',$time);  ?>
 </div>
 <div class="col"> status: 
                            @if( $store_received== 0)
                            	<div class="badge badge-warning">Not Confirmed by store</div>
                            	@else<div class="badge badge-success">Received by store</div>
                            	@endif
                            </div>
    </div>
</div>
    <div class="container">
        @if(count($procured) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
          			<th>Material name</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Unit Measure</th>
                    <th>Price</th>

                </tr>
                </thead>

                <tbody>
                <?php $i = 0;  ?>
                @foreach($procured as $material)

                    
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-id">{{ $material->material_name }}</td>
                            <td id="wo-details">{{ $material->material_description }}</td>
                            <td> {{ $material->total_input }}</td>
                            <td>{{ $material->unit_measure }}</td>
 							<td>{{ $material->price_tag }}</td>
                             
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">No Procured Materials Available</h1>
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