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


</table>
                <h4 style="margin-top: 6%;" align="center" id="Add New campus">Register New Hall of Resdence</h4>
                <hr>
                <p align="center" style="color: red">All fields are compulsory</p>
              
                <form method="POST" action="{{ route('hall.save') }}" class="col-lg-12">
                    @csrf

<div align="center">
                     <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label class="input-group-text" for="directorate">Campus Name</label>
                        </div>
                        <select required class="custom-select" name="campus" id="campus">
                            <option value="">Choose...</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->campus_name }}</option>
                            @endforeach

                        </select>
                    </div>


                    <div class="form-group col-lg-6 ">
                        <label for="dir_name">Hall Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="hall_name" placeholder="Enter Hall Name">
                    </div>

                     


                    <div class="form-group col-lg-6">
                        <label for="dir_name">Area</label>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="area_name" placeholder="Enter Hall Area">
                    </div>


                    <div class="form-group col-lg-6">
                        <label for="dir_name">Type</label>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="type" placeholder="Enter Hall Type">
                    </div>

                    <div class="form-group col-lg-6 ">
                        <label for="dir_name">Location</label>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="location" placeholder="Enter Hall Location">
                    </div>
                   
                    
                    
                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New Hall
                    </button>
                    <a class="btn btn-info" href="/manage_Houses" role="button">Cancel </a>
                </div>
                </form>
@endSection