@extends('layouts.asset')

@section('title')
    Cleaning Company
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
                  <h3><b>Available cleaning companies </b></h3>
                  <hr>
                <a href="{{ route('registercompany') }}"
                   class="btn btn-primary">Add new cleaning company</a>
                   <br> <br> 
    
                <table id="myTableee" id="myTable" class="table table-striped">
                      
                    <thead >
                   <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Registration</th>
                        <th scope="col">Tin</th>
                        <th scope="col">Vat</th>
                        <th scope="col">license</th>
                        <th scope="col">ACTION</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($cleangcompany as $house)
                        <?php $i++; ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $house->company_name }}</td>
                            <td>{{ $house->type}}</td>
                            <td>{{ $house->status }}</td>
                            <td>{{ $house->registration }}</td>
                            <td>{{ $house->tin }}</td>
                            <td>{{ $house->vat }}</td>
                            <td>{{ $house->license }}</td>
                            <td>

                            <div class="row">


                                    <a style="color: green;"
                                       onclick="myfunc('{{ $house->id }}','{{ $house->company_name }}','{{ $house->type }}','{{$house->status}}','{{$house->registration}}','{{$house->tin}}','{{$house->vat}}','{{$house->license}}' )"
                                       data-toggle="modal" data-target="#editHouse" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this company Completely? ')"
                                          action="{{ route('company.delete', [$house->id]) }}">
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Cleaning Company</h5>
                </div>

                <form method="POST" action="edit/company" class="col-md-6">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="name_of_house">Name </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_name"
                                   name="name" placeholder="Enter Company name">
                            <input id="edit_id" name="edit_id" hidden>
                        </div>


                        <div class="form-group">
                            <label for="name_of_house">Type </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_type"
                                   name="type" placeholder="Enter Company type">
                          
                        </div>


                         <div class="form-group">
                            <label for="name_of_house">Status </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_status"
                                   name="status" placeholder="Enter Company status">
                          
                        </div>

                       <div class="form-group">
                            <label for="name_of_house">Registration</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_registration"
                                   name="registration" placeholder="Enter Company Registration">
                          
                        </div>

                        <div class="form-group">
                            <label for="name_of_house">Tin</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_tin"
                                   name="tin" placeholder="Enter Company tin">
                           
                        </div>


                        <div class="form-group">
                            <label for="name_of_house">Vat</label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_vat"
                                   name="vat" placeholder="Enter Company vat">
                            
                        </div>

                         <div class="form-group">
                            <label for="name_of_house">License </label>
                            <input style="color: black;width:350px" type="text" required class="form-control"
                                   id="edit_License"
                                   name="license" placeholder="Enter Company License">
                           
                        </div>







                       
                         <div style="width:600px;">
                                                <div style="float: left; width: 130px"> 
                                                      
                                                        <button  type="submit" class="btn btn-primary">Save Changes
                                                        </button>
                  
                                                       
                                               </div>
                                               <div style="float: right; width: 290px"> 
                                                     
                                                        
                                                  <a class="btn btn-danger" href="/cleaningcompany" role="button">Cancel </a>
                                                     
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


        function myfunc(A, B, C, D, E , F , G, H) {

            document.getElementById("edit_id").value = A;

            document.getElementById("edit_name").value = B;

           document.getElementById("edit_type").value = C;
           
           document.getElementById("edit_status").value = D;

           document.getElementById("edit_registration").value = E;

           document.getElementById("edit_tin").value = F;

           document.getElementById("edit_vat").value = G;

           document.getElementById("edit_License").value = H;
       }




    </script>