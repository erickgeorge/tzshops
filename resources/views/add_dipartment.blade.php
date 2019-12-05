@extends('layouts.master')

@section('title')
    Add Directorate
    @endSection
@section('body')

  <br>
      <div style="padding-top: 60px;" class="container">
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
                <h4 id="new_dep">Add new department</h4>
                <hr>
                <form method="POST" action="{{ route('department.save') }}" class="col-md-6">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label style="height: 28px;" class="input-group-text" for="directorate">Directorate/College <sup style="color: red;">*</sup></label>
                        </div>
                        <select required class="custom-select" name="directorate" id="directoratee">
                            <option value="">Choose...</option>
                            @foreach($directorates as $directorate)
                                <option value="{{ $directorate->id }}">{{ $directorate->directorate_description }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="dep_name">Department name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"
                               name="dep_name" placeholder="Enter department name">
                    </div>
                    <div class="form-group ">
                        <label for="dep_ab">Department abbreviation <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required maxlength="8" class="form-control" id="dep_ab"
                               name="dep_ab" placeholder="Enter department abbreviation">
                    </div>
                    
                    <button type="submit" class="btn bg-primary btn-primary">Save
                    </button>
                    <a href="/Manage/department" class="btn btn-danger">Cancel
                    </a>
                </form>
            </div>

    @endSection