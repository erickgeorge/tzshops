@extends('layouts.master')

@section('title')
   Add new Material
    @endSection

@section('body')
    <br>
    <div class="row">
        <div class="col-md-8">
            <h2>Add new Material</h2>
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
    <form method="POST" action="{{ route('material.create') }}"   style="width:500px;">
        @csrf
		
		
		
		 <div >
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Material Name</label>
                </div>
                <input style="color: black" required type="text" maxlength="35" class="form-control" id="name"
                       aria-describedby="emailHelp" name="name" placeholder="Material Name">
            </div>
        </div>
		
		
		
		 <div >
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Material Description</label>
                </div>
                <input style="color: black" required type="text" maxlength="35" class="form-control" id="description"
                       aria-describedby="emailHelp" name="description" placeholder="Material Description">
            </div>
        </div>
		
		
        <div class="input-group mb-3">
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

       

        <div >
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Quantity</label>
                </div>
                <input style="color: black" required type="number"  class="form-control" id="stock"
                       aria-describedby="emailHelp" name="stock" placeholder="Current Stock">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Add Material</button>

        <a class="btn btn-info" href="/home" role="button">Cancel Changes</a>

        </div>
    </form>

    <br>
    <script type="text/javascript">

      
    </script>
    @endSection