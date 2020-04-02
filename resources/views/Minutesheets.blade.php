@extends('layouts.master')

@section('title')
    Minute Sheets
    @endSection

@section('body')
<br>
<div class="container">
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h5 style="padding-left: 90px;  text-transform: uppercase;" ><b style="text-transform: uppercase;">Minute Sheets </b></h5>
        </div>

       


       
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
    

    <div class="container">

      <?php
      if (count($sheet) >0){
       ?>
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th></th>
					<th>No</th>
                    <th>WorkOrder ID </th>
                
                    <th>status</th>
                    <th>Action</th>
                    
                </tr>
                </thead>

                <tbody>
                    <?php
                       $i=1;
                    ?>

                     @foreach($sheet as $sheet)
                        <tr>
                            <th scope="row"></th>
                            <td>{{ $i++}}</td>
                            <td>00{{ $sheet->Woid }}</td>
                            
                                <td><span class="badge badge-warning"><?php if ($sheet->status == 1) {
                                    echo "On progress";
                                }else{echo 'Closed';} ?></span></td>
                            
                            <td class="text-success"><a href="{{ url('minutesheet', [$sheet->Woid]) }}"><i class="fa fa-eye"></i> View</a></td>
                        </tr>
                        @endforeach
                       
                </tbody>
            </table>
       <?php }else{?>
            <h1 class="text-center" style="margin-top: 150px">No Minute Sheets Found</h1>
            <?php } ?>
        
    </div>
    </div>

     
    <script>

        

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });

         function myfunc(x) {
            document.getElementById("unsatisfiedreason").innerHTML = x;
        }
    </script>
    @endSection