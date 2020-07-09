@extends('layouts.asset')

@section('title')
Edit Equipment Asset
    @endSection

@section('body')
@php
    use App\assetsidentifiedlocation;
@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Edit Equipment Asset</b></h5>
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
        <form action="{{route('assetsEquipmentEditSave')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                           <div class="form-group">
                               <label for="my-textarea">Asset Description <sup class="text-danger">*</sup></label>
                               <textarea id="description" class="form-control" name="AssetDescription" rows="3" required>{{$item->assetDescription}}</textarea>
                           </div>
                           <div class="row">
                               <div class="form-group col">

                                <label for="my-input">Site Location <sup class="text-danger">*</sup></label>
                                <select id="location" required class="form-control" type="text" name="SiteLocation">
                                 @php
                                     $option = assetsidentifiedlocation::orderBy('abbreviation','ASC')->get();
                                 @endphp
                                 @foreach ($option as $opt)
                                     <option value="{{$opt->name}}">{{$opt->abbreviation}}</option>
                                 @endforeach
                             </select>
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">. <sup class="text-danger">*</sup></label>
                                   <input id="location" value="{{$item->location}}" required class="form-control" placeholder="Site Location" type="text" name="SiteLocation2">
                               </div>
                            </div>
                            <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Asset Number <sup class="text-danger">*</sup></label>
                                   <input id="assetnumber" value="{{$item->assetNumber}}" required class="form-control" placeholder="Asset Number" type="text" name="AssetNumber">
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">Asset Condition <sup class="text-danger">*</sup></label>
                                   <select id="assetnumber" required class="form-control" name="AssetCondition">
                                       <option selected value="{{$item->_condition}}">{{$item->_condition}}</option>
                                       <option  value="New">New</option>
                                       <option value="Good">Good</option>
                                       <option value="Fair">Fair</option>
                                       <option value="Poor">Poor</option>
                                       <option value="Very Poor">Very Poor</option>
                                       <option value="Absolute">Absolette</option>
                                   </select>
                               </div>
                            </div>
                            <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Cost/Rep. Cost <sup class="text-danger">*</sup></label>
                                   <input id="quantity" value="{{$item->Cost}}" required min="1" class="form-control" value="1" type="number" name="cost">
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">Quantity <sup class="text-danger">*</sup></label>
                                   <input id="quantity" value="{{$item->assetQuantity}}" required min="1" class="form-control" value="1" type="number" name="Quantity">
                               </div>
                            </div>
                            <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Date of Acquisition <sup class="text-danger">*</sup></label>
                                   <input id="acdate"  value="{{$item->assetAcquisitionDate}}" max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date of Acquisition" type="date" name="DateofAcquisition">
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">Date in Use <sup class="text-danger">*</sup></label>
                                   <input id="usedate" required value="{{$item->assetDateinUse}}"  max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date in Use" type="date" name="DateinUse">
                               </div>
                            </div>
                            <input type="text" name="id" id="" value="{{$item->id}}" hidden>
                            <input type="text" name="AssetUsefulLife" value="{{$item->usefulLife}}" hidden>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="form-group col-md-2">
                    <a href="{{route('assetsEquipmentView',[$item->id])}}" class="form-control btn btn-danger" name="newcard">Cancel</a>
                </div>
                <div class="form-group col-md-2">
                    <button id="newcard" class="form-control btn btn-primary" name="newcard">Submit</button>
                </div>
            </div>
        </form>
        @endforeach


</div>

@endSection
