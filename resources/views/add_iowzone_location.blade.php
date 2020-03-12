@extends('layouts.master')

@section('title')
    Add Location For IoW
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
                <h4 id="new_dep">Add new location</h4>
                <hr>
                <form method="POST" action="{{ route('iowzone.location.save' , [$iowuser->id , $iowuserzone->zone]) }}" class="col-md-6">
                    @csrf
                   
                    <div class="form-group ">
                        <label for="dep_name" style="color: black;">Location Name</label>
                        <input style="color: black" type="text" required class="form-control" id="dep_name"     
                               name="location" placeholder="Enter Location Name ">
                    </div>

                    
                    <button type="submit" class="btn bg-primary btn-primary">Save
                    </button>
                    <a href="{{route('view.location', [$iowuser->id , $iowuserzone->zone])}}" class="btn btn-danger">Cancel
                    </a>
                </form>
            </div>



          

    @endSection