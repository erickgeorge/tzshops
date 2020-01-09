@extends('layouts.master')

@section('title')
Workorder Section
@endSection

@section('body')


<div class="container" style="padding-top: 100px;">


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

                <h2 style="margin-bottom: 20px;"
                   class="btn btn-default">List of available Sections</h2>

               
                
        
            <hr class="container">

            <a href="Add/section" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add new Section for  Work order</a>
                   <a href="" data-toggle="modal" data-target="#exampleModal" style="margin-bottom: 20px; float:right;"
                   class="btn btn-primary"><i class="fa fa-file-pdf"></i> PDF</a>

                   
                 
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-file-pdf"></i> Generate Report</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                          </button>
                        </div>
                        <form method="GET" action="{{url('depgenerate')}}">
                            @csrf
                       
                        
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Generate</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>


                <table id="myTablee" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name of Section</th>
                       
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                        
                    <?php $i = 0; ?>
                    @foreach($worksec as $dep)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                           
                            <td><?php echo strtoupper( $dep->section_name ); ?></td>
                            <td>
                                 <div class="row">
                                    <a style="color: green;"
                                       onclick="myfunc1('{{ $dep->id }}','{{ $dep->section_name }}')"
                                       data-toggle="modal" data-target="#editDepartment" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Workorder Section Completely? \n\n {{   $dep->section_name }} \n\n')"
                                          action="{{ route('worksection.delete', [$dep->id]) }}">
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Section</h5>


                </div>

                <form method="POST" action="edit/workordersection" class="col">
                    <div class="modal-body">


                        @csrf
						
						
						
						
						
                    <div class="form-group ">
                        <label for="dep_name">Section Name</label>
                        <input id="sname" style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"  
                               name="sec_name" placeholder="Enter Section Name, Example: ELECTRICAL, MECANICAL etc." >
                                 <input id="esecid" name="esecid" hidden>
                    </div>
                       

                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <a href="/Manage/section" class="btn btn-danger">Cancel
                    </a>

                    </div>
                </form>


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