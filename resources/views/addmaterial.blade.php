@extends('layouts.master')

@section('title')
    Addmaterial
    @endSection

@section('body')
    <br>
    <div class="row">
        <div class="col-md-8">
            <h2>Add New Material</h2>
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

    <p style="color: red">All fields are compulsory</p>
    </br>
    <form method="POST" action="{{ route('workorder.create') }}">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Material Type</label>
            </div>
            <select required class="custom-select" id="inputGroupSelect01" name="p_type">
                <option selected value="">Choose...</option>
                <option value="Electrical">Electrical</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Masonry/Road">Masonry/Road</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Carpentry/Painting">Carpentry/Painting</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <?php
        use App\Location;
        $location = Location::get();
        ?>

    <div class="form-group ">
        <label for="fname">Material name</label>
        <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter Material Name"  >
     </div>

       <div class="form-group ">
        <label for="fname">Material Description</label>
        <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter Material Description"  >
     </div>

       <div class="form-group ">
        <label for="fname">Material Quantity</label>
        <input style="color: black" type="number" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter Material Quantity"  >
     </div>

        
                
        
        <button type="submit" class="btn btn-success">Add New Material</button>

        <a class="btn btn-info" href="/work_order" role="button">Cancel Changes</a>

    @endSection