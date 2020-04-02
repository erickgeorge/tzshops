@extends('layouts.master')

@section('title')
    manage cleaning zone
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
   
             
         <div>
          <br>
          <br>
          <br>
              <h5 style="padding-left: 90px;  text-transform: uppercase;" ><b style="text-transform: uppercase;">Available Cleaning Zones </b></h5>
              <hr>
                <a href="{{ route('registercleaningzone') }}" 
                   class="btn btn-primary">Add New CLeaning Zone</a>

                   <br><br>

                <table id="myTable" class="table table-striped">
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Zone Name</th>
                        <th scope="col">Campus Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>



                    <tbody>
                  <?php $i = 0; ?>
                    @foreach($newzone as $zone)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $zone->Zone_name }}</td>
                            <td>{{ $zone['Campus']->campus_name }}</td>
                            <td>{{ $zone->type }}</td>
                            <td>
                            <div class="row">

                                    <a style="color: green;"
                                       onclick="myfunc5('{{ $zone->id }}','{{ $zone->zone_name }}','{{ $zone->type }}')"
                                       data-toggle="modal" data-target="#editzone" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this zone Completely? ')"
                                          action="{{ route('zone.delete', [$zone->id]) }}">
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
                
            </div>
            



               <div class="modal fade" id="editzone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Zone Details</h5>
                </div>

                <form method="POST" action="edit/zone" class="col-md-6">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Zone Name <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_zone"
                                   name="zone_name" placeholder="Enter Zone Name">
                            <input id="editzone_id" name="editzone_id" hidden>
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
                            <label for="editlocation">Type <sup style="color: red;">*</sup></label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type"
                                   name="type" placeholder="Enter Zone Type">
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