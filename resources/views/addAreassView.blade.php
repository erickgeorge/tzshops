@extends('layouts.master')

@section('title')
    Add Area
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
                <h5 style="text-transform: capitalize; "  id="new_dep" >Add New Area</h5>
                <hr>
                <form method="POST" action="{{ route('add.areass') }}" class="col-md-6">
                    @csrf

                    <div class="form-group ">
                        <label for="dep_name">Location Name  <sup style="color: red;">*</sup></label>
                        <select required style="color: black; " class="custom-select" name="Location"  value="{{ old('Location') }}">
                           <option selected value="" >Choose...</option>
                                @foreach($Location as $loc)
                                  <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="dep_name">Area Name  <sup style="color: red;">*</sup> </label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"
                               name="name_of_area" placeholder="Enter Area Name">
                    </div>


                    <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a href="/Manage/Areas" class="btn btn-danger">Cancel
                    </a>
                </form>
            </div>





    @endSection
