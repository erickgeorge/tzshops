@extends('layouts.master')

@section('title')
Campus Registration
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


</table>
                <h4 id="Add New campus">Register New Campus</h4>
                <hr>
                <p style="color: red">All fields are compulsory</p>
                <form method="POST" action="{{ route('campus.save') }}" class="col-md-6">
                    @csrf
                    <div class="form-group ">
                        <label for="dir_name">Campus Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="campus_name" placeholder="Enter Campus Name">
                    </div>

                    <div class="form-group ">
                        <label for="dir_abb">Campus Location</label>
                        <input style="color: black" type="text" required class="form-control" id="houselocation"
                               name="location" placeholder="Enter Campus Location ">
                    </div>

                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New Campus
                    </button>
                        <a class="btn btn-info" href="/manage_Houses" role="button">Cancel </a>
                    
                </form>
            </div>
            
	
<br>
@endSection