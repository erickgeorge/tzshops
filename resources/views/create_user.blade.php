@extends('layouts.master')

@section('title')
User Registrartion
@endSection

@section('body')
<script src= 
"https://code.jquery.com/jquery-1.12.4.min.js"> 
	</script> 
 <style type="text/css">
 	#Div2 {
  display: none;
}

.selectt { 
			
			
			display: none; 
			 
		} 
		
		
 </style>
<br>
<div class="row" style="margin-top: 6%; margin-left: 3%;">
	<div class="col-md-8">
		<h2 class="container">Create New user</h2>
	</div>

	<!-- <div class="col-md-4">
		<a href="{{ url('viewusers') }}" > <button type="" class="btn btn-primary">View all users</button></a>
	</div> -->
</div>

<hr class="container">
<div class="container" >
@if ($errors->any())
<div class="alert alert-danger">
	 <ul class="alert alert-danger">
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



<form id="world" name="world" method="POST" action="{{ route('user.create') }}"  enctype="multipart/form-data">
                        @csrf
<div class="row">
	<div class="col">
		<div class="form-group ">
	    <label for="fname">First name</label>
	    <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " value="{{ old('fname') }}" >
	 </div>
	</div>
	<div class="col">
		<div class="form-group ">
	    <label for="lname">Last name </label>
	    <input style="color: black" type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 " value="{{ old('lname') }}">
	</div>
	</div>
	<div class="col">
		<div class="form-group ">
	    <label for="phone">Phone number </label>
	    <input style="color: black; width: 340px;"  required type="text"     name="phone"
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 "  value="{{ old('phone') }}">
	</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="input-group ">
	  <div class="input-group-prepend">
	    <label style="height:28px;" class="input-group-text" for="Email">Email </label>
	  </div>
	    <input style="color: black; height: 28px; width: 80px;" required   type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onblur="validateEmail(this);"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
	</div>
	</div>


	     <div class="col">
	<div class="align-content-center">
		<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label  style="height: 28px;" class="input-group-text" for="username">Username </label>
	  </div>
	     <input style="color: black; width:200px; height: 28PX;"  required  maxlength="20" type="text" class="form-control" id="uname" aria-describedby="emailHelp" name="name" placeholder="Enter username" value="{{ old('name') }}">
	 </div>
	</div>
	</div>
</div>

	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label  style="height: 28px" class="input-group-text" for="inputGroupSelect01">Role</label>
	  </div>
	  <select style="color: black; width: 460px" required class="custom-select" name="role" id="role">
	    <option value="" selected>Choose...</option>
	    <option value="1">Admin</option>
	    <option value="2">Staff</option>
	  </select>
	</div>

  

    
<div class="row">
	<div  class="col">
		<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label style="height: 28px" class="input-group-text" for="directorate">Directorate/College </label>
	  </div>
	  <select required style="color: black; width: 360px;" class="custom-select" name="college" id="directorate" onchange="getDepartments()" value="{{ old('directorate') }}">
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
	    <label style="height: 28px" class="input-group-text" for="department">Department </label>
	  </div>
	  <select required style="color: black; width: 410px;"  class="custom-select" name="department" id="department"  value="{{ old('department') }}">
	  </select>
	    </div>
	</div>




	

</div>





     <div>

	
	    <label>Type of User</label><br>

	    <div> 
			<label> 
				<input type="checkbox" 
					value="C">DES </label> 
					&nbsp;&nbsp;&nbsp;
			<label> 
				<input type="checkbox" 
					value="Cplus"> UDSM</label> 
			
		</div> 

		<div class="C selectt">

	    <div >
       	<input id="Button1" type="checkbox" value="Click" onclick="switchVisible();"/>Head of Section
       </div>
              <div id="Div1" >
               <select style="width: 300px;" class="custom-select" name="type[]" id="type">
	                  <option value="" selected>Choose...</option>
	                  <option value="Accountant">Accountant</option>
	                  <option value="Auditor">Auditor</option>
	               
	                  
	                  <option value="Estates Director">Estates Director</option>
	                  <option value="Head Procurement">Head of Procurement</option>
	                  <option value="Inspector Of Works">Inspector Of Works</option>
	                  <option value="Maintenance coordinator">Maintenance Coordinator</option>
	                  <option value="STORE">Store Manager</option>
	                  <option value="Transport Officer">Transport Officer</option>
	           </select>
	           </div>
	           <br>

               <div  id="Div2">


                 <input type="checkbox" name="type[]"    value="HOS Electrical"> HOS Electrical

                &nbsp;&nbsp;&nbsp;

                 <input type="checkbox" name="type[]"  value="HOS Plumbing"> HOS Plumbing

                &nbsp;&nbsp;&nbsp;


                 <input type="checkbox"  name="type[]"   value="HOS Carpentry/Painting"> HOS Carpentry/Painting

                &nbsp;&nbsp;&nbsp;




                 <input type="checkbox" name="type[]"  value="HOS Mechanical"> HOS Mechanical



                &nbsp;&nbsp;&nbsp;

                 <input type="checkbox"  name="type[]"   value="HOS Masonry/Road"> HOS Masonry/Road

                &nbsp;&nbsp;&nbsp;
                    @foreach($worksec as $dep)
                   
                      
                            
                           
                           <input type="checkbox"  name="type[]"  value="{{$dep->section_name}}" > {{ $dep->section_name }} &nbsp;&nbsp;&nbsp;

                      
                                
                           
                    @endforeach


          </div>
    </div>

    <div class="Cplus selectt" >
    	<div  >
               <select style="width: 300px;" class="custom-select" name="type[]" id="typeudsm">
	                  <option value="" selected>Choose...</option>
	                 
	                  <option value="CLIENT">Client</option>
	                  <option value="DVC Admin">DVC Admin</option>
	                  
	           </select>
	           </div>
    	
    </div>





	 



</div>
</div>


<div>

	<!--<div class="col">
		<div class="form-group ">
	    <label style="color: black" for="pass">Password</label>
	    <div class="row">
	    	<div class="col-md-8">
	    <input style="color: black" required maxlength="15"  minlength="8"  type="text" class="form-control" id="pass" aria-describedby="emailHelp" name="password" placeholder="Should have 8 characters minimum">
	    	</div>
	    <button type="button" onclick="generatePass()" class="btn btn-danger">Generate Password</button>
	    </div>
	</div>
	</div>-->
</div>



               <!-- <div class="form-group">
                    <input  type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp" value="{{ old('avatar') }}">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                </div>-->
    <div align="center">
	<button type="submit" class="btn btn-primary"> Save</button>
	<a class="btn btn-danger" href="/viewusers" role="button">Cancel </a>
</div>
    </form>

</div>





  <script type="text/javascript">

	function switchVisible() {
            if (document.getElementById('Div1')) {

                if (document.getElementById('Div1').style.display == 'none') {
                    document.getElementById('Div1').style.display = 'block';
                    document.getElementById('Div2').style.display = 'none';
                }
                else {
                    document.getElementById('Div1').style.display = 'none';
                    document.getElementById('Div2').style.display = 'block';
                }
            }
}
  </script>

  <script type="text/javascript"> 
			$(document).ready(function() { 
				$('input[type="checkbox"]').click(function() { 
					var inputValue = $(this).attr("value"); 
					$("." + inputValue).toggle(); 
					 
				}); 
			}); 
</script> 


 

@endSection
