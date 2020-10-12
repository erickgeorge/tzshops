@extends('layouts.master')

@section('title')
IoW Zones
@endSection

@section('body')


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
                <h5 style="text-transform: capitalize;">List of available IoW zones</h5>




            <hr class="container">

            <a href="Add/iowzone" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add new zone for IoW</a>
                   <a href="{{ url('iowonlyzones')}}" style="margin-bottom: 20px; float:right;"
                   class="btn btn-primary">  Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>


                <table id="myTablee" class="table table-striped">
                    <thead >
                    <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Name of Zone</th>

                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php $i = 0; ?>
                    @foreach($iowzone as $iow)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>

                            <td><?php echo strtoupper( $iow->zonename ); ?></td>



                            <td>
                                 <div class="row">
                                    <a style="color: green;"
                                       onclick="myfunc1('{{ $iow->id }}','{{ $iow->zonename}}')"
                                       data-toggle="modal" data-target="#editDepartment" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this zone completely? \n\n {{   $iow->zonename }} \n\n')"
                                          action="{{ route('iowzone.delete', [$iow->id]) }}">
                                        {{csrf_field()}}
                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                title="Delete" style="color: red;" data-toggle="tooltip"><i
                                                    class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>

                            </td>
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



                        @csrf


                    <div class="form-group ">
                        <label for="dep_name">Zone Name</label>
                        <input id="sname" style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"
                               name="sec_name" placeholder="Enter Zone Name" >
                                 <input id="esecid" name="esecid" hidden>
                    </div>


                        <button type="submit" class="btn btn-primary">Save
                        </button>
                        <a href="/Manage/IoWZones" class="btn btn-danger">Cancel
                    </a>


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
