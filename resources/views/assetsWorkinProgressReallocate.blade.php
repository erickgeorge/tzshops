@extends('layouts.asset')

@section('title')
Reallocate Work in Progress to Assets
@endSection

@section('body')
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col ">
            <h5><b >Reallocate Work in Progress to Assets</b></h5>
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

</div>

<div class="container">
    @if (count($land)>0)
        <div class="card">
            @foreach ($land as $landinfo)
                <div class="card-header">
                    Asset Summary
                </div>
                <div class="card-body" style="background-color: #6c757d33 !important;">
                    <p class="card-text">
                            <div class="row">
                                <div class="col">
                                   Description: <br>{{$landinfo->assetDescription}}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                   Asset Number: <br>{{$landinfo->assetNumber}}
                                </div>
                                <div class="col">
                                  Asset Location: <br> {{$landinfo->assetLocation}}
                                </div>
                                <div class="col-md-3">
                                 Asset Quantity: <br>  {{$landinfo->assetQuantity}}
                                </div>
                                <div class="col">
                                    Cost/Repairing Cost : <br> {{number_format($landinfo->Cost)}}
                                </div>
                            </div>
                    </p>
                </div>

        </div>
<br><br><br><br>

                <div class="row container-fluid" >
                    <div class="col">
                        <h5 class="text-center"><b> <i class="fa fa-info-circle text-danger" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp; Fill the Form Below to Reallocate Work in Progress to Building Assets</b></h5>
                    </div>
                </div><hr>


                <form action="{{route('assetsWorkinProgressReallocateSave')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                   <div class="form-group">
                                       <label for="my-textarea">Asset Description <sup class="text-danger">*</sup></label>
                                       <textarea id="description" class="form-control" name="AssetDescription" rows="3" required>{{$landinfo->assetDescription}}</textarea>
                                   </div>
                                   <div class="row">
                                       <div class="form-group col">
                                           <label for="my-input">Site Location <sup class="text-danger">*</sup></label>
                                           <input id="location" required value="{{$landinfo->assetLocation}}" required class="form-control" placeholder="Site Location" type="text" name="SiteLocation">
                                       </div>
                                       <div class="form-group col">
                                           <label for="my-input">Asset Number <sup class="text-danger">*</sup></label>
                                           <input id="assetnumber" value="{{$landinfo->assetNumber}}" required class="form-control" placeholder="Asset Number" type="text" name="AssetNumber">
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="form-group col">
                                           <label for="my-input">Quantity <sup class="text-danger">*</sup></label>
                                           <input id="quantity" required min="1" class="form-control" value="{{$landinfo->assetQuantity}}" type="number" name="Quantity">
                                       </div>
                                        <div class="form-group col">
                                            <label for="my-input">Asset Condition <sup class="text-danger">*</sup></label>
                                            <select id="assetnumber" required class="form-control" name="AssetCondition">
                                                <option selected value="New">New</option>
                                                <option value="Good">Good</option>
                                                <option value="Fair">Fair</option>
                                                <option value="Poor">Poor</option>
                                                <option value="Very Poor">Very Poor</option>
                                                <option value="Absolute">Absolute</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="my-input">Cost/Rep. Cost <sup class="text-danger">*</sup></label>
                                            <input id="quantity" required min="1" class="form-control" value="1" type="number" name="cost">
                                        </div>
                                       <div class="form-group col">
                                           <label for="my-input">Date of Acquisition <sup class="text-danger">*</sup></label>
                                           <input id="acdate" required value="{{$landinfo->assetAcquisitionDate}}" max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date of Acquisition" type="date" name="DateofAcquisition">
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="form-group col-md-6">
                                           <label for="my-input">Date in Use <sup class="text-danger">*</sup></label>
                                           <input id="usedate" required value="{{$landinfo->assetDateinUse}}'"  max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date in Use" type="date" name="DateinUse">
                                       </div>
                                   </div>
                                    <input type="text" name="id" id="" value="{{$landinfo->id}}" hidden>
                                    <input type="text" name="AssetUsefulLife" value="25" hidden>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <a href="{{route('assetsWorkinProgressView',[$landinfo->id])}}" class="form-control btn btn-danger" name="newcard">Cancel</a>
                        </div>
                        <div class="form-group col-md-2">
                            <button id="newcard" class="form-control btn btn-primary" name="newcard">Submit</button>
                        </div>
                    </div>
                </form>

            @endforeach
    @else
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">No Assets Found!</h4>
    </div>
    @endif
</div>
@endSection
