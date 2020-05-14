@extends('layouts.land')

@section('title')
Maintainance section
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

                <h3 style=" text-transform: uppercase;"
                   class="btn btn-default" >List of available assessed company</h3>

               
            <hr class="container">

          

                   <a href="{{ url('desdepts')}}" style="margin-bottom: 20px; float:right;"
                   class="btn btn-primary"><i class="fa fa-file-pdf"></i> PDF</a>


                <table id="myTablee" class="table table-striped">
                    <thead >
                    <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Assessment Area</th>
                        <th scope="col">Assessment Month</th>
                        <th scope="col">Status</th>  
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                        
                    <?php $i = 0; ?>
                    @foreach($assessmmentcompany as $assesment)
                          <?php $i++; ?>
                         <tr>
                             <td>{{ $i }}</td>
                             <td>{{$assesment['companyname']->company_name}}</td>
                             <td>{{$assesment['areaname']->cleaning_name}}</td>
                             <td>{{ date('F Y', strtotime($assesment->assessment_month))}}</td>
                             @if($assesment->status == 1)
                             <td><span class="badge badge-danger">No assessment form</span></td>
                             @elseif($assesment->status == 2)
                             <td><span class="badge badge-primary">Crosscheck assessment form</span></td>
                             @elseif($assesment->status == 3)
                             <td><span class="badge badge-warning">Assessment form submitted</span></td>
                             @elseif($assesment->status == 4)
                             <td><span class="badge badge-primary">Assessment form approved by Head PPU</span></td>
                             @elseif($assesment->status == 5)
                             <td><span class="badge badge-primary">Assessment form approved by Estate Director</span></td>
                             @elseif($assesment->status == 6)
                             <td><span class="badge badge-primary">Assessment form submitted</span></td>
                             @elseif($assesment->status == 7)
                             <td><span class="badge badge-danger">Closed</span></td>
                             @elseif($assesment->status == 10)
                             <td><span class="badge badge-danger">Rejected by Head PPU</span></td>
                             @elseif($assesment->status == 11)
                             <td><span class="badge badge-danger">Rejected by Estate Director</span></td>
                             @elseif($assesment->status == 12)
                             <td><span class="badge badge-danger">Rejected by DVC Admin</span></td>
                             @endif
                             <td> <a style="color: green;" href="{{ url('edit/assessmentform/landscaping', [$assesment->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a> 
                            <a style="color: black;" href="{{ route('workOrder.track.landscaping', [$assesment->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
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