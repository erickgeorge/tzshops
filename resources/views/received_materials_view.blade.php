@extends('layouts.master')

@section('title')
    works orders
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            @if(auth()->user()->type == 'STORE')
            <h5 class="container"><b>List of Available Material(s) Required by Head of Section</b></h5>
            @else
            <h5 class="container"><b>Available Material(s) You Requested  From Store </b></h5>
            @endif
        </div>


        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
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


    <div class="container">


        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
        <th >No</th>

        <th >Wo ID</th>
        <th >Item ID</th>
        <th >Unit of Measure</th>
        <th >Material Description</th>
        <th >Type</th>
        <th>Quantity</th>

      <!--  <th >Status</th>-->
        <th >Received Status</th>

            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['workorder']->woCode }}</td>
                    <td>{{ $item['material']->name }}</td>
                    <td>{{ ucwords(strtolower($item['material']->description ))}}</td>
                    <td>{{ ucwords(strtolower($item['material']->brand ))}}</td>
                    <td>{{ ucwords(strtolower($item['material']->type)) }}</td>
                    <td>{{ $item->quantity }}</td>

                     <!--  @if($item->checkreserve == 1)
                       <td style="color: blue"><span class="badge badge-info">Available</span> <br><span class="badge badge-light">purchased</span>
                      </td>
                       @else
                       <td style="color: blue"><span class="badge badge-info">Available</span>
                      </td>
                       @endif -->

                       @if( $item->secondstatus == null)

                       <td><span class="badge badge-danger">Not Received</span></td>
                        @else
                       <td><span class="badge badge-success">Received</span></td>
                       @endif


                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>





          @if(auth()->user()->type =='STORE')

          <br>
          @if($item->secondstatus == 1)

          <h5  style="     color: #733703;"><b> Please download Issue Note for material(s) requested so as Head of Section to Sign.</b></h5>
         <a  target="_blank" class="btn btn-primary btn-sm"  href="issuenotepdf/{{$item->work_order_id}}" role="button">Print Issue Note</a>   @endif
         @else
         @if(($item->status == 3))
         <h5  style="     color: #733703;"><b>  Please confirm if you have received Material(s).</b></h5>
         <a class="btn btn-primary btn-sm"  href="tick/material_received/{{$item->work_order_id}}" role="button">Confirm (&#10004;)</a>
         @endif

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
    @endSection
