@extends('layouts.master')

@section('title')
    {{ $head }}
    @endSection
@section('body')
    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center">{{ $head }}</h3>
        </div>
    </div>
    @if(Session::has('message'))
        <br>
        <p class="alert alert-success">{{ Session::get('message') }}</p>
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
    <br>
    <hr>

    <div class="container">
          
           
         <?php
use App\User;
use App\Technician;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
use Carbon\Carbon;
 ?>
<!-- SOMETHING STRANGE HERE -->
<div align="right">
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('allpdf') }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>
    <div class="modal-body">
      <div class="row">
        <div class="col">
          <select name="name" class="form-control mr-sm-2">
                <option value="" selected="selected">Name</option>
@foreach($rle as $tech)
<option value="{{ $tech->id }}">{{ $tech->fname . ' ' . $tech->lname }} - {{ $tech->type }}</option>
@endforeach
            </select>
      </div>
      </div>
  </div>

  <div class="modal-body">
      <div class="row">
          <div class="col">
              <select name="type" class="form-control mr-sm-2">
                <option value='' selected="selected">Type/section</option>
               
@if($head == 'All HOS Details')
<?php $to = user::select('type')->distinct()->where('type','like','%HOS%')->get(); ?>
@elseif($head == 'All Technicians Details')
<?php $to = Technician::select('type')->distinct()->get(); ?>
@elseif($head == 'All Inspectors of work Details')
<?php $to = user::select('type')->distinct()->where('type','like','%Inspector%')->get(); ?>
@endif
@foreach($to as $too)
<option value="{{ $too->type }}">{{ $too->type }}</option>
@endforeach
              </select>
          </div>
      </div>
      </div>
      
      <input type="text" name="change" value="@if($head == 'All HOS Details')hos 
      @elseif($head == 'All Technicians Details')technician
      @elseif($head == 'All Inspectors of work Details')iow
      @endif" hidden>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->

        <table class="table table-striped" id="myTable">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th title="phone" scope="col">Phone</th>
            <th scope="col">@if($head == 'All Technicians Details') section @else  type @endif </th>
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
        @foreach($rle as $tech)
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
                
            </tr>
        @endforeach
        </tbody>


        </table>
    </div>
   

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