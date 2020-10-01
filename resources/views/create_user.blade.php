@extends('layouts.master')

@section('title')
User Registration
@endSection

@section('body')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src=
"https://code.jquery.com/jquery-1.12.4.min.js">
	</script>
 <style type="text/css">
 	#Div2 {
  display: none;
}

.selectt {


			display: none;

		}


 </style>
<br>
<div class="container">

		<h4 style="text-transform: capitalize;" >Create new user</h4>


	<!-- <div class="col-md-4">
		<a href="{{ url('viewusers') }}" > <button type="" class="btn btn-primary">View all users</button></a>
	</div> -->
</div>

<hr class="container">
<div class="container" >
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
<div class="col-lg-12">



<form id="world" name="world" method="POST" action="{{ route('user.create') }}"  enctype="multipart/form-data">
                        @csrf
<div class="row">
	<div class="col">
		<div class="form-group ">
	    <label for="fname">First name <sup class="text-danger">*</sup> </label>
	    <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " value="{{ old('fname') }}" >
	 </div>
	</div>
	<div class="col">
		<div class="form-group ">
	    <label for="lname">Middle name </label>
	    <input style="color: black" type="text"  maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="mname" value="" placeholder="Enter middle name" onkeypress="return  event.charCode > 57 " value="{{ old('mname') }}">
	</div>
    </div>
</div>
<div class="row">

	<div class="col">
		<div class="form-group ">
	    <label for="lname">Last name  <sup class="text-danger">*</sup></label>
	    <input style="color: black" type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 " value="{{ old('lname') }}">
    </div>
	</div>
	<div class="col">
		<div class="form-group ">
	    <label for="phone">Phone number  <sup class="text-danger">*</sup></label>
	    <input style="color: black;"  required type="text"     name="phone"
	    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10"
	     class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 "  value="{{ old('phone') }}">
	</div>
    </div>
</div>
<div class="row">
	<div class="col">
        <div class="form-group ">
            <label for="phone">Email  <sup class="text-danger">*</sup></label>
            <input style="color: black;"  required type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onblur="validateEmail(this);"  maxlength="29" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
        </div>
	</div>
    <div class="col">
        <div class="form-group ">
            <label for="phone">Username  <sup class="text-danger">*</sup></label>
            <input style="color: black;"  required required  maxlength="20" type="text" class="form-control" id="uname" aria-describedby="emailHelp" name="name" placeholder="Enter username" value="{{ old('name') }}">
        </div>
	</div>
</div>
<div class="row">

    <div class="col-md-6">
        <div class="form-group ">
            <label for="phone">Role  <sup class="text-danger">*</sup></label>
            <select style="color: black;" required class="custom-select" name="role" id="role">
                <option value="" selected>Choose...</option>
                <option value="1">Admin</option>
                <option value="2">Staff</option>
              </select>        </div>
	</div>

</div>




<div class="row">

    <div class="col-md-6">
        <div class="form-group ">
            <label for="phone">Directorate/College  <sup class="text-danger">*</sup></label>
            <select required style="color: black; " class="custom-select" name="college" id="directorate" onchange="getDepartments()" value="{{ old('directorate') }}">
                <option selected value="" >Choose...</option>
              @foreach($directorates as $directorate)
              <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
              @endforeach
            </select>
        </div>
	</div>

    <div class="col-md-6">
        <div class="form-group ">
            <label for="phone">Department  <sup class="text-danger">*</sup></label>
            <select required style="color: black;"  class="custom-select" name="department" id="department"  value="{{ old('department') }}">
            </select>
        </div>
	</div>


</div>







<div class="row">
    <div class="col">
        Type of User  <sup class="text-danger">*</sup>

    </div>

</div>

	  <div class="row">
	  <div class="col">
            <div >
                 <div class="checkbox">
            <label><input id="checkdiv" name="checkdiv" type="checkbox" value="yesmanual" onclick="ShowHideDiv(this)">
                Inspector of Works</label>
               </div>
            </div>


              <div id="locationdiv" >
               <select  required style="width: 500px;" class="custom-select" name="type" id="type">
	                  <option value="" selected>Choose...</option>
	                  <option value="Accountant">Accountant</option>
	                  <option value="Administrative officer">Administrative officer</option>
	                  <option value="Architect & Draftsman">Architect & Draftsman</option>
                      <option value="Assets Officer">Assets Officer</option>
                      <option value="Bursar">Bursar</option>
                      <option value="CLIENT">Client</option>
                       <option value="Dean of Student">Dean of Student</option>
	                  <option value="DVC Admin">DVC Admin</option>
	                  <option value="Director DPI">Director DPI</option>
	                  <option value="Directorate Director">Directorate Director</option>
	                   <option value="Dvc Accountant">Dvc Accountant</option>
	                  <option value="Estates officer">Estates officer</option>
	                  <option value="Estates Director">Estates Director</option>
	                  <option value="Head Procurement">Head of Procurement</option>


	                  @foreach($worksec as $dep)

                           <option  value="HOS {{$dep->section_name}}"  >Head of section <?php echo ucfirst( $dep->section_name ); ?></option>

                       @endforeach

	                  <option value="Head PPU">Head PPU</option>
                      <option value="Housing Officer">Housing Officer</option>

                      <option value="Maintenance coordinator">Maintenance Coordinator</option>
                      <option value="Principal">Principal</option>
                      <option value="Quality Surveyor">Quality Surveyor</option>
	                  <option value="STORE">Store Manager</option>

	                  <option value="Secretary to Council">Secretary to Council</option>

	                  <option value="Supervisor Landscaping">Supervisor Landscaping</option>

                      <option value="Transport Officer">Transport Officer</option>
                      <option value="USAB">USAB</option>

	           </select>
	           </div>


               <div id="divmanual">
               <select  required style="width: 500px;" class="custom-select" name="zone" id="zone">
	                  @foreach($zone as $zone)
                       <option  value="{{$zone->zonename}}"  ><?php echo strtoupper( $zone->zonename ); ?></option>
                      @endforeach

	           </select>


                </div>

        </div>



	     <div class="col">
	<div class="align-content-center">
		<div class="input-group mb-3">
	          <div class="contacts">
                      Second type of user

              	<br>

                <select   style="width: 500px;" class="custom-select" name="secondtype" id="secondtype">
	                  <option value="" selected>Choose...</option>
	                  <option value="Administrative officer">Administrative officer</option>
	                  <option value="Accountant">Accountant</option>
	                  <option value="Architect & Draftsman">Architect & Draftsman</option>
	                  <option value="CLIENT">Client</option>
                      <option value="Dean of Student">Dean of Student</option>
	                  <option value="DVC Admin">DVC Admin</option>
	                  <option value="Directorate Director">Directorate Director</option>
	                  <option value="Director DPI">Director DPI</option>
	                  <option value="Estates officer">Estates officer</option>
	                  <option value="Estates Director">Estates Director</option>
	                  <option value="Head Procurement">Head of Procurement</option>

	                  @foreach($worksec as $dep)

                           <option  value="HOS {{$dep->section_name}}"  >Head of section <?php echo ucfirst( $dep->section_name ); ?></option>

                       @endforeach

	                  <option value="Head PPU">Head PPU</option>


	                  <option value="Maintenance coordinator">Maintenance Coordinator</option>
	                  <option value="Principal">Principal</option>
	                  <option value="STORE">Store Manager</option>

	                  <option value="Secretary to Council">Secretary to Council</option>
                      <option value="Supervisor Landscaping">Supervisor Landscaping</option>
	                  <option value="Transport Officer">Transport Officer</option>

	           </select>
             </div>
	 </div>
	</div>
	</div>



</div>


    <div align="center">
	<button type="submit" class="btn btn-primary"> Save</button>
	<a class="btn btn-danger" href="/viewusers" role="button">Cancel </a>
</div>
    </form>

</div>




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


  <script type="text/javascript">


 $("#divmanual").hide();
 $(function () {
        $("#checkdiv").click(function () {
            if ($(this).is(":checked")) {
				$("#type").removeAttr('required');
				$("#zone").removeAttr('required');



				$("#manual").attr('required', '');


                $("#divmanual").show();
				$("#locationdiv").hide();
            } else {
				$("#type").attr('required', '');
				$("#zone").attr('required', '');


				$("#manual").removeAttr('required');
                $("#divmanual").hide();
				$("#locationdiv").show();
            }
        });
    });


     function ShowwHideDiv(checkdiv) {
        var dvPassport = document.getElementById("locationdiv");
        locationdiv.style.display = checkdiv.checked ? "block" : "none";
    }


    </script>



<script>
  var allCheckboxes = $("input[type=checkbox]");

  allCheckboxes.click(
    function () {
      var showSendSelected = $("input[type=checkbox]:checked").length > 0;
      var sendSelectedLink = $("#div2");
      if (showSendSelected) {

        sendSelectedLink.show();

      } else {
        sendSelectedLink.hide();
      }



    }
  );
</script>





@endSection
