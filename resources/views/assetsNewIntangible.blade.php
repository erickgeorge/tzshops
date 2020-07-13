@extends('layouts.asset')

@section('title')
New Intangible Asset
    @endSection

@section('body')
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Add New Intangible Asset</b></h5>
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

        <form action="{{route('assetsNewIntangibleSave')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                           <div class="form-group">
                               <label for="my-textarea">Asset Description <sup class="text-danger">*</sup></label>
                               <textarea id="description" class="form-control" name="AssetDescription" rows="3" required></textarea>
                           </div>
                           <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Site Location <sup class="text-danger">*</sup></label>
                                   <input id="location" required class="form-control" placeholder="Site Location" type="text" name="SiteLocation">
                               </div>
                               <div class="form-group col">
                                   <label for="my-input">Asset Number <sup class="text-danger">*</sup></label>
                                   <input id="assetnumber" required class="form-control" placeholder="Asset Number" type="text" name="AssetNumber">
                               </div>
                            </div>
                            <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Quantity <sup class="text-danger">*</sup></label>
                                   <input id="quantity" required min="1" class="form-control" type="number" name="Quantity">
                               </div>
                            <div class="form-group col">
                                <label for="my-input">Asset Condition <sup class="text-danger">*</sup></label>
                                <select id="assetnumber" required class="form-control" name="AssetCondition">
                                    <option selected value="New">New</option>
                                    <option value="Good">Good</option>
                                    <option value="Fair">Fair</option>
                                    <option value="Poor">Poor</option>
                                    <option value="Very Poor">Very Poor</option>
                                    <option value="Obsolete">Obsolete</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="my-input">Cost/Rep. Cost <sup class="text-danger">*</sup></label>
                                <input id="quantity" required min="1" class="form-control" type="number" name="cost">
                            </div>
                                <div class="form-group col">
                                    <label for="my-input">Date of Acquisition <sup class="text-danger">*</sup></label>
                                    <input id="acdate" max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date of Acquisition" type="date" name="DateofAcquisition">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="my-input">Date in Use <sup class="text-danger">*</sup></label>
                                    <input id="usedate"  max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date in Use" type="date" name="DateinUse">
                                </div>
                                <input type="text" name="AssetUsefulLife" value="5" hidden>
                            </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="form-group col-md-2">
                    <button id="newcard" class="form-control btn btn-primary" name="newcard">Save</button>
                </div>
                <div class="form-group col-md-2">
                    <a href="{{route('assetsIntangible')}}" id="newcard" class="form-control btn btn-danger text-light" name="newcard">Cancel</a>
                </div>
            </div>
        </form>
        <br>
@endSection
