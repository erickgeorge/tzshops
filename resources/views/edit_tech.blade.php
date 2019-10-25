@extends('layouts.master')

@section('title')
    edit tech
    @endSection
@section('body')
    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center">Edit technician</h3>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger">
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
    <div class="col-lg-12">
        <form method="POST" action="{{ route('tech.edit', [$tech->id]) }}">
            @csrf
            <div align="center">
            <div class="form-group col-lg-6">
                <label for="fname">First name</label>
                <input type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " value="{{ $tech->fname }}">
            </div>
            <div class="form-group col-lg-6">
                <label for="lname">Last name</label>
                <input type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 " value="{{ $tech->lname }}">
            </div>
            <div class="form-group col-lg-6">
                <label for="phone">Phone number</label>
                <input  required type="text"     name="phone"  value="{{ $tech->phone }}"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "13"  minlength = "2"
                        class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
            </div>
            <div class="form-group col-lg-6">
                <label for="email">Email Address</label>
                <input required type="email"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ $tech->email }}">
            </div>

            <button type="submit" class="btn btn-primary">save</button>
            <a class="btn btn-danger" href="/technicians" role="button">Cancel </a>
        </div>
        </form>
    </div>
    <br>
    @endSection