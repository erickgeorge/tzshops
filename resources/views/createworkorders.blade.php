@extends('layouts.master')

@section('title')
    Create Work Orders
    @endSection

@section('body')
    <br>
            <div class="container">
            <h4 style="text-transform: capitalize;" >Create new works order</h4>
        </div>

    <hr class="container">
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
    </br>
    <form method="POST" action="{{ route('workorder.create') }}"  style="margin-left:2%; margin-right:2%;">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group ">
                        <label  for="inputGroupSelect01">Type of problem <sup style="color: red;">*</sup></label>
                        <br>
                        <select  style="width: 500px;" class="form-control" required  id="nameid" name="p_type">
                            <option selected value="">Choose... <sup style="color: red;">*</sup></option>
                            <?php use App\workordersection; ?>
                  <?php $sectionss = workordersection::get(); ?>
                  @foreach($sectionss as $sectionss)
                           <option value="{{ $sectionss->section_name }}"><?php echo ucwords(strtolower( $sectionss->section_name )); ?></option>
                           @endforeach

                           <option value="Others">Others</option>
                        </select>
                    </div>
            </div>

            </div>

        <?php
        use App\Location;
        $location = Location::where('status', 1)->where('name','<>',null)->orderby('name')->get();
        ?>

<div class="row">
    <div class="col">
         <div class="checkbox">
    <label><input id="checkdiv" name="checkdiv" type="checkbox" value="yesmanual" onclick="ShowHideDiv(this)">
        Enter location manually</label>
       </div>
    </div>
</div>

        <div id="divmanual">
            <div class="col">
                <div class="form-group ">
                    <input style="width: 490px;"  style="color: black;" type="text" class="form-control" maxlength="60" id="manual"
                    aria-describedby="emailHelp" name="manual" placeholder="Type Location Address Here">
                    </div>
            </div>
        </div>



        <div id="locationdiv">
            <div class="row">
                <div class="col">
                    <div class="form-group ">
                            <label  for="inputGroupSelect01">Location <sup style="color: red;">*</sup></label>
                            <br>
                            <select style="width: 500px;" required class="custom-select" id="location" name="location" onchange="getAreas()">
                                <option value="" selected>Choose...
                                </option>

                                @foreach($location as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach

                            </select>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group ">
                            <label  for="inputGroupSelect01">Area <sup style="color: red;">*</sup></label>
                            <br>
                            <select style="width: 500px;" required class="custom-select" id="area" name="area" onchange="getBlocks()">
                                <!-- <option selected>Choose...</option> -->
                            </select>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group ">
                            <label  for="inputGroupSelect01">Block <sup style="color: red;">*</sup></label>
                            <br>
                            <select  style="width: 500px;" required class="custom-select" id="block" name="block" onchange="getRooms()">
                                <!-- <option selected>Choose...</option> -->
                            </select>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group ">
                            <label  for="inputGroupSelect01">Room <sup style="color: red;">*</sup></label>
                            <br>
                            <select style="width: 500px;" required class="custom-select" id="room" name="room">
                                <!-- <option selected>Choose...</option> -->
                            </select>
                        </div>
                </div>
            </div>
    </div>
     <br>
      <div style="color: red;">
      <input type="checkbox" name="emergency" >This Works Order Is Emergency <i style="color: red;" class="fa fa-exclamation-triangle"></i>
      </div>
      <br>

        <div class="form-group">
            <label for="comment">Description of the Problem <sup style="color: red;">*</sup>
            </label>
            <br>
            <textarea style="width: 500px;" name="details" value="{{ old('details') }}" required maxlength="100" class="form-control" rows="5"
                      id="comment"></textarea>
        </div>
        <div >
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
