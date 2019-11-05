@extends('layouts.master')

@section('title')
    Minute Sheets
    @endSection

@section('body')
<br>
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h3><b>Minute Sheets </b></h3>
        </div>

        <div class="col-md-6">
            <form method="GET" action="work_order" class="form-inline my-2 my-lg-0">
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
					<th>MinuteID</th>
                    <th>Date</th>
                    <th>status</th>
                    <th>Action</th>
                    
                </tr>
                </thead>

                <tbody>

               @foreach($sheet as $sheet)
                        <tr>
                            <th scope="row"></th>
                            
							<td id="wo-id">M0{{ $sheet->id }}W0{{ $sheet->Woid }}</td>
                            <td><?php $time = strtotime($sheet->Sent); echo date('d/m/Y',$time);  ?></td>
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