@extends('layouts.master')

@section('title')
IoW Zones
@endSection

@section('body')
@php
   use App\User;
@endphp

<div class="container" >


	 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
 <br>
                <h5 >List of Zones assigned to Inspectors of Works</h5>


            <hr class="container">

            <a href="{{route('manage.IoWZones')}}" style="margin-bottom: 20px;"
                   class="btn btn-primary">Manage Zones</a>
                   <a  target="_blank"  href="{{ url('iowwithzones')}}" style="margin-bottom: 20px; float:right;"
                   class="btn btn-primary">  Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>


                <table id="myTablee" class="table table-striped">
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Name of Zone</th>
                        <th>Inspector of Work</th>
                        <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>


                    <?php $i = 0; ?>
                    @foreach($iowzone as $iow)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>

                            <td><?php echo ucwords(strtolower( $iow->zone )); ?></td>
                            <td> @php
                                $hieim = User::where('zone', $iow->zone)->first();
                               $him = User::where('zone', $iow->zone)->get();
                            @endphp @foreach ($him as $him)
                                        {{$him->fname}} {{$him->mid_name}} {{$him->lname}} <br>
                                        @php
                                            $gfd = $him->id;
                                        @endphp
                            @endforeach </td>
                            <td><a class="btn btn-primary" href="{{route('view.location', [$hieim['id'] , $iow->zone])}}" >view</a></td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div class="text-center">

                </div>

            </div>


              <div class="modal fade" id="editDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Zone</h5>


                </div>

                <div class="modal-body">
                <form method="POST" action="edit/iowzone" class="col">
                    <div class="modal-body">
                        @csrf


                        <div class="form-group ">
                            <label for="dep_name">Zone Name</label>
                            <input id="sname" style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"
                                   name="sec_name" placeholder="Enter Zone Name" >
                                     <input id="esecid" name="esecid" hidden>
                        </div>
                    </div>
                        <div class="modal-body">


                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <a href="/Manage/IoWZones" class="btn btn-danger">Cancel
                    </a>

                    </div>
                </form>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




                      <script>
        window.onload = function () {
            //write your function code here.

            document.getElementById("modal").click();
        };

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });

            $('#myTablee').DataTable();
            $('#myTableee').DataTable();


        });





        function myfunc1(x,y) {


            document.getElementById("esecid").value = x;
            document.getElementById("sname").value = y;


        }


    </script>

@endSection
