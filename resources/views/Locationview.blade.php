@extends('layouts.master')

@section('title')
Locations
@endSection

@section('body')


<div class="container" >

<br>
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
                    >List of Available Locations</h4></div>




            <hr class="container">

            <a href="Add/locations" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add New Location</a>
                   <a href="{{ url('locationpdf')}}" style="margin-bottom: 20px; float:right;"
                   class="btn btn-primary">  Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>


                <table id="myTablee" class="table table-striped">
                    <thead >
                    <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Name of Location</th>

                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php $i = 0; ?>
                    @foreach($Loc as $dep)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>

                            <td><?php echo ucwords(strtolower( $dep->name )); ?></td>
                            <td>
                                 <div class="row">&nbsp;&nbsp;&nbsp;
                                    <a style="color: green;"
                                       onclick="myfunc1('{{ $dep->id }}','{{ $dep->name }}')"
                                       data-toggle="modal" data-target="#editloc" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to deactivate this Location  Completely? \n\n {{   $dep->name }} \n\n')"
                                          action="{{ route('Location.delete', [$dep->id]) }}">
                                        {{csrf_field()}}
                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                title="deactivate" style="color: red;" data-toggle="tooltip"><i
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


              <div class="modal fade" id="editloc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Location</h5>


                </div>

              
                    <div class="modal-body">

         <form method="POST" action="edit/locationn" class="col">
                        @csrf

                    <div class="form-group ">
                        <label for="dep_name">Location Name</label>
                        <input id="sname" style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"
                               name="sec_name" placeholder="Enter location name" >
                                 <input id="esecid" name="esecid" hidden>
                    </div>


                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <a href="/Manage/locations" class="btn btn-danger">Cancel
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