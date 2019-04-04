@extends('layouts.master')

@section('title')
    add tech
    @endSection
@section('body')
    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3>Add new technician</h3>
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
    <div class="col-md-6">
        <form method="POST" action="{{ route('tech.create') }}">
            @csrf
            <div class="form-group ">
                <label for="fname">First name</label>
                <input type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " value="{{ old('fname') }}">
            </div>
            <div class="form-group ">
                <label for="lname">Last name</label>
                <input type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 " value="{{ old('lname') }}">
            </div>
            <div class="form-group ">
                <label for="phone">Phone number</label>
                <input  required type="text"     name="phone"  value="{{ old('phone') }}"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "13"  minlength = "2"
                        class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
            </div>
            <div class="form-group ">
                <label for="email">Email Address</label>
                <input required type="email"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
            </div>

            <button type="submit" class="btn btn-success">Add technician</button>
        </form>
    </div>
    <br>
    @endSection