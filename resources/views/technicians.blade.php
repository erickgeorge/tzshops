@extends('layouts.master')

@section('title')
    technicians
    @endSection
@section('body')
    
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h3 align="center">Available Technicians</h3>
        </div>
    </div>
    <div class="container">
    @if(Session::has('message'))
        <br>
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
    </div>
    
    <hr class="container">
    <div class="container">
    <a style="margin-left: 2%;" href="{{ url('add/technician') }}">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new technician</button></a>    <?php
use App\User;
use App\Technician;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
use Carbon\Carbon;

$rle = Technician::get();
$head = 'All Technicians Details';

 ?>
<!-- SOMETHING STRANGE HERE -->
 @if(!$techs->isEmpty())
<div align="right" style="margin-top: -60px;">
          @if(auth()->user()->type == 'CLIENT')
          <button style="max-height: 40px;" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
  <i class="fa fa-file-pdf-o"></i> PDF
</button>
       @else
          <button style="max-height: 40px;" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
  <i class="fa fa-file-pdf-o"></i> PDF
</button>
@endif
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('allpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>
      <?php
      $maintenance_coordinator = '';
$hoos = user::select('type')->where('id',auth()->user()->id)->get();
foreach ($hoos as $hous) {
   $hotype = $hous->type;
        if(substr($hotype,0,4) == 'HOS '){

          $placed = ltrim($hotype,'HOS ');
          }
          elseif($hotype == 'Maintenance coordinator'){
            $maintenance_coordinator = 1;
          }
}
?>
    <div class="modal-body">
      <div class="row">
        <div class="col">
          <select name="name" class="form-control mr-sm-2">
                <option value="" selected="selected">All Technicians</option>
@foreach($rle as $tech)
 @if(($role['user_role']['role_id'] == 1))
 <option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} - {{ $tech->type }}</option>
 @elseif($maintenance_coordinator == 1)
  <option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} - {{ $tech->type }}</option>
 @else
@if($tech->type == $placed)

<option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} - {{ $tech->type }}</option>
@endif
@endif
@endforeach
            </select>
      </div>
      </div>
  </div>

  <div class="modal-body">
      <div class="row">
          <div class="col">
              <select name="type" class="form-control mr-sm-2">
            
 @if(($role['user_role']['role_id'] == 1))
 
<option selected="">All Sections</option>
 @if($head == 'All HOS Details')
<?php $to = user::select('type')->distinct()->where('type','like','%HOS%')->get(); $v='hos'; ?>
@elseif($head == 'All Technicians Details')
<?php $to = Technician::select('type')->distinct()->get(); $v='technician';

?>
@elseif($head == 'All Inspectors of work Details')
<?php $to = user::select('type')->distinct()->where('type','like','%Inspector%')->get(); $v = 'iow';?>
@endif
@foreach($to as $too)
<option value="{{ $too->type }}">{{ $too->type }}</option>

@endforeach
 @elseif($maintenance_coordinator == 1)
  <option selected="">All</option>
 @if($head == 'All HOS Details')
<?php $to = user::select('type')->distinct()->where('type','like','%HOS%')->get(); $v='hos'; ?>
@elseif($head == 'All Technicians Details')
<?php $to = Technician::select('type')->distinct()->get(); $v='technician';

?>
@elseif($head == 'All Inspectors of work Details')
<?php $to = user::select('type')->distinct()->where('type','like','%Inspector%')->get(); $v = 'iow';?>
@endif
@foreach($to as $too)
<option value="{{ $too->type }}">{{ $too->type }}</option>

@endforeach
 @else             
@if($head == 'All HOS Details')
<?php $to = user::select('type')->distinct()->where('type','like','%HOS%')->get(); $v='hos'; ?>
@elseif($head == 'All Technicians Details')
<?php $to = Technician::select('type')->distinct()->where('type','like','%'.$placed.'%')->get(); $v='technician';

?>
@elseif($head == 'All Inspectors of work Details')
<?php $to = user::select('type')->distinct()->where('type','like','%Inspector%')->get(); $v = 'iow';?>
@endif
@foreach($to as $too)
<option selected="selected" value="{{ $too->type }}">{{ $too->type }}</option>

@endforeach
@endif          </select>
          </div>
      </div>
      </div>
      
      <input type="text" name="change"
      value="<?php echo $v; ?>" hidden>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->

    @if(!$techs->isEmpty())
        <table class="table table-striped" id="myTable">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th title="phone" scope="col">Phone</th>
            <th scope="col">Section</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php

        if (isset($_GET['page'])){
            if ($_GET['page']==1){

                $i=1;
            }else{
                $i = ($_GET['page']-1)*5+1; }
        }
        else {
            $i=1;
        }
        $i=1;

        ?>
        @foreach($techs as $tech)
            <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>{{ $tech->fname . ' ' . $tech->lname }}</td>
                <td>{{ $tech->email }}</td>
                <td>

      <?php $phonenumber = $tech->phone;
        if(substr($phonenumber,0,1) == '0'){

          $phonreplaced = ltrim($phonenumber,'0');
          echo '+255'.$phonreplaced;
          
        }else { echo $tech->phone;}

      ?></td>
                <td>{{ $tech->type }}</td>
                <td>
                    <div class="row">
                        <a style="color: green;" href="{{ route('tech.edit.view', [$tech->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>

                        <form  method="POST" onsubmit="return confirm('Are you sure you want to delete this Technician?')" action="{{ route('tech.delete', $tech->id) }}" >
                            {{csrf_field()}}
                            <button type="submit" data-toggle="tooltip" title="Delete"> <a style="color: red;" href="" data-toggle="tooltip" ><i class="fas fa-trash-alt"></i></a></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>


        </table>
    </div>
    @endif
    <script>
        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();
            $('#myTable').DataTable({
                "drawCallback": function ( settings ) {
                    /*show pager if only necessary
                     console.log(this.fnSettings());*/
                    if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
                        $('#dataTable_ListeUser_paginate').css("display", "block");
                    } else {
                        $('#dataTable_ListeUser_paginate').css("display", "none");
                    }

                }
            });


            jQuery('#myTable').DataTable({
                fnDrawCallback: function(oSettings) {
                    var totalPages = this.api().page.info().pages;
                    if(totalPages <= 1){
                        jQuery('.dataTables_paginate').hide();
                    }
                    else {
                        jQuery('.dataTables_paginate').show();
                    }
                }
            });
        });
    </script>
    @endSection