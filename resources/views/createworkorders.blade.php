@extends('layouts.master')

@section('title')
    Create Work Orders
    @endSection

@section('body')
    <br>
    <div class="row" style=" margin-left:2%; margin-right:2%;">
        <div class="col-md-8">
            <h5 style="padding-left: 90px;  text-transform: uppercase;" >Create new works order</h5>
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
    <p class="container" style="color: red">All fields are compulsory except for emergence works order</p>
    </br>
    <form method="POST" action="{{ route('workorder.create') }}"  style="margin-left:2%; margin-right:2%;">
        @csrf
        <div class="row">
            <div class="col">  
                <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label style="height: 28px" class="input-group-text" for="inputGroupSelect01">Type of problem</label>
            </div>
            <select required style="width: 300px;min-width: 150px;" id="nameid" name="p_type">
                <option selected value="">Choose... <sup style="color: red;">*</sup></option>
                <?php use App\workordersection; ?>
      <?php $sectionss = workordersection::get(); ?>
      @foreach($sectionss as $sectionss) 
               <option value="{{ $sectionss->section_name }}"><?php echo ucwords(strtolower( $sectionss->section_name )); ?></option>
               @endforeach
                   
            </select>
             </div>
            </div>
            </div>
        <div >
                
        <?php
        use App\Location;
        $location = Location::where('name','<>',null)->orderby('name')->get();
        ?>

        <div id="divmanual">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label  class="input-group-text" for="inputGroupSelect01">Enter Location in text</label>
                </div>
                <input   style="color: black; width: 265px;" type="text" maxlength="35" id="manual"
                       aria-describedby="emailHelp" name="manual" placeholder="Type Location Address">
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
     <br>
      <div style="color: red;">
      <input type="checkbox" name="emergency" > This work order is emergency <i style="color: red;" class="fa fa-exclamation-triangle"></i>
      </div>
      <br>

        <div class="form-group">
            <label for="comment">Details:
            </label>
            <textarea name="details" value="{{ old('details') }}" required maxlength="100" class="form-control" rows="5"
                      id="comment"></textarea>
        </div>
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