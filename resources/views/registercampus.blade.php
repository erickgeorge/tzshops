@extends('layouts.master')

@section('title')
Campus Registration
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

                <h4 style="margin-top: 6%" align="center" id="Add New campus">Register New Campus</h4>
                <hr>
                <p align="center" style="color: red; margin-left: 2%;">All fields are compulsory</p>
                <form method="POST" action="{{ route('campus.save') }}" class="col-lg-12">
                    @csrf
                    <div  align='center'>


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:200px;" class="input-group-text" for="directorate">Campus Name <sup style="color: red;">*</sup></label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="campus_name" placeholder="Enter Campus Name">
                    </div>

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:200px;" class="input-group-text" for="directorate">Campus Location<sup style="color: red;">*</sup></label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="location" placeholder="Enter Campus Location ">
                    </div>

                    


                    <button  type="submit" class="btn btn-primary">Register
                        New Campus
                    </button>
                        <a class="btn btn-danger" href="/manage_Houses" role="button">Cancel </a>
                    </div>
                </form>
            </div>
            
	
<br>
@endSection