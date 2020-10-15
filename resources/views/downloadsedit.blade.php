@extends('layouts.master')

@section('title')
   Edit Document
    @endSection
@section('body')

<div class="container">
    <br>
    <div class="row">
        <div class="col-lg-12" >
            <h4 style="text-transform: capitalize;" >Edit Document</h4>
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
</div>
<div class="card">
    <div class="card-body">
        <p class="card-text">
            <form action="{{route('saveheaddownloads')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="id" value="{{ $data['id'] }}" hidden>
                <div class="form-group">
                  <label for="">Update Document Name</label>
                  <input required type="text" value="{{ $data['name'] }}" name="name" id="" class="form-control" placeholder="" aria-describedby="helpId">
                  <small id="helpId" class="text-danger">Required</small>
                </div>
                <div class="form-group">
                  <label for="">Update Document File</label>
                  <input required type="file" name="file" accept="application/pdf" id="" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                  <small id="helpId" class="text-danger">Required, File should only be in PDF format</small>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
                <a class="btn btn-danger" href="{{route('downloads')}}" role="button"> Cancel </a>
            </form>
        </p>
    </div>
</div>
@endsection
