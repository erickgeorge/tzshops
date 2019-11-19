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
    <br>
    <hr>
    <div class="container">


        <table class="table table-striped" id="myTable">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th title="phone" scope="col">Phone</th>
            <th scope="col">Section</th>
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