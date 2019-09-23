@extends('layouts.master')

@section('title')
    manage assets
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

    {{-- tabs --}}
    <div class="payment-section-margin">
        <div class="tab">
            <div class="container-fluid">
                <div class="tab-group row">


                   <button id="modal" class="tablinks active col-md-4" onclick="openTab(event, 'campuses')">
                        REGISTER CAMPUS
                    </button>

                    <button class="tablinks col-md-4" onclick="openTab(event, 'staffhouse')" id="defaultOpen">
                        REGISTER STAFF HOUSE
                    </button>

                    <button class="tablinks col-md-4" onclick="openTab(event, 'Hallofresdence')">REGISTER HALL OF RESDENCE
                    </button>

                   <button id="modal" class="tablinks active col-md-4" onclick="openTab(event, 'customer')">
                        REGISTER CLEANING COMPANY
                    </button>

                    <button class="tablinks col-md-4" onclick="openTab(event, 'accademicarea')" id="defaultOpen">
                        REGISTER ACADEMIC AREA
                    </button>

                    <button class="tablinks col-md-4" onclick="openTab(event, 'buildingasset')">
                        REGISTER NON BUILDING ASSET
                    </button>

                   <button id="modal" class="tablinks active col-md-4" onclick="openTab(event, 'customer')">
                        REGISTER CLEANING ZONE
                    </button>
                    

                </div>
            </div>

            {{-- Campus --}}

         <div id="campuses" class="tabcontent">
                <a href="#Add New campus" style="margin-bottom: 20px; background-color: coral; color: white"
                   class="btn btn-primary">Add New Campus</a>

                <table id="myTable" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Campus Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>



                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($campuses as $campus)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $campus->campus_name }}</td>
                            <td>{{ $campus->location }}</td>
                             <td>


                            <div class="row">


                                    <a style="color: green;"
                                       onclick="myfunc2('{{ $campus->id }}','{{ $campus->campus_name }}','{{ $campus->location }}',' )"
                                       data-toggle="modal" data-target="#editCampus" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Campus Completely? ')"
                                          action="{{ route('campus.delete', [$campus->id]) }}">
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
                <h4 id="Add New campus">Add New Campus</h4>
                <hr>
                <form method="POST" action="{{ route('campus.save') }}" class="col-md-6">
                    @csrf
                    <div class="form-group ">
                        <label for="dir_name">Campus Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="campus_name" placeholder="Enter Campus Name">
                    </div>

                    <div class="form-group ">
                        <label for="dir_abb">Campus Location</label>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="location" placeholder="Enter Campus Location ">
                    </div>

                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New Campus
                    </button>
                </form>
            </div>
            



               <div class="modal fade" id="editCampus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Campus Details</h5>
                </div>

                <form method="POST" action="edit/Campus" class="col-md-6">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Campus Name </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_campname"
                                   name="name_of_campus" placeholder="Enter Campus Name">
                            <input id="edit_cid" name="edit_cid" hidden>
                        </div>




                        <div class="form-group ">
                            <label for="editlocation">Location</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_loc"
                                   name="location" placeholder="Enter Campus Location">
                        </div>
                       

                    

                       
                        <button style="background-color: green; color: white" type="submit" class="btn btn-success">Edit Room Details
                        </button>

                    </div>
                </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>





            <div id="staffhouse" class="tabcontent active">
                <a href="#Add New House" style="margin-bottom: 20px; background-color: coral; color: white"
                   class="btn btn-primary">Add New Staff House</a>

                <table id="myTableee" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">House Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Type</th>
                        <th scope="col">No of Rooms</th>
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
                            <td>{{ $house->location }}</td>
                            <td>{{ $house->type}}</td>
                            <td>{{ $house->no_room }}</td>
                            
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
                <h4 id="Add New House">Add New House</h4>
                <hr>
                <form method="POST" action="{{ route('house.save') }}" class="col-md-6">
                    @csrf
                    <div class="form-group ">
                        <label for="dir_name">House Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="name_of_house" placeholder="Enter House Name">
                    </div>

                    <div class="form-group ">
                        <label for="dir_abb">House Location</label>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="location" placeholder="Enter House Location ">
                    </div>
                    <div class="form-group ">
                        <label for="dir_name">Type of House</label>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="type" placeholder="Enter House Type">
                    </div>


                    <div class="form-group ">
                        <label for="dir_name">No of Rooms</label>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="no_room" placeholder="Enter No of Rooms"    onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) ">

                    </div>
                    
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New House
                    </button>
                </form>
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
                            <label for="name_of_house">House Name </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_name"
                                   name="name_of_house" placeholder="Enter House name">
                            <input id="edit_id" name="edit_id" hidden>
                        </div>




                        <div class="form-group ">
                            <label for="editlocation">Location</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_location"
                                   name="location" placeholder="Enter House Location">
                        </div>
                       

                    
                        <div class="form-group ">
                            <label for="editlocation">Type</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type"
                                   name="type" placeholder="Enter House Type">
                        </div>
                       

                         <div class="form-group ">
                            <label for="editlocation">No of Rooms</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_room"
                                   name="no_room" placeholder="Enter Number of Rooms">
                        </div>



                       
                        <button style="background-color: green; color: white" type="submit" class="btn btn-success">Edit Room Details
                        </button>

                    </div>
                </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



    {{-- Hall of Residence--}}

     <div id="Hallofresdence" class="tabcontent">
                <a href="#Add New House Hall of Residence" style="margin-bottom: 20px; background-color: coral; color: white"
                   class="btn btn-primary">Add New Hall of Resdence</a>

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
                            <td>{{ $hall->campus_id }}</td>
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
                <h4 id="Add New House Hall of Residence">Add New Hall of Resdence</h4>
                <hr>
                <form method="POST" action="{{ route('hall.save') }}" class="col-md-6">
                    @csrf
                    <div class="form-group ">
                        <label for="dir_name">Hall Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="hall_name" placeholder="Enter House Name">
                    </div>

                    <div class="form-group ">
                        <label for="dir_abb">Campus</label>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="campus_id" placeholder="Enter House Location " onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) ">
                    </div>




                    <div class="form-group ">
                        <label for="dir_name">Area</label>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="area_name" placeholder="Enter House Type">
                    </div>


                    <div class="form-group ">
                        <label for="dir_name">Type</label>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="type" placeholder="Enter Hall Type">
                    </div>

                    <div class="form-group ">
                        <label for="dir_name">Location</label>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="location" placeholder="Enter Hall Location">
                    </div>
                    
                    
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New Hall
                    </button>
                </form>


                    
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
                            <label for="name_of_house">Hall Name </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_hname"
                                   name="hall_name" placeholder="Enter House name">
                            <input id="edit_hallid" name="edit_hallid" hidden>
                        </div>




                        <div class="form-group ">
                            <label for="editlocation">Campus</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_campus"
                                   name="campus_id" placeholder="Enter House Location">
                        </div>
                       

                    
                        <div class="form-group ">
                            <label for="editlocation">Area</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_area"
                                   name="area_name" placeholder="Enter House Type">
                        </div>
                       

                         <div class="form-group ">
                            <label for="editlocation">Type</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type1"
                                   name="type" placeholder="Enter Number of Rooms">
                        </div>


                         <div class="form-group ">
                            <label for="editlocation">Location</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_location1"
                                   name="location" placeholder="Enter Number of Rooms">
                        </div>
                       
                        <button style="background-color: green; color: white" type="submit" class="btn btn-success">Edit Hall Details
                        </button>

                    </div>
                </form>

             <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




{{-- staffHouse--}}

     <div id="staffhouse" class="tabcontent">
                <a href="#Add New House" style="margin-bottom: 20px; background-color: coral; color: white"
                   class="btn btn-primary">Add New Staff House</a>

                <table id="myTable" id="myTable" class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">House Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Type</th>
                        <th scope="col">No of Rooms</th>
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
                            <td>{{ $house->location }}</td>
                            <td>{{ $house->type}}</td>
                            <td>{{ $house->no_room }}</td>
                            
                            <td>


                            <div class="row">


                                    <a style="color: green;"
                                       onclick="myfunc('{{ $house->id }}','{{ $house->name_of_house }}','{{ $house->location }}','{{$house->type}}','{{$house->no_room}}' )"
                                       data-toggle="modal" data-target="#editstaffHouse" title="Edit"><i
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
                <h4 id="Add New House">Add New House</h4>
                <hr>
                <form method="POST" action="{{ route('house.save') }}" class="col-md-6">
                    @csrf
                    <div class="form-group ">
                        <label for="dir_name">House Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="name_of_house" placeholder="Enter House Name">
                    </div>

                    <div class="form-group ">
                        <label for="dir_abb">House Location</label>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="location" placeholder="Enter House Location ">
                    </div>




                    <div class="form-group ">
                        <label for="dir_name">Type of House</label>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="type" placeholder="Enter House Type">
                    </div>


                    <div class="form-group ">
                        <label for="dir_name">No of Rooms</label>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="no_room" placeholder="Enter No of Rooms"    onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) ">




                    </div>
                    
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New House
                    </button>
                </form>
            </div>
            



               <div class="modal fade" id="editstaffHouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <label for="name_of_house">House Name </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_name"
                                   name="name_of_house" placeholder="Enter House name">
                            <input id="edit_id" name="edit_id" hidden>
                        </div>




                        <div class="form-group ">
                            <label for="editlocation">Location</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_location"
                                   name="location" placeholder="Enter House Location">
                        </div>
                       

                    
                        <div class="form-group ">
                            <label for="editlocation">Type</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type"
                                   name="type" placeholder="Enter House Type">
                        </div>
                       

                         <div class="form-group ">
                            <label for="editlocation">No of Rooms</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_room"
                                   name="no_room" placeholder="Enter Number of Rooms">
                        </div>



                       
                        <button style="background-color: green; color: white" type="submit" class="btn btn-success">Edit Room Details
                        </button>

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


        function myfunc2(U, V, W) {

             document.getElementById("edit_cid").value = U;

            document.getElementById("edit_campname").value = V;

            document.getElementById("edit_loc").value = W;
       }


    </script>