

@extends('layouts.master')

@section('title')
Create Work Orders
@endSection

@section('body')
<br>
<div class="row">
	<div class="col-md-8">
		<h2>Create new work order</h2>
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
<p style="color: red">All fields are compulsory</p>
</br>
<form method="POST" action="{{ route('workorder.create') }}">
	@csrf
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="inputGroupSelect01">Type of problem</label>
	  </div>
	  <select required class="custom-select" id="inputGroupSelect01" name="p_type">
	    <option selected>Choose...</option>
	    <option value="Electrical">Electrical</option>
	    <option value="Plumbing">Plumbing</option>
	    <option value="Furniture">Furniture</option>
	     <option value="Others">Others</option>
	     
	  </select>
	</div>


<?php
use App\Location;
 $location = Location::get();
?>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="inputGroupSelect01">Location</label>
	  </div>
	  <select class="custom-select" id="location" name="location" onclick="getAreas()">
	    <option required selected>Choose...</option>

	    @foreach($location as $loc)
	    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
	    @endforeach
	   
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="area">Area</label>
	  </div>
	  <select class="custom-select" id="area" name="area" onclick="getBlocks()">
	    <option selected>Choose...</option>
	  </select>
	</div>
	<div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="block">Block</label>
	  </div>
	  <select class="custom-select" id="block" name="block" onclick="getRooms()">
	    <option selected>Choose...</option>
	  </select>
	</div>

    <div class="input-group mb-3">
	  <div class="input-group-prepend">
	    <label class="input-group-text" for="room">Room</label>
	  </div>
	  <select class="custom-select" id="room" name="room">
	    <option selected>Choose...</option>
	  </select>
      </div> 

<div class="form-group">
  <label for="comment">Details:</label>
  <textarea name="details" value="{{ old('details') }}" required maxlength="100" class="form-control"  rows="5" id="comment"></textarea>
    </div>
<button type="submit" class="btn btn-success">Create Workorder</button>
	</div>
</form>

<br>
  <script type="text/javascript">	
  	$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
  });
  </script>
@endSection