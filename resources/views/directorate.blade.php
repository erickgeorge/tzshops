@extends('layouts.master')

@section('title')
Directorate
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

  @if(count($directorates)>0)
                <h2 style="margin-bottom: 20px;"
                   class="btn btn-default">List of College/Directorates</h2>

                 
                <form method="GET" action="/Manage/directorate" class="form-inline my-2 my-lg-0" style="float: right; margin-right:20px;">
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
        
            <hr class="container">

            <a href="Add/directorate" style="margin-bottom: 20px;"
                   class="btn btn-primary">Add new College/Directorate</a>

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
                                          onsubmit="return confirm('Are you sure you want to delete this college/directorate Completely?\n\n ({{ $directorate->directorate_description }} - {{ $directorate->name }} )  \n\n All of its departments and sections under those college/directorate will be deleted')"
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
                        <a href="/Manage/directorate" class="btn btn-danger">Cancel
                    </a>

                    </div>
                </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


            @else
                    <h1 style="padding-top: 56px;" align="center"> No available Directorate </h1>
                     <br>
                     <a href="/Manage/directorate" class="btn btn-warning">Cancel
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