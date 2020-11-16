@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')
<div class="container">
    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12"  >
            <h5 style="  "><b  >Available Materials in Store </b></h5>
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
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
           <a href="" data-toggle="modal" class="btn btn-primary mb-2" data-target="#exampleModal">  Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i> </a>
        </div>
        @endif
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('materialpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="name" id="nameMAT" onchange="getnameMAT()"  class="form-control mr-sm-2">
                    <option selected="selected" value="">Item ID</option>
                    <?php $name = Material::select('name')->distinct()->get();
                    foreach ($name as $named) {
                     echo"   <option value='".$named->name."'>".ucwords(strtolower($named->name))."</option>";
                    } ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="description" onchange="getdescriptionMAT()"   id="descriptionMAT" class="form-control mr-sm-2">
                    <option selected="selected" value=""> Material Description</option>
                    <?php $brand = Material::select('description')->distinct()->get();
                    foreach ($brand as $branded) {
                     echo"   <option value='".$branded->description."'>".ucwords(strtolower($branded->description))."</option>";
                    } ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="brand" id="brandMAT" onchange="getbrandMAT()" class="form-control mr-sm-2">
                    <option selected="selected" value=""> Unit Measure</option>
                    <?php $brand = Material::select('brand')->distinct()->get();
                    foreach ($brand as $item) {
                     echo"   <option value='".$item->brand."'>".ucwords(strtolower($item->brand))."</option>";
                    } ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="type" id="typeMAT" onchange="gettypeMAT()" class="form-control mr-sm-2">
                    <option value="">Material Type</option>
                    <?php $type = Material::select('type')->distinct()->get();
                    foreach ($type as $typed) {
                     echo"   <option value='".$typed->type."'>".ucwords(strtolower($typed->type))."</option>";
                    } ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Export</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->
    </div>
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
          <tr style="color: white;">
               <th >#</th>
                <th >Item ID</th>
                <th >Material Description</th>
                <th >Unit of Measure</th>
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
                    <td>{{ ucwords(strtolower($item->name)) }}</td>
                    <td id="wo-details">{{ ucwords(strtolower($item->description)) }}</td>
                     <td>{{ ucwords(strtolower($item->brand)) }}</td>
                    <td>{{  ucwords(strtolower($item->type)) }}</td>


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
</div>

    @endSection
