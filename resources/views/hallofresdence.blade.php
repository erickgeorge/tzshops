@extends('layouts.asset')

@section('title')
    manage hall of resdence
    @endSection

@section('body')
    <br>
   
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
<div class="container">
  
        
            @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
            @endif
        <h3><b>Available Hall of Resdences </b></h3>
                  <hr>
                <a href="{{ route('registerhall') }}" 
                   class="btn btn-primary">Add new Hall of Resdence</a>
                   <br><br>

                <table id="myTablee" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Hall Name</th>
                        <th scope="col">Campus</th>
                        <th scope="col">Area</th>
                        <th scope="col">Type</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                     <?php $i = 0; ?>
                    @foreach($HallofResdence as $hall)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $hall->hall_name }}</td>
                            <td>{{ $hall['campus']->campus_name }}</td>
                            <td>{{ $hall->area_name}}</td>
                            <td>{{ $hall->type}}</td>
                            <td>{{ $hall->location }}</td>


                            
                            <td>
                            <div class="row">


                                    <a style="color: green;"
                                       onclick="myfunc1('{{ $hall->id }}','{{ $hall->hall_name }}','{{ $hall->campus_id }}','{{ $hall->area_name }}','{{$hall->type}}','{{$hall->location}}' )"
                                       data-toggle="modal" data-target="#editHall" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Hall Completely? ')"
                                          action="{{ route('hall.delete',[$hall->id]) }}">
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
                


                    
                        <div class="modal fade" id="editHall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Hall Details</h5>


                </div>

                <form method="POST" action="edit/Hall" class="col-md-6">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Hall Name <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_hname"
                                   name="hall_name" placeholder="Enter Hall name">
                            <input id="edit_hallid" name="edit_hallid" hidden>
                        </div>



                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            
                            <label class="input-group-text" for="directorate">Campus Name <sup style="color: red;">*</sup></label>
                        </div>
                        <select required class="custom-select" name="campus" id="campus">
                            <option value="">Choose...</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->campus_name }}</option>
                            @endforeach

                        </select>
                    </div>   


                    
                        <div class="form-group ">
                            <label for="editlocation">Area <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_area"
                                   name="area_name" placeholder="Enter House Type">
                        </div>
                       

                         <div class="form-group ">
                            <label for="editlocation">Type <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type1"
                                   name="type" placeholder="Enter Number of Rooms">
                        </div>


                         <div class="form-group ">
                            <label for="editlocation">Location <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_location1"
                                   name="location" placeholder="Enter Number of Rooms">
                        </div>
                        <div style="width:600px;">
                                                <div style="float: left; width: 130px"> 
                                                      
                                                        <button  type="submit" class="btn btn-primary">Save Changes
                                                        </button>
                  
                                                       
                                               </div>
                                               <div style="float: right; width: 290px"> 
                                                     
                                                        
                                                  <a class="btn btn-danger" href="/manage_Houses" role="button">Cancel </a>
                                                     
                                                       </div>
                                            </div>
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
                $('#myTable5').DataTable();                                            
 

        });


        function myfunc(V, W, X, Y, Z) {

            document.getElementById("edit_id").value = V;

            document.getElementById("edit_name").value = W;

           document.getElementById("edit_location").value = X;
           
           document.getElementById("edit_type").value = Y;

           document.getElementById("edit_room").value = Z;
       }



        function myfunc1(U, V, W, X, Y, Z) {


            document.getElementById("edit_hallid").value = U;

            document.getElementById("edit_hname").value = V;

            document.getElementById("edit_campus").value = W;

           document.getElementById("edit_area").value = X;
           
           document.getElementById("edit_type1").value = Y;

           document.getElementById("edit_location1").value = Z;
       }


        function myfunc8(A, B, C) {

             document.getElementById("edit_cid").value = A;

            document.getElementById("edit_campname").value = B;

            document.getElementById("edit_location").value = C;
       }



        function myfunc5(U, V, W) {


             document.getElementById("editzone_id").value = U;

             document.getElementById("edit_zone").value = V;

            

             document.getElementById("edit_type").value = W;

          
       }


       function myfunc9(U, V, W) {


             document.getElementById("editarea_id").value = U;

             document.getElementById("edit_carea").value = V;

            

             document.getElementById("edit_type").value = W;

          
       }



    </script>