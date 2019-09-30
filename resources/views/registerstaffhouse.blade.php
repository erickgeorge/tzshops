@extends('layouts.master')

@section('title')
StaffHouse Registrartion
@endSection

@section('body')
<br>

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
                <h4 id="Add New House">Register  New House</h4>
                      <hr>
                 <p style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('house.save') }}" class="col-md-6">
                    @csrf


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            
                            <label class="input-group-text" for="directorate">Campus Name</label>
                        </div>
                        <select required class="custom-select" name="campus" id="campus">
                            <option value="">Choose...</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->campus_name }}</option>
                            @endforeach

                        </select>
                    </div> 
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
                    <a class="btn btn-info" href="/manage_Houses" role="button">Cancel </a>
                </form>
            </div>
            


@endSection