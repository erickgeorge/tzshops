@extends('layouts.master')

@section('title')
    change profile
    @endSection

@section('body')
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

    <div class="col-md-6">
        <p style="color: red">Edit your profile email and phone</p>

        <form action="{{ route('profile.change') }}" method="POST">
            @csrf
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
	</div>  </div>
            <button type="submit" style="background-color:#2E77BB;border-color:#2E77BB;" class="btn btn-success">Change profile</button>
            <a href="{{ route('home') }}" style="background-color:#F9B100;border-color:#F9B100;" class="btn btn-danger">Cancel</a>
        </form>
    </div>
    @endSection