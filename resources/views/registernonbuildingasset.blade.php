@extends('layouts.master')

@section('title')
    Register Non-Building Asset
    @endSection

@section('body')
    <br>
    <div class="row" style="margin-top: 6%; margin-left:2%; margin-right:2%;">
        <div class="col-md-8">
            <h2>    Register Non-Building Asset</h2>
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
<div class="container">
    <p style="color: red">All fields are compulsory</p>
    </br>
    <form method="POST" action="{{ route('nonbuildingasset.create') }}"  style="margin-left:2%; margin-right:2%;">
        @csrf
        <div class="row">
            <div class="col-lg-5">
    <div class="align-content-center">
        <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label  style="height: 40px;" class="input-group-text" for="username">Asset Name</label>
      </div>
         <input style="color: black; width:200px; height: 40PX;"  required type="text" class="form-control" id="assetname" aria-describedby="assetname" name="assetname" placeholder="Enter asset name" value="{{ old('assetname') }}">
     </div>
    </div>
    </div>
    <div class="col-lg-3">
    <div class="align-content-center">
        <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label  style="height: 40px;" class="input-group-text" for="username">Type</label>
      </div>
         <input style="color: black; height: 40PX;"  required  maxlength="20" type="text" class="form-control" id="assettype" aria-describedby="assettype" name="assettype" placeholder="Asset Type" value="{{ old('assettype') }}">
     </div>
    </div>
    </div>
    <div class="col">
    <div class="align-content-center">
        <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label  style="height: 40px;" class="input-group-text" for="username">Manufacture Date</label>
      </div>
         <input style="color: black; height: 40PX;"  required  max="<?php echo date('Y-m-d'); ?>" type="date" class="form-control" id="assetmdate" aria-describedby="assetmdate" name="assetmdate" placeholder="Manufacture Date" value="{{ old('assettype') }}">
     </div>
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
    <div class="align-content-center">
        <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label  style="height: 40px;" class="input-group-text" for="username">Life Span</label>
      </div>
         <input style="color: black; height: 40PX;"  required type="text" class="form-control" id="assetspan" aria-describedby="assetspan" name="assetspan" placeholder="Asset Life Span" value="{{ old('assettype') }}">
     </div>
    </div>
    </div>
        <div class="col">
                
        <?php
        use App\Location;
        $location = Location::where('name','<>',null)->orderby('name')->get();
        ?>

       

        <div id="divmanual">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label  class="input-group-text" for="inputGroupSelect01">Location of The asset</label>
                </div>
                <input   style="color: black" type="text" maxlength="35" class="form-control" id="manual"
                       aria-describedby="emailHelp" name="manual" placeholder="Enter Location Address">
            </div>
        </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                 <div class="checkbox">
            <label><input id="checkdiv" name="checkdiv" type="checkbox" value="yesmanual" onclick="ShowHideDiv(this)">
                Enter Location manually</label>
        </div>
            </div>
        </div>

        <div id="locationdiv"><div class="row">
            <div class="col">
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="height: 28px" class="input-group-text" for="inputGroupSelect01">Location</label>
                </div>
                <select style="width:405px;" required class="custom-select" id="location" name="location" onchange="getAreas()">
                    <option value="" selected>Choose... 
                    </option>

                    @foreach($location as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach

                </select>
            </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="height: 28px" class="input-group-text" for="area">Area 
                    </label>
                </div>
                <select style="width:430px;" required class="custom-select" id="area" name="area" onchange="getBlocks()">
                    <!-- <option selected>Choose...</option> -->
                </select>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label  style="height: 28px" class="input-group-text" for="block">Block 
                    </label>
                </div>
                <select style="width:420px;" required class="custom-select" id="block" name="block" onchange="getRooms()">
                    <!-- <option selected>Choose...</option> -->
                </select>
            </div>
            </div>
            <div class="col">
                 <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label   style="height: 28px" class="input-group-text" for="room">Room 
                    </label>
                </div>
                <select style="width:420px;" required class="custom-select" id="room" name="room">
                    <!-- <option selected>Choose...</option> -->
                </select>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-lg-3">
    <div class="align-content-center">
        <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label  style="height: 40px;" class="input-group-text" for="username">Quantity</label>
      </div>
         <input style="color: black; height: 40PX;"  required type="number" class="form-control" id="assetspan" aria-describedby="assetspan" min="1" name="assetspan" placeholder="enter quantity" value="{{ old('assettype') }}">
     </div>
    </div>
    </div>
</div>
        <br><br>
        
        <div align="center">
        <button type="submit" class="btn btn-primary">Submit</button>

        <a class="btn btn-danger" href="/work_order" role="button">Cancel</a>
</div>
        </div>
    </form>

    <br>
    <script type="text/javascript">

        $("#divmanual").hide();
        $("input:checkbox").on('click', function () {
            // in the handler, 'this' refers to the box clicked on
            var $box = $(this);
            if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the group/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>
    @endSection