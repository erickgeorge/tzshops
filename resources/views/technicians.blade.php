@extends('layouts.master')

@section('title')
    technicians
    @endSection
@section('body')
<br>
    <div class="container" >
        <div class="col-lg-12">
             <h5 style="text-transform: capitalize;">All Technicians Details @if(((substr(auth()->user()->type,0,4) == 'HOS ')&&($role['user_role']['role_id'] != 1))) - {{ substr(auth()->user()->type,4,12) }} Section @endif</h5>
        </div>
    </div>
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

    <hr class="container">
    <div class="container">

   <?php
use App\User;
use App\Technician;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
use Carbon\Carbon;

$rle = Technician::where('status',0)->get();
$head = 'All Technicians Details';

 ?>

 @php
       $maintenance_coordinator = '';
       $niyeye = '1';
$hoos = user::select('type')->where('id',auth()->user()->id)->get();
foreach ($hoos as $hous) {
   $hotype = $hous->type;
        if(substr($hotype,0,4) == 'HOS '){

            $niyeye = '0';
          $placed = ltrim($hotype,'HOS ');
          }
          elseif(substr($hotype,0,4) != 'HOS '){
            $maintenance_coordinator = 1;
          }

          if(substr($hotype,0,4) == 'HOS '){
            echo '<a style="margin-left: 2%;" href="add/technician">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add New Technician</button></a> ';
            echo '<a style="margin-left: 2%;" href="deactivatedtechnicians">  <button  style="margin-bottom: 20px" type="button" class="btn btn-info">Deactivated Technicians</button></a> ';

          }
          elseif($hotype == 'Maintenance coordinator'){
            echo '<a style="margin-left: 2%;" href="add/technician">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add New Technician</button></a> ';
            echo '<a style="margin-left: 2%;" href="deactivatedtechnicians">  <button  style="margin-bottom: 20px" type="button" class="btn btn-info">Deactivated Technicians</button></a> ';


          }elseif($role['user_role']['role_id'] == 1){
            $niyeye = '1';
            echo '<a style="margin-left: 2%;" href="add/technician">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add New Technician</button></a> ';
            echo '<a style="margin-left: 2%;" href="deactivatedtechnicians">  <button  style="margin-bottom: 20px" type="button" class="btn btn-info">Deactivated Technicians</button></a> ';

          }else {
            $techs= Technician::where('status',0)->orderby('fname')->get();
            $niyeye = '1';
          }
}


 @endphp
 <br>
<!-- SOMETHING STRANGE HERE -->
 @if(!$techs->isEmpty())
<div align="right" style="margin-top: -60px;">

          <button style="max-height: 40px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
   Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button>
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('allpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>


  <div class="modal-body">
      <div class="row">
          <div class="col">
              <select name="type" class="form-control mr-sm-2">

 @if(($role['user_role']['role_id'] == 1))

<option value="" selected="">All Sections</option>
 @if($head == 'All Technicians Details')
<?php $to = Technician::where('status',0)->select('type')->distinct()->get(); $v='technician';
?>
@endif
@foreach($to as $too)
<option value="{{ $too->type }}">{{ ucwords(strtolower($too->type)) }}</option>
@endforeach
 @elseif($maintenance_coordinator == 1)
  <option value="" selected="">All Sections</option>
 @if($head == 'All Technicians Details')
<?php $to = Technician::where('status',0)->select('type')->distinct()->get(); $v='technician';
?>@endif
@foreach($to as $too)
<option value="{{ $too->type }}">{{ ucwords(strtolower($too->type)) }}</option>
@endforeach
 @else
@if($head == 'All Technicians Details')
<?php $to = Technician::where('status',0)->select('type')->distinct()->where('type','like','%'.$placed.'%')->get(); $v='technician';
?>
@endif
@foreach($to as $too)
<option value="{{ $too->type }}">{{ $too->type }}</option>
@endforeach
@endif          </select>
          </div>
      </div>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <select name="name" class="form-control mr-sm-2">

             <option value="" selected="selected">All Technicians</option>
  @foreach($rle as $tech)
      @if(($role['user_role']['role_id'] == 1))
          <option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} - {{ ucwords(strtolower($tech->type)) }}</option>
      @elseif($maintenance_coordinator == 1)
          <option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} - {{ ucwords(strtolower($tech->type)) }}</option>
      @else
          @if(strtolower($tech->type) == strtolower($placed))

          <option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} </option>
          @endif
      @endif
  @endforeach
              </select>
        </div>
        </div>
    </div>

      <input type="text" name="change"
      value="technician" hidden>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Export</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->
<br>
    @if(!$techs->isEmpty())
        <table class="table table-striped" id="myTable">
        <thead >
       <tr style="color: white;">
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th title="phone" scope="col">Phone</th>
            <th scope="col">Email</th>
            @if((auth()->user()->type == 'Estates Director'))
              <th scope="col">Section</th>
            @endif
            @if($role['user_role']['role_id'] != 1)
            @else
            <th scope="col">Section</th>@endif
        @if((substr(auth()->user()->type,0,4) == 'HOS ')||(auth()->user()->type == 'Maintenance coordinator')||($role['user_role']['role_id'] == 1))

         <th scope="col">Actions</th>
          @else

           @endif


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
                <td>

      <?php $phonenumber = $tech->phone;
        if(substr($phonenumber,0,1) == '0'){

          $phonreplaced = ltrim($phonenumber,'0');
          echo '+255'.$phonreplaced;

        }else { echo $tech->phone;}

      ?></td>
                <td>{{ $tech->email }}</td>
               @if((auth()->user()->type == 'Estates Director'))
              <td>{{ ucwords(strtolower($tech->type)) }}</td>
            @endif
             @if($role['user_role']['role_id'] != 1)  @else <td>{{ ucwords(strtolower($tech->type)) }}</td>@endif
                @if((substr(auth()->user()->type,0,4) == 'HOS ')||(auth()->user()->type == 'Maintenance coordinator')||($role['user_role']['role_id'] == 1))

                <td class="text-center">
                    <div class="row">
                        <a style="color: green;" href="{{ route('tech.edit.view', [$tech->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>

                        <form  method="POST" onsubmit="return confirm('Are you sure you want to deactivate this Technician?')" action="{{ route('tech.delete', $tech->id) }}" >
                            {{csrf_field()}}
                            <button type="submit" data-toggle="tooltip" title="Deactivate"> <a style="color: red;" href="" data-toggle="tooltip" ><i class="fas fa-trash-alt"></i></a></button>
                        </form>
                    </div>
                </td>
                 @else

                  @endif

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
