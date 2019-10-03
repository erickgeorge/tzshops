@extends('layouts.master')

@section('title')
    work order
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center">CHANGE PROBLEM TYPE :</h3>
        </div>
    </div>
    <hr>
	
	
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
	
	
	
	
	 <form method="POST" action="/changewoType" >
        @csrf
        <div align="center" class="col-lg-12">
    <div class="input-group mb-3 col-lg-6">
        <div class="input-group-prepend">
            <label class="input-group-text">Type of a problem</label>
        </div>
      <select required class="custom-select" id="inputGroupSelect01" name="p_type">
                <option selected value="" >Choose...</option>
                <option value="Electrical" >Electrical</option>
                <option value="Plumbing" >Plumbing</option>
                <option value="Masonry/Road" >Masonry/Road</option>
                <option value="Mechanical" >Mechanical</option>
                <option value="Carpentry/Painting" >Carpentry/Painting</option>
                <option value="Others" >Others</option>
            </select>
			<input required class="form-control" name="wo_id"
            value="{{ $wo->id }}" hidden>
			 <button type="submit" class="btn btn-success">Change Ptype</button>

     
    </div>
	</form>
	   <a class="btn btn-info" href="/work_order" role="button">Cancel Changes</a>
    <h5>This work order has been @if($wo->status == 0)Rejected@elseif($wo->status == 1) Accepted @else Processed @endif by <span
                style="color: green">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span></h5>
    <h5>It Has been created on <span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span>
    </h5>
    <h3 style="color: black">Contacts:</h3>
    <h5>{{ $wo['user']->phone }}</h5>
    <h5>{{ $wo['user']->email }}</h5>
    <br>

    <div class="input-group mb-3 col-lg-6">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        @if(empty($wo->room_id))
            <input style="color: black" type="text" required class="form-control" placeholder="location not defined"
                   name="location"
                   aria-describedby="emailHelp" value="{{ $wo->location }}" disabled>
        @else
            <input style="color: black" type="text" required class="form-control" placeholder="location not defined"
                   name="location"
                   aria-describedby="emailHelp" value="{{ $wo['room']['block']->location_of_block }}"
                   disabled>
        @endif
    </div>
    <div class="input-group mb-3 col-lg-6">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area"
               aria-describedby="emailHelp"
               value="{{ $wo->room_id }}" disabled>
    </div>
    <div class="input-group mb-3 col-lg-6">
        <div class="input-group-prepend">
            <label class="input-group-text">Block</label>
        </div>
        @if(empty($wo->room_id))
            <input style="color: black" type="text" required class="form-control" placeholder="block" name="block"
                   aria-describedby="emailHelp"
                   value="{{ $wo->location }}" disabled>
        @else
            <input style="color: black" type="text" required class="form-control" placeholder="block" name="block"
                   aria-describedby="emailHelp"
                   value="{{ $wo['room']['block']->name_of_block }}" disabled>
        @endif
    </div>
    <div class="input-group mb-3 col-lg-6">
        <div class="input-group-prepend">
            <label class="input-group-text">Room</label>
        </div>
        @if(empty($wo->room_id))
            <input style="color: black" type="text" required class="form-control" placeholder="room" name="room"
                   aria-describedby="emailHelp"
                   value="{{ $wo->location }}" disabled>
        @else
            <input style="color: black" type="text" required class="form-control" placeholder="room" name="room"
                   aria-describedby="emailHelp"
                   value="{{ $wo['room']->name_of_room }}" disabled>
        @endif
    </div>
    <div class="form-group col-lg-6">
        <label for="">Details:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
	
	<br>
    
    @endSection