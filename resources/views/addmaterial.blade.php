@extends('layouts.master')

@section('title')
   Add new Material
    @endSection

@section('body')
    <br>
    <div class="row" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h2 align="center">Add new Material</h2>
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

    <p align="center" style="color: red">All fields are compulsory</p>
    </br>
    <form method="POST" action="{{ route('material.create') }}">
        @csrf
		
		<div align="center" class="col-lg-12">
		
		
            <div class="input-group mb-3 col-lg-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Material Name</label>
                </div>
                <input style="color: black" required type="text" maxlength="35" class="form-control" id="name"
                       aria-describedby="emailHelp" name="name" placeholder="Material Name">
            </div>
		         

             <div class="input-group mb-3 col-lg-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Brand Name</label>
                </div>
                <input style="color: black" required type="text" maxlength="35" class="form-control" id="description"
                       aria-describedby="emailHelp" name="description" placeholder="Material Brand Name">
            </div>
		
		
		 
            <div class="input-group mb-3 col-lg-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Value/Capacity</label>
                </div>
                <input style="color: black" required type="text" maxlength="35" class="form-control" id="brand"
                       aria-describedby="emailHelp" name="brand" placeholder="Material Value/Capacity">
            </div>
        
		
		
        <div class="input-group mb-3 col-lg-6">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Material Type</label>
            </div>
            <select required class="custom-select" id="inputGroupSelect01" name="m_type">
                <option selected value="">Choose...</option>
                <option value="Electrical">Electrical</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Masonry/Road">Masonry/Road</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Carpentry/Painting">Carpentry/Painting</option>
                
            </select>
        </div>

       

        
            <div class="input-group mb-3 col-lg-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Quantity</label>
                </div>
                <input style="color: black" required type="number"  class="form-control" id="stock"
                       aria-describedby="emailHelp" name="stock" placeholder="Enter Quantity of material">
            </div>
        
        <button type="submit" class="btn btn-primary">Add Material</button>

        <a class="btn btn-danger" href="/home" role="button">Cancel</a>
    </div>

        </div>
    </form>

    <br>
    <script type="text/javascript">

      
    </script>
    @endSection