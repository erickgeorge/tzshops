@extends('layouts.master')

@section('title')
    Add Section For Works order
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
                <h5 style="text-transform: capitalize;"  id="new_dep">Add new iow zone</h5>
                <hr>
                <form method="POST" action="{{ route('iowzone.save') }}" class="col-md-6">
                    @csrf

                    <div class="form-group ">
                        <label for="dep_name" style="color: black;">IoW zone Name</label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "30"
                               name="zonename" placeholder="Enter Zone Name ">
                    </div>







                    <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a href="/Manage/IoWZones" class="btn btn-danger">Cancel
                    </a>
                </form>
            </div>





    @endSection
