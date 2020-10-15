@extends('layouts.master')

@section('title')
Area
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

    <div>
<br><br>
                <h4
                    >List of Available Areas</h4></div>




            <hr class="container">

            <a href="Add/Areass" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add New Area</a>
                   <a href="{{ url('areapdf')}}" style="margin-bottom: 20px; float:right;"
                   class="btn btn-primary">  Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>


                <table id="myTablee" class="table table-striped">
                    <thead >
                    <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Name of Area</th>
                        <th scope="col">Name of Location</th>

                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php $i = 0; ?>
                    @foreach($area as $dep)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>

                            <td><?php echo $dep->name_of_area; ?></td>
                            <td><?php echo ucwords(strtolower( $dep['location']->name )); ?></td>
                            <td>
                                 <div class="row">&nbsp;&nbsp;&nbsp;
                                    <a style="color: green;"
                                       onclick="myfunc1('{{ $dep->id }}','{{ $dep->name_of_area }}')"
                                       data-toggle="modal" data-target="#editDepartment" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to deactivate this area  Completely? \n\n {{   $dep->name_of_area }} \n\n')"
                                          action="{{ route('areass.delete', [$dep->id]) }}">
                                        {{csrf_field()}}
                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                title="Deactivate" style="color: red;" data-toggle="tooltip"><i
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Area</h5>


                </div>


                    <div class="modal-body">
                         <form method="POST" action="edit/Areass" class="col">


                        @csrf





                    <div class="form-group ">
                        <label for="dep_name">Area Name</label>
                        <input id="sname" style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"
                               name="sec_name" placeholder="Enter Area Name" >
                                 <input id="esecid" name="esecid" hidden>
                    </div>


                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <a href="/Manage/Areas" class="btn btn-danger">Cancel
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
