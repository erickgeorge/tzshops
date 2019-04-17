@extends('layouts.master')

@section('title')
User Registrartion
@endSection

@section('body')
<br>
<div class="row">
	<div class="col-md-8">
		<h2>Create New user</h2>
	</div>

	<!-- <div class="col-md-4">
		<a href="{{ url('viewusers') }}" > <button type="" class="btn btn-primary">View all users</button></a>
	</div> -->
</div>
<br>
<hr>
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
<div class="col-md-6">
<p style="color: red">All fields are compulsory</p>



<form method="POST" action="{{ route('user.create') }}">
                        @csrf

	<div class="form-group ">
	    <label for="fname">First name</label>
	    <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " value="{{ old('fname') }}">
	 </div>
	<div class="form-group ">
	    <label for="lname">Last name</label>
	    <input type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 " value="{{ old('lname') }}">
	</div>
	<div class="form-group ">
	    <label for="phone">Phone number</label>
	    <input style="color: black"  required type="text"     name="phone"  value="{{ old('phone') }}"
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "10"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
	</div>
	<div class="form-group ">
	    <label for="email">Email Address</label>
	    <input style="color: black" required type="email"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="directorate">Directorate/College</label>
	  </div>
	  <select required class="custom-select" name="college" id="directorate" onchange="getDepartments()">
		  <option selected value="" >Choose...</option>
	    @foreach($directorates as $directorate)
	    <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
	    @endforeach
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="department">Department</label>
	  </div>
	  <select required class="custom-select" name="department" id="department" onchange="getSections()">
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label  class="input-group-text" for="section">Section</label>
	  </div>
	  <select required class="custom-select" name="section" id="section">
		 
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="inputGroupSelect01">Role</label>
	  </div>
	  <select required class="custom-select" name="role" id="inputGroupSelect02">
	    <option value="" selected>Choose...</option>
	    <option value="1">Admin</option>
	    <option value="2">Staff</option>
	  </select>
	</div>

<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="inputGroupSelect01">Type of User</label>
	  </div>
	  <select required class="custom-select" id="inputGroupSelect02" name="user_type">
	    <option value="" selected>Choose...</option>
	    <option value="HOS Electrical">HOS Electrical</option>
	    <option value="HOS Plumbing">HOS Plumbing</option>
	    <option value="HOS Carpentry/Painting">HOS Carpentry/Painting</option>
	    <option value="HOS Mechanical">HOS Mechanical</option>
	    <option value="HOS Masonry/Road">HOS Masonry/Road</option>

	    <option value="Maintenance Coordinator">Maintenance Coordinator</option>
	    <option value="DVC Admin">DVC Admin</option>
	    <option value="Store Manager">Store Manager</option>
	    <option value="Secretary">Secretary</option>
	    <option value="Technician">Technician</option>
	    <option value="Estates Director">Estates Director</option>
	    <option value="Inspector Of Works">Inspector Of Works</option>
	  </select>
	</div>



	<div class="form-group ">
	    <label for="uname">Username</label>
	     <input style="color: black" required  maxlength="20" type="text" class="form-control" id="uname" aria-describedby="emailHelp" name="name" placeholder="Enter username" value="{{ old('name') }}">
	 </div>
	<div class="form-group ">
	    <label for="pass">Password</label>
	    <div class="row">
	    	<div class="col-md-8">
	    <input style="color: black" required maxlength="15"  minlength="6"  type="text" class="form-control" id="pass" aria-describedby="emailHelp" name="password" placeholder="Should have 6 characters minimum">
	    	</div>
	    <button type="button" onclick="generatePass()" class="btn btn-danger">Generate Password</button>
	    </div>
	</div>

	<button type="submit" class="btn btn-success">Create User</button>
	<a class="btn btn-info" href="/viewusers" role="button">Cancel Changes</a>
    </form>

</div>
<br>
@endSection