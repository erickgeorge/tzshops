@extends('layouts.master')

@section('title')
User Registrartion
@endSection

@section('body')
<br>
<div class="row" style="margin-top: 6%; margin-left: 3%;">
	<div class="col-md-8">
		<h2>Create New user</h2>
	</div>

	<!-- <div class="col-md-4">
		<a href="{{ url('viewusers') }}" > <button type="" class="btn btn-primary">View all users</button></a>
	</div> -->
</div>
<br>
<hr>
<div class="container" 
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
<div class="col-lg-12">
<p style="color: red">All fields are compulsory</p>



<form method="POST" action="{{ route('user.create') }}"  enctype="multipart/form-data">
                        @csrf
<div class="row">
	<div class="col">
		<div class="form-group ">
	    <label for="fname">First name</label>
	    <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " >
	 </div>
	</div>
	<div class="col">
		<div class="form-group ">
	    <label for="lname">Last name</label>
	    <input style="color: black" type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 ">
	</div>
	</div>
	<div class="col">
		<div class="form-group ">
	    <label for="phone">Phone number</label>
	    <input style="color: black"  required type="text"     name="phone"  
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "10"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
	</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="Email">Email</label>
	  </div>
	    <input style="color: black" required   type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" >
	</div>
	</div>
	<div class="col">
		<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="directorate">Directorate/College</label>
	  </div>
	  <select style="color: black" required class="custom-select" name="college" id="directorate" onchange="getDepartments()">
		  <option selected value="" >Choose...</option>
	    @foreach($directorates as $directorate)
	    <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
	    @endforeach
	  </select>
	</div>
	</div>
	<div class="col">
		<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="department">Department</label>
	  </div>
	  <select style="color: black" required class="custom-select" name="department" id="department" onchange="getSections()">
	  </select>
	</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label  class="input-group-text" for="section">Section</label>
	  </div>
	  <select style="color: black" required class="custom-select" name="section" id="section">
		 
	  </select>
	</div>
	</div>
	<div class="col">
		<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="inputGroupSelect01">Role</label>
	  </div>
	  <select style="color: black" required class="custom-select" name="role" id="inputGroupSelect02">
	    <option value="" selected>Choose...</option>
	    <option value="1">Admin</option>
	    <option value="2">Staff</option>
	  </select>
	</div>
	</div>
	
     

<DIV>
         <div class="col">
		<div class="input-group mb-3">
	 	   <div >
	    <label>Type of User</label>
	  </div>
     
	</div>
                <label> 
                 <input type="checkbox" name="type[]" value="HOS Electrical"> HOS Electrical </label>
         

                <label> 
                 <input type="checkbox" name="type[]" value="HOS Plumbing"> HOS Plumbing </label>
      
             
          
                <label> 
                 <input type="checkbox" name="type[]" value="HOS Carpentry/Painting"> HOS Carpentry/Painting </label>
          
           


      
                <label> 
                 <input type="checkbox" name="type[]" value="HOS Mechanical"> HOS Mechanical</label>
  


                <label> 
                 <input type="checkbox" name="type[]" value="HOS Masonry/Road"> HOS Masonry/Road </label>
       



                <label> 
                 <input type="checkbox" name="type[]" value="Maintenance Coordinator"> Maintenance Coordinator </label>
     

          
                <label> 
                 <input type="checkbox" name="type[]" value="DVC Admin"> DVC Admin</label>
    
                   


       
                <label> 
                 <input type="checkbox" name="type[]" value="Secretary"> Secretary </label>


                <label> 
                 <input type="checkbox" name="type[]" value="Technician"> Technician </label>
      
        


                <label> 
                 <input type="checkbox" name="type[]" value="Estates Director"> Estates Director </label>
  



            
                <label> 
                 <input type="checkbox" name="type[]" value="Inspector Of Works"> Inspector Of Works </label>
   
    
                <label> 
                 <input type="checkbox" name="type[]" value="Inspector Of Works"> Inspector Of Works </label>
            


          
                <label> 
                 <input type="checkbox" name="type[]" value="Transport Officer"> Transport Officer </label>
     

              


                <label> 
                 <input type="checkbox" name="type[]" value="Head Procurement"> Head Procurement </label>
     


               <div class="checkbox">
                <label> 
                 <input type="checkbox" name="type[]" value="CLIENT"> CLIENT </label>
        



             
                <label> 
                 <input type="checkbox" name="type[]" value="UDSM STAFF"> UDSM STAFF </label>
            
</DIV>

	</div>

	
<div class="row">
	<div class="col">
		<div class="form-group ">
	    <label for="uname">Username</label>
	     <input style="color: black" style="color: black" required  maxlength="20" type="text" class="form-control" id="uname" aria-describedby="emailHelp" name="name" placeholder="Enter username" value="{{ old('name') }}">
	 </div>
	</div>
	<div class="col">
		<div class="form-group ">
	    <label style="color: black" for="pass">Password</label>
	    <div class="row">
	    	<div class="col-md-8">
	    <input style="color: black" required maxlength="15"  minlength="8"  type="text" class="form-control" id="pass" aria-describedby="emailHelp" name="password" placeholder="Should have 8 characters minimum">
	    	</div>
	    <button type="button" onclick="generatePass()" class="btn btn-danger">Generate Password</button>
	    </div>
	</div>
	</div>
</div>


	
                <div class="form-group">
                    <input required type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                </div>
    <div align="center">           
	<button type="submit" class="btn btn-success">Create User</button>
	<a class="btn btn-info" href="/viewusers" role="button">Cancel </a>
</div>
    </form>

</div>
<br>
@endSection