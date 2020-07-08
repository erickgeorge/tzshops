@extends('layouts.asset')

@section('title')
Edit Work in Progress
    @endSection

@section('body')
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Edit Work in Progress</b></h5>
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
@foreach ($land as $item)
        <form action="{{route('assetsWorkinProgressEditSave')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                           <div class="form-group">
                               <label for="my-textarea">Asset Description</label>
                               <textarea id="description" class="form-control" name="AssetDescription" rows="3" required>{{$item->assetDescription}}</textarea>
                           </div>
                           <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Site Location</label>
                                   <input id="location" required value="{{$item->assetLocation}}" required class="form-control" placeholder="Site Location" type="text" name="SiteLocation">
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">Asset Number</label>
                                   <input id="assetnumber" value="{{$item->assetNumber}}" required class="form-control" placeholder="Asset Number" type="text" name="AssetNumber">
                               </div>
                           </div>
                           <div class="row">
                            <div class="form-group col">
                                <label for="my-input">Quantity</label>
                                <input id="quantity" required min="1" class="form-control" value="{{$item->assetQuantity}}" type="number" name="Quantity">
                            </div>
                            <div class="form-group col">
                                <label for="my-input">Cost/Rep. Cost</label>
                                <input id="quantity" value="{{$item->Cost}}" required min="1" class="form-control" value="1" type="number" name="cost">
                            </div>
                           </div>
                            <input type="text" name="id" id="" value="{{$item->id}}" hidden>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="form-group col-md-2">
                    <a href="{{route('assetsWorkinProgressView',[$item->id])}}" class="form-control btn btn-danger" name="newcard">Cancel</a>
                </div>
                <div class="form-group col-md-2">
                    <button id="newcard" class="form-control btn btn-primary" name="newcard">Submit</button>
                </div>
            </div>
        </form>
        @endforeach


</div>

@endSection
