@extends('layouts.master')

@section('title')
   New Document
    @endSection
@section('body')

<div class="container">
    <br>
    <div class="row">
        <div class="col-lg-12" >
            <h4 style="text-transform: capitalize;" >Add New Document</h4>
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

<div class="card">
    <div class="card-body">
        <p class="card-text">
            <form action="{{route('savedownloads')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="">Document Name</label>
                  <input required type="text" name="name" id="" class="form-control" placeholder="" aria-describedby="helpId">
                  <small id="helpId" class="text-danger">Required</small>
                </div>
                <div class="form-group">
                  <label for="">Document File</label>
                  <input required type="file" name="file" accept="application/pdf" id="" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                  <small id="helpId" class="text-danger">Required, File should only be in PDF format</small>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
                <a class="btn btn-danger" href="{{route('downloads')}}" role="button"> Cancel </a>
            </form>
        </p>
    </div>
</div>

</div>
@endsection
