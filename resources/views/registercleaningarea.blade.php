@extends('layouts.asset')

@section('title')
StaffHouse Registrartion
@endSection

@section('body')
<br>

@if ($errors->any())
<div class="alert alert-danger" >
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

<div class="container">

                <h5 style="  text-transform: uppercase;"  id="Add New House">Register  new cleaning area</h5>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
    
                <form method="POST" action="{{ route('area.save') }}" class="col-lg-12">
                    @csrf

<div align="center">

                        <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:150px;" class="input-group-text" for="directorate">Zone Name </label>
                        </div>
                        <select required class="custom-select" name="zone" id="zonne">
                            <option value="">Choose...</option>
                            @foreach($newzone as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->zonename }}</option>
                            @endforeach

                        </select>
                    </div> 

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:200px;" class="input-group-text" for="directorate">Cleaning Area Name </label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="cleaning_name" placeholder="Enter Cleaning Area Name">
                    </div>
                

                    <button type="submit" class="btn btn-primary">Save
                    </button>
                      <a class="btn btn-danger" href="/manage_Cleaning_area" role="button">Cancel </a>
                  </div>
                </form>
                  
            </div>
            


@endSection