@extends('layouts.master')

@section('title')
    Add Directorate
    @endSection
@section('body')

  <br>
      <div class="container">
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
                <h4 >Add new college/Directorate</h4>
                <hr >
                <form method="POST" action="{{ route('directorate.save') }}" class="col-md-6">
                    @csrf
                    <div class="form-group ">
                        <label for="dir_name">college/directorate name <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="dir_name"
                               name="dir_name" placeholder="Enter college/directorate name">
                    </div>
                    <div class="form-group ">
                        <label for="dir_abb">college/directorate abbreviation <sup style="color: red;">*</sup></label>
                        <input style="color: black" type="text" required class="form-control" id="dir_abb"
                               name="dir_abb" placeholder="Enter College/directorate abbreviation">
                    </div>
                    <button type="submit" class="btn bg-primary btn-primary">Save
                    </button>
                    <a href="/Manage/directorate" class="btn bg-danger btn-danger">Cancel
                    </a>
                </form>
            </div>
            </div>

    @endSection