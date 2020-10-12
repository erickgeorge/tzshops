@extends('layouts.master')

@section('title')
    Add Location
    @endSection
@section('body')


      <div  class="container">
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
                <h5 style="text-transform: capitalize; "  id="new_dep" >Add New Location</h5>
                <hr>
                <form method="POST" action="{{ route('add.location') }}" class="col-md-6">
                    @csrf

                    <div class="form-group ">
                        <label for="dep_name">Location Name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"
                               name="loc_name" placeholder="Enter Location Name">
                    </div>


                    <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a href="/Manage/locations" class="btn btn-danger">Cancel
                    </a>
                </form>
            </div>





    @endSection
