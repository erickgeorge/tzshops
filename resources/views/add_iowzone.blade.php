@extends('layouts.master')

@section('title')
    Add Section For Workorder
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
                <h4 id="new_dep">Add new iow zone</h4>
                <hr>
                <form method="POST" action="{{ route('iowzone.save') }}" class="col-md-6">
                    @csrf
                   
                    <div class="form-group ">
                        <label for="dep_name" style="color: black;">IoW zone Name</label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "30"  
                               name="zonename" placeholder="Enter Zone Name ">
                    </div>

                    <!--<div class="form-group ">
                        <label for="dep_name" style="color: black;">Location</label>
                        <input style="color: black" type="text" required class="form-control" id="d"   maxlength = "15"  
                               name="location" placeholder="Enter Zone Location">
                    </div>-->

                   <div class="form-group ">
                        <label for="dep_name" style="color: black;">Inspector of Work</label>
                         
                         <select required class="custom-select" name="iow" id="iow">
                            <option value="">Choose...</option>
                            @foreach($iows as $user)
                                <option value="{{ $user->id }}">{{ $user->fname .'  '.$user->lname }}</option>
                            @endforeach

                        </select>
                    </div>


                   
                   
                    
                    <button type="submit" class="btn bg-primary btn-primary">Save
                    </button>
                    <a href="/Manage/IoWZones" class="btn btn-danger">Cancel
                    </a>
                </form>
            </div>



          

    @endSection