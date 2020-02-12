@extends('layouts.asset')

@section('title')
Campus Registration
@endSection

@section('body')

@if ($errors->any())


<div class="container">
  <br>
  <br>
<div class="alert alert-danger" style="margin-top: 86%;">
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
<div class="container">
                <h4   id="Add New campus">Register New Campus</h4>
                <hr>

                <p align="center" style="color: red; margin-left: 2%;">All fields are compulsory</p>
                <form method="POST" action="{{ route('campus.save') }}" class="col-lg-12">
                    @csrf
                    <div  align='center'>


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:200px;" class="input-group-text" for="directorate">Campus Name </label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="campus_name" placeholder="Enter Campus Name">
                    </div>

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:200px;" class="input-group-text" for="directorate">Campus Location</label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="location" placeholder="Enter Campus Location ">
                    </div>

                    


                    <button  type="submit" class="btn btn-primary">Register
                        New Campus
                    </button>
                        <a class="btn btn-danger" href="/manage_Campus" role="button">Cancel </a>
                    </div>
                </form>
            </div>
            
	
<br>
@endSection