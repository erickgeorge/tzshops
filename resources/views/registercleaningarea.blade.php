@extends('layouts.master')

@section('title')
StaffHouse Registrartion
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


<br>
                <h4 style="margin-top: 6%;" align="center" id="Add New House">Register  New Cleaning Area</h4>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
    
                <form method="POST" action="{{ route('area.save') }}" class="col-lg-12">
                    @csrf

<div align="center">

                        <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label class="input-group-text" for="directorate">Zone Name <sup style="color: red;">*</sup></label>
                        </div>
                        <select required class="custom-select" name="zone" id="zone">
                            <option value="">Choose...</option>
                            @foreach($newzone as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->Zone_name }}</option>
                            @endforeach

                        </select>
                    </div> 

                <div class="form-group col-lg-6">
                        <label for="dir_name">Cleaning Area Name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="cleaning_name" placeholder="Enter Cleaning Area Name">
                    </div>

                    <button type="submit" class="btn btn-primary">Register
                        New Cleaning Area
                    </button>
                      <a class="btn btn-danger" href="/manage_Houses" role="button">Cancel </a>
                  </div>
                </form>
                  
            </div>
            


@endSection