@extends('layouts.master')

@section('title')
   Material Entry
    @endSection

@section('body')
<?php use App\User; ?>
    <br>
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h5 style="text-transform: capitalize;" ><b style="text-transform: capitalize;">Procured materials list</b></h5>
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
 <?php  $procured_by = $produced->added_by;
		$tag_ = $produced->tag_;
?>
    	 @endforeach
    	 <div class="row">
       <div class="col"> Added By: <?php $officer = User::where('id',$procured_by )->get(); ?>
                            	@foreach($officer as $offier) {{ $offier->fname }} {{ $offier->lname }} @endforeach
</div>
<div class="col"> on :
                            	<?php $time = strtotime($tag_); echo date('d/m/Y',$time);  ?>
 </div>
<div class="col-lg-2">
    		<a href="{{ url('materialEntrypdf',$tag_) }}" class="btn btn-primary"> Export <i class="fa fa-file-pdf-o"></i> </a>
    	</div>
    </div>
</div>
    <div class="container">
        @if(count($procured) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead >
             <tr style="color: white;">
                    <th>#</th>
          			<th>Material name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Unit Measure</th>

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
                            <td>{{ $material->type }}</td>
                            <td> {{ $material->total_input }}</td>
                            <td>{{ $material->unit_measure }}</td>

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
