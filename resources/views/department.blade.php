@extends('layouts.master')

@section('title')
Department
@endSection

@section('body')
<?php
use app\directorate;
use app\department;
?>

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

       @if(count($directorates)>0)
               <h5 style="padding-left: 90px;  text-transform: uppercase;" 
                   class="btn btn-default">List of Departments</h5>

               
                
        
            <hr class="container">

            <a href="Add/department" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add new Department</a>
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
                        <div class="modal-body">
                            <label>Choose Department</label><br>
                          <select class="form-control" name="department">
                            <option value="">All Departments</option>
                            <?php
                            $dept = department::get();                            ?>
                         
                          @foreach ($dept as $dept)
                              <option value="{{ $dept->id }}">{{ $dept->description }} - {{$dept->name}}</option>
                          @endforeach
                          </select>
                        </div>
                        <div class="modal-body">
                            <label>Choose College</label>
                            <select class="form-control" name="college">
                                <option value="">All Colleges</option>
                                <?php
                                $colle = directorate::get();
                                ?>
                                @foreach ($colle as $colle)
                              <option value="{{ $colle->id }}">{{ $colle->directorate_description }} - {{$colle->name}}</option>
                          @endforeach
                            </select>
                          </div>
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Generate</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>


                <table id="myTablee" class="table table-striped">
                    <thead >
                  <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">College/Directorate</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($deps as $dep)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $dep->description }}</td>
                            <td>{{ $dep->name }}</td>
                            <td>{{ $dep['directorate']->name }}</td>
                            <td>
                                <div class="row">
                                    <a style="color: green;"
                                       onclick="myfunc1('{{ $dep->id }}','{{ $dep->name }}','{{ $dep->description }}','{{ $dep['directorate']->id }}')"
                                       data-toggle="modal" data-target="#editDepartment" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Department Completely? \n\n ( {{ $dep->description }} -  {{ $dep->name }} ) \n\n')"
                                          action="{{ route('department.delete', [$dep->id]) }}">
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>


                </div>
                   <div class="modal-body">

                <form method="POST" action="edit/department" class="col">
                 


                        @csrf
						
						
						
						<div class="form-group">
                       
                            <label for="directorate">Directorate/College <sup style="color: red;">*</sup></label>
                       
                        <select  style="color: black;"  required class="form-control" name="editdirectoratefdep" id="editdirectoratefdep">
                            <option value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ $directorate->directorate_description }}</option>
                            @endforeach

                        </select>
                    </div>
						
                        <div class="form-group">
                            <label for="edirname">Department name <sup style="color: red;">*</sup></label>
                            <input style="color: black;" type="text" required class="form-control"
                                   id="edepdesc"
                                   name="edepdesc" placeholder="Enter Department name">
                            <input id="edepid" name="edepid" hidden>


                        </div>
                        <div class="form-group ">
                            <label for="edirabb">Department abbreviation <sup style="color: red;">*</sup></label>
                            <input style="color: black;" type="text" required class="form-control"
                                   id="edepname"
                                   name="edepname" placeholder="Enter Department abbreviation">
                        </div>

                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <a href="/Manage/department" class="btn btn-danger">Cancel
                    </a>

                   
                </form>

                 </div>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


             @else
                    <h1 style="padding-top: 56px;" align="center"> No available Department</h1>
                     <br>
                     <a href="/Manage/department" class="btn btn-warning">Cancel
                    </a>
                     @endif


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


        function myfunc(x, y, z) {
            document.getElementById("edirid").value = x;
            document.getElementById("edirname").value = y;

            document.getElementById("edirabb").value = z;
        }


        function myfunc1(x, y, z,p) {
			
			
            document.getElementById("edepid").value = x;
            document.getElementById("edepname").value = y;

            document.getElementById("edepdesc").value = z;
			
			
			 for(var i = 0;i < document.getElementById("editdirectoratefdep").length;i++){
            if(document.getElementById("editdirectoratefdep").options[i].value == p ){
               document.getElementById("editdirectoratefdep").selectedIndex = i;
            }
        }
			
			
        }


        function myfunc2(x, y, z) {
            document.getElementById("esecid").value = x;
            document.getElementById("esecname").value = y;

            document.getElementById("esecdesc").value = z;
        }
		
		
		
		
		var selecteddep = null;
var selectedsection = null;
function getDepartments(){
	selecteddep = document.getElementById('directoratte').value;

    console.log('ID: '+selecteddep);
	$.ajax({
		method: 'GET',
		url: 'departments/',
		data: {id: selecteddep}
	})
	.done(function(msg){
        console.log(msg['departments']);
		var object = JSON.parse(JSON.stringify(msg['departments']));
		$('#department').empty();
		
		var option = document.createElement('option');
			option.innerHTML = 'Choose...';
			option.value = '';
			document.getElementById('department').appendChild(option);
			
			
		
		for (var i = 0; i < object.length; i++) {
			var option = document.createElement('option');
			option.innerHTML = object[i].description;
			option.value = object[i].id;
			document.getElementById('department').appendChild(option);
		}
	});
}


    </script>

@endSection