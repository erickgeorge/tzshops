@extends('layouts.asset')

@section('title')
    manage staff house
    @endSection

@section('body')
    <br>
   
   
<div class="container">
  

 

            <div >
               @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
              @endif
                  <h5 style="padding-left: 90px;  text-transform: uppercase;" ><b style="text-transform: uppercase;">Available Staff Houses </b></h5>
                  <hr>
                <a href="{{ route('registerstaffhouse') }}"
                   class="btn btn-primary">Add New Staff House</a>
                   <br> <br> 
    
                <table id="myTableee" id="myTable" class="table table-striped">
                      
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Number of Bedrooms</th>
                        <th scope="col">Location</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Campus</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($staffhouses as $house)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->name_of_house }}</td>
                            <td>{{ $house->type}}</td>
                            <td>{{ $house->location }}</td>
                            
                            <td>{{ $house->no_room }}</td>
                            <td>{{ $house['campus']->campus_name }}</td> 
                            
                            <td>


                            <div class="row">


                                    <a style="color: green;"
                                       onclick="myfunc('{{ $house->id }}','{{ $house->name_of_house }}','{{ $house->location }}','{{$house->type}}','{{$house->no_room}}' )"
                                       data-toggle="modal" data-target="#editHouse" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this House Completely? ')"
                                          action="{{ route('house.delete', [$house->id]) }}">
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
            



               <div class="modal fade" id="editHouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit House Details</h5>
                </div>

                <form method="POST" action="edit/House" class="col-md-6">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Grade </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_name"
                                   name="name_of_house" placeholder="Enter House Grade">
                            <input id="edit_id" name="edit_id" hidden>
                        </div>




                        <div class="form-group ">
                            <label for="editlocation">Location </label>
                            
                            <select style="width: 350px;" required class="custom-select" name="location" id="campus">
                            <option value="">Choose Location...</option>
                                 
                                <option value="BIAFRA FLATS">BIAFRA FLATS</option>
                                <option value="DARAJANI HOUSES">DARAJANI HOUSES</option>
                                <option value="KILIMAHEWA HOUSES">KILIMAHEWA HOUSES</option>
                                <option value="KILIMAHEWA FLATS">KILIMAHEWA FLATS</option>
                                <option value="KILELENI HOUSES">KILELENI HOUSES</option>
                                <option value="KIJITONYAMA FLATS">KIJITONYAMA FLATS</option>
                                <option value="KINONDONI NGANO HOUSES">KINONDONI NGANO HOUSES</option>
                                <option value="KOROSHINI HOUSES">KOROSHINI HOUSES</option>
                                <option value="KUNDUCHI HOUSES">KUNDUCHI HOUSES</option>
                                <option value="KUNDUCHI QUARTERS">KUNDUCHI QUARTERS</option>
                                <option value="LAMBONI HOUSES">LAMBONI HOUSES</option>        
                                <option value="UBUNGO HOUSES">UBUNGO HOUSES</option>
                                <option value="MBEZI HOUSES">MBEZI HOUSES</option>
                                <option value="MABIBO HOSTEL">MABIBO HOSTEL</option>
                                <option value="MIKOCHENI HOUSES">MIKOCHENI HOUSES</option>
                                <option value="MIKOCHENI QUARTERS">MIKOCHENI QUARTERS</option>
                                <option value="MPAKANI QUARTERS">MPAKANI QUARTERS</option>
                                <option value="MWEMBENI HOUSES">MWEMBENI HOUSES</option>
                                <option value="MBUGANI HOUSES">MBUGANI HOUSES</option>
                                <option value="NEC HOUSES">NEC HOUSES</option>
                                <option value="NG'AMBO HOUSES">NG'AMBO HOUSES</option>
                                <option value="NG'AMBO FLATS ">NG'AMBO FLATS</option>
                                <option value="SIMBA FLATS">SIMBA FLATS</option>
                                <option value="SIMBA HOUSES">SIMBA HOUSES</option>
                                <option value="SINZA HOUSES">SINZA HOUSES</option>
                                <option value="SINZA FLATS">SINZA FLATS</option>
                                <option value="UBUNGO FLATS">UBUNGO FLATS</option>
                                <option value="UNIVERSITY ROAD">UNIVERSITY ROAD</option>
                                
                                

                        </select>
                        </div>
                       

                    
                        <div class="form-group ">
                            <label for="editlocation">No of Bedrooms </label>
                            <input style="color: black;width:350px" type="Number" required class="form-control"
                                   id="edit_type"
                                   name="type" placeholder="Enter Number of Bedrooms">
                        </div>
                       

                         <div class="form-group ">
                            <label for="editlocation">Quantity</label>
                            <input style="color: black;width:350px" type="Number" required class="form-control"
                                   id="edit_room"
                                   name="no_room" placeholder="Enter House Quantity">
                        </div>



                        <div class="form-group">
                       
                            
                            <label for="directorate">Campus</label>
                            
                       
                        <select style="width: 350" required class="custom-select" name="campus" id="campus">
                            <option value="">Choose...</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->campus_name }}</option>
                            @endforeach

                        </select>
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