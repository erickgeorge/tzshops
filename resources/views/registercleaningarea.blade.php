@extends('layouts.master')

@section('title')
StaffHouse Registrartion
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


<br>
                <h4 id="Add New House">Register  New Cleaning Area</h4>
                      <hr>
                 <p style="color: red">All fields are compulsory</p>
    
                <form method="POST" action="{{ route('area.save') }}" class="col-md-6">
                    @csrf



                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            
                            <label class="input-group-text" for="directorate">Zone Name</label>
                        </div>
                        <select required class="custom-select" name="zone" id="zone">
                            <option value="">Choose...</option>
                            @foreach($newzone as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->Zone_name }}</option>
                            @endforeach

                        </select>
                    </div> 

                <div class="form-group ">
                        <label for="dir_name">Cleaning Area Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="cleaning_name" placeholder="Enter Cleaning Area Name">
                    </div>

                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New Cleaning Area
                    </button>
                      <a class="btn btn-info" href="/manage_Houses" role="button">Cancel </a>
                </form>
                  
            </div>
            


@endSection