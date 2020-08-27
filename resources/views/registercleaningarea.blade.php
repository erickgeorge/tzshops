@extends('layouts.land')

@section('title')
StaffHouse Registrartion
@endSection

@section('body')
<br>

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


                <h5  id="Add New House">Register New Cleaning Area</h5>

                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>

                <form method="POST" action="{{ route('area.save') }}" class="col-lg-12">
                    @csrf

<div align="center">


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">

                          <label style="width:200px;" class="input-group-text" for="directorate">Cleaning Area Name </label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="cleaning_name" placeholder="Enter Cleaning Area Name">
                    </div>


                    <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;" class="input-group-text" for="directorate">LOT Name </label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="zone" placeholder="Enter LOT Name">
                    </div> 


                     <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;height: 28px;" class="input-group-text" > Directorate/College </label>
                        </div>
                         <select required style="color: black;" class="custom-select" name="college" id="directorate" onchange="getDepartments()" value="{{ old('directorate') }}">
                                  <option selected value="" >Choose...</option>
                                   @foreach($directorates as $directorate)
                                  <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
                                   @endforeach
                         </select>
                    </div> 




                    <button type="submit" class="btn btn-primary">Save
                    </button>
                      <a class="btn btn-danger" href="/manage_Cleaning_area" role="button">Cancel </a>
                  </div>
                </form>

            </div>



@endSection
