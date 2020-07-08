@extends('layouts.asset')

@section('title')
New Plant And Machinery Asset
    @endSection

@section('body')
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Add New Plant And Machinery Asset</b></h5>
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

        <form action="{{route('assetsNewPlantMachinerySave')}}" method="post" enctype="multipart/form-data">
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
                                   <label for="my-input">.</label>
                                   <input id="location" required class="form-control" placeholder="Site Location" type="text" name="SiteLocation2">
                               </div>
                            </div>
                            <div class="row">
                               <div class="form-group col">
                                   <label for="my-input">Asset Number</label>
                                   <input id="assetnumber" required class="form-control" placeholder="Asset Number" type="text" name="AssetNumber">
                               </div>
                            <div class="form-group col">
                                <label for="my-input">Asset Condition</label>
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
                                <label for="my-input">Cost/Rep. Cost</label>
                                <input id="quantity" required min="1" class="form-control" value="1" type="number" name="cost">
                            </div>
                            <div class="form-group col">
                                <label for="my-input">Quantity</label>
                                <input id="quantity" required min="1" class="form-control" value="1" type="number" name="Quantity">
                            </div>
                        </div>
                        <div class="row">
                                <div class="form-group col">
                                    <label for="my-input">Date of Acquisition</label>
                                    <input id="acdate" max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date of Acquisition" type="date" name="DateofAcquisition">
                                </div>
                                <div class="form-group col">
                                    <label for="my-input">Date in Use</label>
                                    <input id="usedate"  max="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date in Use" type="date" name="DateinUse">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="my-input">Ending Depreciation Date</label>
                                    <input id="endingdate"   min="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Ending Depreciation Date" type="date" name="EndingDepreciationDate">
                                </div>
                            </div>
                            <input type="text" name="AssetUsefulLife" value="5" hidden>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="form-group col-md-3">
                    <a href="{{route('assetsPlantMachinery')}}" id="newcard" class="form-control btn btn-danger text-light" name="newcard">Cancel</a>
                </div>
                <div class="form-group col-md-2">
                    <button id="newcard" class="form-control btn btn-primary" name="newcard">Submit</button>
                </div>
            </div>
        </form>
        <br>
@endSection
