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
                           
                            <td>{{ $dep->section_name }}</td>
                            <td>
                                
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

                <form method="POST" action="edit/department" class="col">
                    <div class="modal-body">


                        @csrf
						
						
						
						
						
                        <div class="form-group">
                            <label for="edirname">Section name </label>
                            <input style="color: black;" type="text" required class="form-control"
                                   id="edepdesc"
                                   name="edepdesc" placeholder="Enter Section name">
                            <input id="edepid" name="edepid" hidden>
                        </div>
                       

                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <a href="/Manage/department" class="btn btn-danger">Cancel
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