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
	<div class="col-md-4">
		<a href="{{ url('viewusers') }}" > <button type="" class="btn btn-primary">View all users</button></a>
	</div>
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
<form method="POST" action="{{ route('user.create') }}">
                        @csrf


	<div class="form-group ">
	    <label for="fname">First name</label>
	    <input type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " value="{{ old('fname') }}">
	 </div>
	<div class="form-group ">
	    <label for="lname">Last name</label>
	    <input type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 " value="{{ old('lname') }}">
	</div>
	<div class="form-group ">
	    <label for="phone">Phone number</label>
	    <input  required type="text"     name="phone"  value="{{ old('phone') }}"
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "2"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
	</div>
	<div class="form-group ">
	    <label for="email">Email Address</label>
	    <input required type="email"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="directorate">Directorate/College</label>
	  </div>
	  <select class="custom-select" name="college" id="directorate" onclick="getDepartments()">
	    @foreach($directorates as $directorate)
	    <option value="{{ $directorate->id }}">{{ $directorate->name }}</option>
	    @endforeach
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="department">Department</label>
	  </div>
	  <select class="custom-select" name="department" id="department" onclick="getSections()">
	  	@foreach($departments as $department)
	    <option value="{{ $department->id }}">{{ $department->name }}</option>
	    @endforeach
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="section">Section</label>
	  </div>
	  <select class="custom-select" name="section" id="section">
	  	@foreach($sections as $section)
	    <option value="{{ $section->id }}">{{ $section->section_name }}</option>
	    @endforeach
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="inputGroupSelect01">Role</label>
	  </div>
	  <select class="custom-select" name="role" id="inputGroupSelect02">
	    <option selected>Choose...</option>
	    <option value="1">Admin</option>
	    <option value="2">staff</option>
	  </select>
	</div>

<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="inputGroupSelect01">Type of User</label>
	  </div>
	  <select class="custom-select" id="inputGroupSelect02" name="user_type">
	    <option selected>Choose...</option>
	    <option value="HOS ELECTRICAL">HOS ELECTRICAL</option>
	    <option value="MC">Maintenence Coordinator</option>
	    <option value="DVC">DVC</option>
	    <option value="STORE">STORE MANAGER</option>
	  </select>
	</div>



	<div class="form-group ">
	    <label for="uname">Username</label>
	     <input required  maxlength="20" type="text" class="form-control" id="uname" aria-describedby="emailHelp" name="name" placeholder="Enter username" value="{{ old('name') }}">
	 </div>
	<div class="form-group ">
	    <label for="pass">Password</label>
	    <div class="row">
	    	<div class="col-md-8">
	    <input required maxlength="15"  minlength="6"  type="text" class="form-control" id="pass" aria-describedby="emailHelp" name="password" placeholder="Should have 6 characters minimum">
	    	</div>
	    <button type="button" onclick="generatePass()" class="btn btn-danger">Generate Password</button>
	    </div>
	</div>

	<button type="submit" class="btn btn-success">Create User</button>
    </form>

</div>
<br>
  
@endSection