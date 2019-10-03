@extends('layouts.master')

@section('title')
Cleaningzone Registration
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
                <h4 style="margin-top:6%;" align="center"  id="Add New campus">Add New Cleaning Zone</h4>
                <hr>
                <p align="center" style="color: red">All fields are compulsory</p>
              
                <form method="POST" action="{{ route('zone.save') }}" class="col-lg-12">
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
                    <div class="form-group col-lg-6">
                        <label for="dir_name">Zone Name</label>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="zone_name" placeholder="Enter Zone Name">
                    </div>


                       


                     <div class="form-group col-lg-6">
                        <label for="dir_name">Zone Type</label>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="type" placeholder="Enter Zone Type">
                    </div>


                    <button style="background-color: green; color: white" type="submit" class="btn btn-success">Register
                        New Zone
                    </button>
                     <a class="btn btn-info" href="/manage_Houses" role="button">Cancel </a>
                 </div>
                </form>
            </div>
                   
               @endSection