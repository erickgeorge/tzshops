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
<div class="container">

    <br>
    <div class="row container-fluid" >
        <div class="col-lg-12">
            <h5 style="text-transform: capitalize;" >Change Profile</h5>
        </div>
    </div>
    <hr class="container">
    <div class="container">
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
    </div>

    <div class="row">
            @if ($message = Session::get('success'))

                <div class="alert alert-success alert-block">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <strong>{{ $message }}</strong>

                </div>

            @endif


        </div>


    <div class="col-lg-12" >
        <p>Edit your profile email and phone and picture if necesary</p>

        <form action="{{ route('profile.change') }}" method="POST"  enctype="multipart/form-data" >
            @csrf



	<div id="content">
          <div id="package_update">



<div class="row">
    <div class="col">
        <div class="form-group">

        <label for="fname"> First Name </label>
        <input disabled style="color: black"  required type="text"     name="phone"  value="{{ auth()->user()->fname }}"
        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "10"
         class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">

        <label for="phone">Last Name </label>
        <input disabled style="color: black"  required type="text"     name="phone"  value="{{ auth()->user()->lname }}"
        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "13"  minlength = "10"
         class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
    </div>

    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">

        <label for="phone">Phone number </label>
        <input style="color: black"  required type="text"     name="phone"  value="{{ auth()->user()->phone }}"
        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10"
         class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
        <label for="email">Email Address </label>
        <input style="color: black" required value="{{ auth()->user()->email }}" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onblur="validateEmail(this);"  maxlength="45" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
    </div>
    </div>
</div>
<div class="row">
    <div class="col"></div>
</div>






      <div class="form-group">

                    <label for="Image" align="left">Profile Picture</label>
                <div class="form-group" >
                    <input type="file" class="form-control-file" name="Image" id="avatarFile" aria-describedby="fileHelp" accept="image/*">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                </div>
                <div>
                    <br>
            <button type="submit"  class="btn btn-primary">Save</button>
            <a href="{{ route('home') }}" class="btn btn-danger">Cancel</a>
        </div>
            </form>


    </div>
</div>
<div id="previous_update" align="center">
      <div class="row justify-content-center">
       <div class="profile-header-container">
                <div class="profile-header-img">
                    @if (auth()->user()->avatar == 'user.png')
                                    <img class="rounded-circle" src="{{asset('/images/user.png')}}" />
                                    @else
                                    <img class="rounded-circle" src="/storage/{{ $user->avatar }}" height="100" />

                                    @endif

                </div>
            </div>
          </div>
          @if (auth()->user()->avatar != 'user.png')
          <br><br><br>
          <div class="row">
              <div class="col">
              <form action="{{route('deleteprofilepicture')}}" method="post">
                @csrf
                      <button type="submit" class="btn btn-danger">Delete Profile Picture</button>
                  </form>
              </div>
          </div>
          @endif
    </div>
</div>





</body>
</html>
<br>


    @endSection
