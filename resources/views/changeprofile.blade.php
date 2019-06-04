@extends('layouts.master')

@section('title')
    change profile
    @endSection

@section('body')

<style>
body {

}
#content {
    width: 980px;
    margin: auto;
   
     
    width: 980px;
height: auto;
padding: 20 20 20 20;

}
#package_update {
    width: 680px;
    height: 500px;
    float: left;
   
}

#previous_update {
    width: 280px;
    height: 500px;
    float: right;
    padding: 9px;
   
}}
</style>


    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3>Change Profile</h3>
        </div>
    </div>
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
 
    <div class="row">
            @if ($message = Session::get('success'))

                <div class="alert alert-success alert-block">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <strong>{{ $message }}</strong>

                </div>

            @endif

            
        </div>


    <div class="col-md-6">
        <p style="color: red">Edit your profile email and phone</p>

        <form action="{{ route('profile.change') }}" method="POST">
            @csrf
         
	
	
	<div id="content">
          <div id="package_update">
	  <div class="form-group ">
               
	    <label for="fname">	First Name</label>
	    <input disabled style="color: black"  required type="text"     name="phone"  value="{{ auth()->user()->fname }}"
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "10"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
	</div>
   

  
	
	
	  <div class="form-group ">
               
	    <label for="phone">Last Name</label>
	    <input disabled style="color: black"  required type="text"     name="phone"  value="{{ auth()->user()->lname }}"
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "10"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
	</div>
	
	   <div class="form-group ">
               
	    <label for="phone">Phone number</label>
	    <input style="color: black"  required type="text"     name="phone"  value="{{ auth()->user()->phone }}"
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "10"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
	</div>
	
	
	
	
	<div class="form-group ">
	    <label for="email">Email Address</label>
	    <input style="color: black" required value="{{ auth()->user()->email }}" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
	</div>  
     <div>
            <button type="submit" style="background-color:#2E77BB;border-color:#2E77BB;" class="btn btn-success">Change profile</button>
            <a href="{{ route('home') }}" style="background-color:#F9B100;border-color:#F9B100;" class="btn btn-danger">Cancel</a>
        </div>
        </form>
    
      <br>
      <div class="form-group">
            <form action="/myprofile" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                </div>
                <button type="submit" class="btn btn-primary" style="background-color:#2E77BB;border-color:#2E77BB;">Submit</button>
            </form>
        
    
</div>
</div>
<div id="previous_update">   <div class="row justify-content-center">
       <div class="profile-header-container">
                <div class="profile-header-img">
                    <img class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}" />
                    <!-- badge -->
                  
                </div>
            </div>
          </div>
    </div>
</div>





</body>
</html>
<br>


    @endSection