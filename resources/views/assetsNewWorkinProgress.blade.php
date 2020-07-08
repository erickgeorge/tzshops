@extends('layouts.asset')

@section('title')
New Work in Progress Asset
    @endSection

@section('body')
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Add New Work in Progress Asset</b></h5>
        </div>
    </div>
    <hr class="container">
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ Session::get('message') }}</li>
                </ul>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                 <ul class="alert alert-danger" style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li><?php echo $error; ?></li>
                    @endforeach
                </ul>
            </div>
        @endif

        </div>

        <form action="{{route('assetsNewWorkinProgressSave')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                           <div class="form-group">
                               <label for="my-textarea">Asset Description</label>
                               <textarea id="description" class="form-control" name="AssetDescription" rows="3" required></textarea>
                           </div>
                           <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Site Location</label>
                                   <input id="location" required class="form-control" placeholder="Site Location" type="text" name="SiteLocation">
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">Asset Number</label>
                                   <input id="assetnumber"  class="form-control" placeholder="Asset Number" type="text" name="AssetNumber">
                               </div>
                           </div>
                           <div class='row'>
                               <div class="form-group col">
                                   <label for="my-input">Quantity</label>
                                   <input id="quantity"  min="1" class="form-control"   type="number" name="Quantity">
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">Cost/Rep. Cost</label>
                                   <input id="quantity"  required min="0" class="form-control"   type="number" name="cost">
                               </div>
                           </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="form-group col-md-3">
                    <a href="{{route('assetsWorkinProgress')}}" id="newcard" class="form-control btn btn-danger text-light" name="newcard">Cancel</a>
                </div>
                <div class="form-group col-md-2">
                    <button id="newcard" class="form-control btn btn-primary" name="newcard">Submit</button>
                </div>
            </div>
        </form>
        <br>
@endSection
