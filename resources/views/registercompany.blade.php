@extends('layouts.asset')

@section('title')
StaffHouse Registrartion
@endSection

@section('body')
<br>
<div class="container">
@if ($errors->any())
<div class="alert alert-danger" >
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
@if(Session::has('message'))
<div class="alert alert-success" style="margin-top: 6%;">
	<ul>
		<li>{{ Session::get('message') }}</li>
	</ul>
</div>
@endif


<div class="container">
                <h4  id="Add New House">Register  new comapany</h4>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('company.save') }}" class="col-lg-12">
                    @csrf

                <div align="center">
     
                    
                        <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Company Name</label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="name" placeholder="Enter Company Name">
                    </div>



                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Type </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="type" placeholder="Enter Company Type">
                    </div>


                 
                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Status </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="status" placeholder="Enter Company Status">
                    </div>


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Registration </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="Registration" placeholder="Enter Company Registration">
                    </div>

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">TIN </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="TIN" placeholder="Enter Company TIN">
                    </div>

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">VAT </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="VAT" placeholder="Enter Company VAT">
                    </div>



                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">license </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="license" placeholder="Enter Company license">
                    </div>

            <button type="submit" class="btn btn-primary">Register
                        New Company
                    </button>
                    <a class="btn btn-danger" href="/cleaningcompany" role="button">Cancel </a>
                </div>
                </form>
            </div>
            


@endSection