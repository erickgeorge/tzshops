@extends('layouts.master')

@section('title')
    manage collegies
    @endSection

@section('body')
    <br>

   

    {{-- tabs --}}
    <div class="payment-section-margin" style="margin-top: 6%;">
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
        <div class="tab">
            <div class="container-fluid">
                <div class="tab-group row">
                    <button id="modal" class="tablinks active col-md-4" onclick="openTab(event, 'customer')">
                        COLLEGE
                    </button>
                    <button class="tablinks col-md-4" onclick="openTab(event, 'delivery')" id="defaultOpen">
                        DEPARTMENTS
                    </button>
                   <!-- <button class="tablinks col-md-4" onclick="openTab(event, 'payment')">SECTIONS
                    </button> -->
                </div>
            </div>

            {{-- directorate tab--}}
            <div id="customer" class="tabcontent active">
                <a href="#new_dir" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add new College</a>
                   @if(count($directorates)>0)
                <form method="GET" action="manage_directorates" class="form-inline my-2 my-lg-0" style="float: right; margin-right:20px;">
                From:  <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To: <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-primary bg-primary" style="width: 70px" type="submit">Filter</button>
            </form>
            @endif
                <table id="myTable" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">Added on</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($directorates as $directorate)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $directorate->directorate_description }}</td>
                            <td>{{ $directorate->name }}</td>
                            <td><?php $time = strtotime($directorate->created_at); echo date('d/m/Y',$time);  ?></td>



                            <td>
                                <div class="row">


                                    <a style="color: green;"
                                       onclick="myfunc('{{ $directorate->id }}','{{ $directorate->name }}','{{ $directorate->directorate_description }}','{{$directorate->directorate_description}}')"
                                       data-toggle="modal" data-target="#editDirectorate" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this college Completely? All of its departments and sections under those college will be deleted')"
                                          action="{{ route('directorate.delete', [$directorate->id]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>


                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <h4 id="new_dir">Add new college</h4>
                <hr>
                <form method="POST" action="{{ route('directorate.save') }}" class="col-md-6">
                    @csrf
                    <div class="form-group ">
                        <label for="dir_name">college name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="dir_name"
                               name="dir_name" placeholder="Enter college name">
                    </div>
                    <div class="form-group ">
                        <label for="dir_abb">college abbreviation <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="dir_abb"
                               name="dir_abb" placeholder="Enter College abbreviation">
                    </div>
                    <button type="submit" class="btn bg-primary btn-primary">Save
                    </button>
                </form>
            </div>
            {{-- end inspection --}}

            {{-- department tab --}}
            <div id="delivery" class="tabcontent">
                <a href="#new_dep" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add new department</a>
                    @if(count($deps)>0)
                   <form method="GET" action="manage_directorates" class="form-inline my-2 my-lg-0" style="float: right; margin-right:20px;">
                From:  <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To: <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-primary bg-primary" style="width: 70px;" type="submit">Filter</button>
            </form>
            @endif
                <table id="myTablee" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">College</th>
                        <th scope="col">Added on</th>
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
                            <td><?php $time = strtotime($dep->created_at); echo date('d/m/Y',$time);  ?></td>

                            <td>
                                <div class="row">
                                    <a style="color: green;"
                                       onclick="myfunc1('{{ $dep->id }}','{{ $dep->name }}','{{ $dep->description }}','{{ $dep['directorate']->id }}')"
                                       data-toggle="modal" data-target="#editDepartment" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Department Completely?')"
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
                <br>
                <h4 id="new_dep">Add new department</h4>
                <hr>
                <form method="POST" action="{{ route('department.save') }}" class="col-md-6">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="directorate">Directorate/College <sup style="color: red;">*</sup></label>
                        </div>
                        <select required class="custom-select" name="directorate" id="directoratee">
                            <option value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ $directorate->directorate_description }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="dep_name">Department name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"
                               name="dep_name" placeholder="Enter department name">
                    </div>
                    <div class="form-group ">
                        <label for="dep_ab">Department abbreviation <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required maxlength="8" class="form-control" id="dep_ab"
                               name="dep_ab" placeholder="Enter department abbreviation">
                    </div>
                    
                    <button type="submit" class="btn bg-primary btn-primary">Save
                    </button>
                </form>
            </div>

            {{-- section tab --}}
            <div id="payment" class="tabcontent">
                <a href="#new_sec" style="margin-bottom: 20px; "
                   class="btn btn-primary">Add new section</a>
                   @if(count($secs)>0)
                   <form method="GET" action="manage_directorates" class="form-inline my-2 my-lg-0" style="float: right; margin-right:20px;">
                From:  <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To: <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-primary bg-primary" style="width: 70px" type="submit">Filter</button>
            </form>
            @endif
                <table id="myTableee" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">Department</th>
                        <th scope="col">Added on</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($secs as $sec)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $sec->section_name }}</td>
                            <td>{{ $sec->description }}</td>
                            <td>{{ $sec['department']->name }}</td>
                            <td><?php $time = strtotime($sec->created_at); echo date('d/m/Y',$time);  ?></td>
                            
                            <td>
                                <div class="row">
                                    <a style="color: green;"
                                       onclick="myfunc2('{{ $sec->id }}','{{ $sec->section_name }}','{{ $sec->description }}')"
                                       data-toggle="modal" data-target="#editSection" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    <p>&nbsp;</p>
                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Section Completely?')"
                                          action="{{ route('section.delete', [$sec->id]) }}">
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
                <br>
				
				<!--<h4 style="color:red;" id="new_sec">NOT YET IMPLEMENTED</h4> -->
				
				 <h4 id="new_sec">Add new section</h4>
				
			<!-- IN PROGRESS -->
               
                <hr>
				
				  
                <form method="POST" action="{{ route('section.save') }}" class="col-md-6">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="directorate">Directorate/College <sup style="color: red;">*</sup></label>
                        </div>
                        <select required class="custom-select" name="college" id="directoratee"
                                onchange="getDepartments()">
                            <option selected value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="department">Department <sup style="color: red;">*</sup></label>
                        </div>
                        <select required class="custom-select" name="department" id="departiment">
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="sec_name">Section name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="sec_name"
                               name="sec_name" placeholder="Enter section name">
                    </div>
                    <div class="form-group ">
                        <label for="sec_ab">Section abbreviation <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required maxlength="8" class="form-control" id="sec_ab"
                               name="sec_ab" placeholder="Enter section abbreviation">
                    </div>
                    
                    <button type="submit" class="btn bg-primary btn-primary">Save
                    </button>
                </form>
			
            </div>
        </div>
    </div>










    <div class="modal fade" id="editDirectorate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Directorate/College/School/Institute</h5>


                </div>

                <form method="POST" action="edit/directorate" class="col">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="edirname">Directorate name <sup style="color: red;">*</sup></label>
                            <input style="color: black;" type="text" required class="form-control"
                                   id="edirabb"
                                   name="edirabb" placeholder="Enter Directorate name">
                            <input id="edirid" name="edirid" hidden>

                        </div>
                        <div class="form-group ">
                            <label for="edirabb">Directorate abbreviation <sup style="color: red;">*</sup></label>
                            <input style="color: black;" type="text" required class="form-control"
                                   id="edirname"
                                   name="edirname" placeholder="Enter Directorate abbreviation">
                        </div>

                        <button type="submit" class="btn bg-primary btn-primary">Save
                        </button>
                        <button type='submit' value="cancel" class="btn btn-danger">Cancel</button>

                    </div>
                </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>







    <div class="modal fade" id="editDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>


                </div>

                <form method="POST" action="edit/department" class="col">
                    <div class="modal-body">


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
                        <button type='submit' value="cancel" class="btn btn-danger">Cancel</button>

                    </div>
                </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>






    <div class="modal fade" id="editSection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Section Info.</h5>


                </div>

                <form method="POST" action="edit/section" class="col">
                    <div class="modal-body">


                        @csrf
						
						
						
						
                        <div class="form-group">
                            <label for="edirname">Section name <sup style="color: red;">*</sup></label>
                            <input style="color: black;" type="text" required class="form-control"
                                   id="esecname"
                                   name="esecname" placeholder="Enter Section name">


                        </div>
                        <div class="form-group ">
                            <label for="esecabb">Section abbreviation <sup style="color: red;">*</sup></label>
                            <input style="color: black;" type="text" required class="form-control"
                                   id="esecdesc"
                                   name="esecdesc" placeholder="Enter Section abbreviation">
                            <input id="esecid" name="esecid" hidden>
                        </div>

                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <button type='submit' value="cancel" class="btn btn-danger">Cancel</button>

                    </div>
                </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    @endSection


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