@extends('layouts.master')

@section('title')
StaffHouse Registrartion
@endSection

@section('body')
<br>

@if ($errors->any())
<div class="alert alert-danger" style="margin-top: 6%;">
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


<br>
                <h4 style='margin-top: 6%;' align="center" id="Add New House">Register  New House</h4>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('house.save') }}" class="col-lg-12">
                    @csrf

<div align="center">
                    <div class="input-group mb-3 col-lg-6">
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
                    <div class="form-group col-lg-6 ">
                        <label for="dir_name">House Name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="name_of_house" placeholder="Enter House Name">
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="dir_abb">House Location <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="location" placeholder="Enter House Location ">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="dir_name">Type of House <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="type" placeholder="Enter House Type">
                    </div>


                    <div class="form-group col-lg-6">
                        <label for="dir_name">No of Rooms <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="no_room" placeholder="Enter No of Rooms"    onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) ">
                    </div>


                       
                    <button type="submit" class="btn btn-primary">Register
                        New House
                    </button>
                    <a class="btn btn-danger" href="/manage_Houses" role="button">Cancel </a>
                </div>
                </form>
            </div>
            


@endSection