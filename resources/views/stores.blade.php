@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12" align="center">
            <h3><b>Available materials </b></h3>
        </div>
        
    </div>
    <br>
    <hr>
    <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    </div>
    
    <div class="container " >
        <div class="row ">
        <div class="col-lg-4">
            @if(auth()->user()->type == 'STORE')
             <a href="{{url('addmaterial')}} "><button style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new material</button></a>
@endif
        </div>
         <div class="col">
            @if(auth()->user()->type == 'STORE')
             <a href="{{ url('materialEntryHistory') }}"><button style="margin-bottom: 20px" type="button" class="btn btn-primary">Materials Entry History</button></a>
@endif
        </div>
       <!-- <div class="col" align="right">
            <a href="{{ url('work_order_material_missing') }}"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Material requests <b style="color:red; background-color: grey; padding: 4px; border-radius: 5px;">90</b></button></a>
        </div> -->
        
       <!-- <div class="col-md-3">
            <a href=""><button style="margin-bottom: 20px" type="button" class="btn btn-warning">View needed materials (10)</button></a>
        </div>  -->
        <!-- SOMETHING STRANGE HERE -->
             <?php
use App\Material;?>  
 @if(count($items)>0) <div class="col" align="right">
           <a href="" data-toggle="modal" class="btn btn-outline-primary mb-2" data-target="#exampleModal"><i class="fa fa-file-pdf-o"></i> PDF </a>
        </div>
        @endif
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('materialpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="name" class="form-control mr-sm-2">
                    <option selected="selected" value="">Material name</option>
                    <?php $name = Material::select('name')->distinct()->get();
                    foreach ($name as $named) {
                     echo"   <option value='".$named->name."'>".$named->name."</option>";
                    } ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="brand" class="form-control mr-sm-2">
                    <option selected="selected" value=""> material brand</option>
                    <?php $brand = Material::select('description')->distinct()->get();
                    foreach ($brand as $branded) {
                     echo"   <option value='".$branded->description."'>".$branded->description."</option>";
                    } ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="type" class="form-control mr-sm-2">
                    <option value="">material type</option>
                    <?php $type = Material::select('type')->distinct()->get();
                    foreach ($type as $typed) {
                     echo"   <option value='".$typed->type."'>".$typed->type."</option>";
                    } ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->
    </div>
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
               <th >#</th>
                <th >Name</th>
                <th >Description</th>
                <th >Unit Measure</th>
                <th >Type</th>
                <th >Current Stock</th>
                <th >Stock updated on</th>
                @if(auth()->user()->type == 'STORE')
                <th >action</th>
                @endif
                
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item->name }}</td>
                    <td id="wo-details">{{ $item->description }}</td>
                     <td>{{ $item->brand }}</td>
                    <td>{{ $item->type }}</td>
                   

                    <td><?php echo  number_format($item->stock); ?></td>
                    <td><?php $time = strtotime($item->updated_at); echo date('d/m/Y',$time);  ?> </td>
                    @if(auth()->user()->type == 'STORE') <td>
                        &nbsp;&nbsp;&nbsp;
                        <a style="color: green;" href="{{ route('storeIncrement.view', [$item->id]) }}"  data-toggle="tooltip" title="Increment material"><i class="fas fa-plus"></i></a>&nbsp;
                        <!--<a style="color: black;" href="" data-toggle="tooltip" title="Track"><i class="fas fa-tasks"></i></a>-->
                        </td>
                        @endif
                       
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endSection