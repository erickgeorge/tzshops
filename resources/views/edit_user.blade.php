@extends('layouts.master')

@section('title')
    Edit User
    @endSection

@section('body')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src=
"https://code.jquery.com/jquery-1.12.4.min.js">
  </script>


<?php use App\iowzonelocation; ?>
<style type="text/css">
  #Div2 {
  display: none;
}




 </style>
<div class="container">
    <br>
    <div class="row">
        <div class="col-lg-12" >
            <h4 style="text-transform: capitalize;" >Edit User Information</h4>
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
    <div class="col-lg-12">
        <form method="POST" action="{{ route('user.edit', [$user->id]) }}">
            @csrf
<div class="row">
    <div class="col">
        <div class="form-group ">
                <label for="fname">First name <sup style="color: red;">*</sup></label>
                <input style="color: black" type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp"
                       name="fname" placeholder="Enter first name"
                       onkeypress="return  event.charCode > 57 " value="{{ $user->fname }}">
            </div>
    </div>
    <div class="col">
        <div class="form-group ">
                <label for="lname">Last name <sup style="color: red;">*</sup></label>
                <input style="color: black" type="text" required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp"
                       name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 "
                       value="{{ $user->lname }}">
            </div>
    </div>
    <div class="col">
        <div class="form-group ">
                <label for="phone">Phone number <sup style="color: red;">*</sup></label>
                <input  style="color: black" required type="text" name="phone" value="{{ $user->phone }}"
                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                       maxlength="10" minlength="10"
                       class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number"
                       onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 ">
            </div>
    </div>
</div>
 <div class="row">
    <div class="col">
         <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="height: 28px;" class="input-group-text" for="email">Email</label>
                </div>
                <input style="height: 28px;" style="color: black" required type="email" maxlength="25" class="form-control" id="email" aria-describedby="emailHelp"
                       name="email" onblur="validateEmail(this);" placeholder="Enter email address" value="{{ $user->email }}">
            </div>
    </div>

    <div class="col">
        <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="height: 28px;" class="input-group-text" for="directorate">Directorate/College <sup style="color: red;"></label>
                </div>
                <select style="width: 350px;" class="custom-select" name="college" id="directorate" onchange="getdepedit()">
                    @foreach($directorates as $directorate)
                        <option <?php if(($user['department']['directorate']->name) == $directorate->name) {?>
                                selected="selected"
                                <?php } ?>
                                value="{{ $directorate->id }}" > {{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
                    @endforeach

                </select>
        </div>
    </div>
</div>


  <div class="row">
    <div class="col">
        <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label  style="height: 28px;" class="input-group-text" for="department">Department</label>
                </div>

                <select class="custom-select" name="department" id="department" >
                      @foreach($departments as $dep)
                        <option <?php if(($user['department']->name) == $dep->name) {?>
                                selected="selected"
                                <?php } ?>
                                value="{{ $dep->id }}" > {{ '('.$dep->name . ') ' . $dep->description }}</option>
                    @endforeach

                </select>

            </div>
    </div>


</div>

    <div >
        <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label  class="input-group-text" for="inputGroupSelect01">Role</label>
                </div>
                <select class="custom-select" name="role" id="inputGroupSelect02">

                    <option

                            @if(($trole['user_role']['role_id']) =="1")
                            selected="selected"
                            @else

                            @endif
                            value="1">Admin
                    </option>
                    <option
                            @if(($trole['user_role']['role_id']) =="2")
                            selected="selected"
                            @else

                            @endif
                            value="2">Staff
                    </option>
                </select>
            </div>
    </div>


    <?php $string = $user->type;
     $str_array = preg_split("/\,/", $string);
     ?>






      <label>Type of User</label><br>

    <div class="row">
    <div class="col">
            <div >
                 <div class="checkbox">
            <label><input id="checkdiv" name="checkdiv" type="checkbox" value="yesmanual" onclick="ShowHideDiv(this)">
                Inspector of Works</label>
               </div>
            </div>


              <div id="locationdiv" > 


                      <select class="custom-select" name="type" id="type" required>
                      <option @if (in_array('Accountant',$str_array)) { selected="selected" } @else{} @endif value="" selected>Choose user type...</option>
                     <option @if (in_array('Administrative officer',$str_array)) { selected="selected" } @else{} @endif   value="Administrative officer">Administrative officer</option>
                      <option @if (in_array('Accountant',$str_array)) { selected="selected" } @else{} @endif   value="Accountant">Accountant</option>

                      <option @if (in_array('Bursar',$str_array)) { selected="selected" } @else{} @endif  value="Bursar">Bursar</option>

                      <option @if (in_array('CLIENT',$str_array)) { selected="selected" } @else{} @endif  value="CLIENT">Client</option>


                      <option @if (in_array('Directorate Director',$str_array)) { selected="selected" } @else{} @endif  value="Directorate Director">Directorate Director</option>
                      
                      <option @if (in_array('Director DPI',$str_array)) { selected="selected" } @else{} @endif  value="Director DPI">Director DPI</option>

                       <option @if (in_array('Dean of Student',$str_array)) { selected="selected" } @else{} @endif  value="Dean of Student">Dean of Student</option>

                          <option @if (in_array('DVC Accountant',$str_array)) { selected="selected" } @else{} @endif  value="DVC Accountant">DVC Accountant</option>

                        <option @if (in_array('DVC Admin',$str_array)) { selected="selected" } @else{} @endif  value="DVC Admin">DVC Admin</option>


                      <option @if (in_array('Estates Director',$str_array)) { selected="selected" } @else{} @endif   value="Estates Director">Estates Director</option>

                       <option @if (in_array('Estates officer',$str_array)) { selected="selected" } @else{} @endif   value="Estates officer">Estates officer</option>

                      <option @if (in_array('Head Procurement',$str_array)) { selected="selected" } @else{} @endif  value="Head Procurement">Head of Procurement</option>

                       <option @if (in_array('Head PPU',$str_array)) { selected="selected" } @else{} @endif  value="Head PPU">Head PPU</option>

                       @foreach($worksec as $dep)

                           <option  value="HOS {{$dep->section_name}}"  >HoS <?php echo ucwords(strtolower( $dep->section_name )); ?></option>

                       @endforeach

                        <option @if (in_array('Housing Officer',$str_array)) { selected="selected" } @else{} @endif  value="Housing Officer">Housing Officer</option>

                      <option @if (in_array('Inspector Of Works',$str_array)) { selected="selected" } @else{} @endif  value="Inspector Of Works">Inspector Of Works</option>
                      <option @if (in_array('Maintenance coordinator',$str_array)) { selected="selected" } @else{} @endif value="Maintenance coordinator">Maintenance Coordinator</option>
                       <option @if (in_array('Principal',$str_array)) { selected="selected" } @else{} @endif value="Principal">Principal</option>

                       <option @if (in_array('Quality Surveyor',$str_array)) { selected="selected" } @else{} @endif value="Quality Surveyor">Quality Surveyor</option>

                      <option  @if (in_array('STORE',$str_array)) { selected="selected" } @else{} @endif value="STORE">Store Manager</option>
                       <option  @if (in_array('Secretary to Council',$str_array)) { selected="selected" } @else{} @endif value="Secretary to Council">Secretary to Council</option>
                      <option @if (in_array('Supervisor Landscaping',$str_array)) { selected="selected" } @else{} @endif  value="Supervisor Landscaping ">Supervisor Landscaping </option>
                      <option @if (in_array('Transport Officer',$str_array)) { selected="selected" } @else{} @endif  value="Transport Officer">Transport Officer</option>
                      <option @if (in_array('USAB',$str_array)) { selected="selected" } @else{} @endif  value="USAB">USAB</option>



               </select>




             </div>


               <div id="divmanual">
               <select  required style="width: 500px;" class="custom-select" name="zone" id="zone">
                    @foreach($zone as $zone)
                       <option <?php if($user->zone == $zone->zonename) {?>
                                selected="selected"
                                <?php } ?> value="{{$zone->zonename}}"  ><?php echo strtoupper( $zone->zonename ); ?></option>
                      @endforeach





             </select>


                </div>

        </div>


    <?php $string = $usertyp->type2;
     $strarray = preg_split("/\,/", $string);
     ?>


   <div class="col">
  <div class="align-content-center">
    <div class="input-group mb-3">
            <div class="contacts">
                      Second type of user

                <br>


                <select   style="width: 500px;" class="custom-select" name="secondtype" id="secondtype">


                      <option @if (in_array('Accountant',$strarray)) { selected="selected" } @else{} @endif value="" selected>Choose user type...</option>
                      <option @if (in_array('Administrative officer',$strarray)) { selected="selected" } @else{} @endif   value="Administrative officer">Administrative officer</option>

                      <option @if (in_array('Maintenance coordinator',$strarray)) { selected="selected" } @else{} @endif   value="Accountant">Accountant</option>

                      <option @if (in_array('Bursar',$strarray)) { selected="selected" } @else{} @endif  value="Bursar">Bursar</option>


                      <option @if (in_array('CLIENT',$strarray)) { selected="selected" } @else{} @endif  value="CLIENT">Client</option>

                      <option @if (in_array('Dean of Student',$strarray)) { selected="selected" } @else{} @endif  value="Dean of Student">Dean of Student</option>

                      <option @if (in_array('Directorate Director',$strarray)) { selected="selected" } @else{} @endif  value="Directorate Director">Directorate Director</option>

                      <option @if (in_array('Director DPI',$strarray)) { selected="selected" } @else{} @endif  value="Director DPI">Director DPI</option>

                          <option @if (in_array('DVC Accountant',$strarray)) { selected="selected" } @else{} @endif  value="DVC Accountant">DVC Accountant</option>

                        <option @if (in_array('DVC Admin',$strarray)) { selected="selected" } @else{} @endif  value="DVC Admin">DVC Admin</option>


                      <option @if (in_array('Estates Director',$strarray)) { selected="selected" } @else{} @endif   value="Estates Director">Estates Director</option>

                       <option @if (in_array('Estates officer',$strarray)) { selected="selected" } @else{} @endif   value="Estates officer">Estates officer</option>

                      <option @if (in_array('Head Procurement',$strarray)) { selected="selected" } @else{} @endif  value="Head Procurement">Head of Procurement</option>

                       <option @if (in_array('Head PPU',$strarray)) { selected="selected" } @else{} @endif  value="Head PPU">Head PPU</option>

                       @foreach($worksec as $dep)

                           <option  value="HOS {{$dep->section_name}}"  >HoS <?php echo ucwords(strtolower( $dep->section_name )); ?></option>

                       @endforeach

                        <option @if (in_array('Housing Officer',$strarray)) { selected="selected" } @else{} @endif  value="Housing Officer">Housing Officer</option>

                      <option @if (in_array('Maintenance coordinator',$strarray)) { selected="selected" } @else{} @endif value="Maintenance coordinator">Maintenance Coordinator</option>

                        <option @if (in_array('Principal',$strarray)) { selected="selected" } @else{} @endif value="Principal">Principal</option>

                       <option @if (in_array('Quality Surveyor',$strarray)) { selected="selected" } @else{} @endif value="Quality Surveyor">Quality Surveyor</option>

                      <option  @if (in_array('STORE',$strarray)) { selected="selected" } @else{} @endif value="STORE">Store Manager</option>
                       <option  @if (in_array('Secretary to Council',$strarray)) { selected="selected" } @else{} @endif value="Secretary to Council">Secretary to Council</option>
                      <option @if (in_array('Supervisor Landscaping',$strarray)) { selected="selected" } @else{} @endif  value="Supervisor Landscaping ">Supervisor Landscaping </option>
                      <option @if (in_array('Transport Officer',$strarray)) { selected="selected" } @else{} @endif  value="Transport Officer">Transport Officer</option>
                      <option @if (in_array('USAB',$strarray)) { selected="selected" } @else{} @endif  value="USAB">USAB</option>



               </select>
             </div>
   </div>
  </div>
  </div>



</div>






 <!--
            <div class="form-group ">
                <label for="uname">Username</label>
                <input style="color: black" required maxlength="20" type="text" class="form-control"
                       id="uname" name="uname" aria-describedby="emailHelp"
                       placeholder="Enter username" value="{{ $user->name }}" disabled data-toggle="tooltip"
                       title="Cannot edit username">
            </div>

			-->

      <div align="center">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-danger" href="/viewusers" role="button">Cancel</a>
            </div>

        </form>
        <div class="card" style="width:18rem;">
            <div class="card-body">
                <form  method="POST" onsubmit="return confirm('Are you sure you want to Restore password to default for: {{ $user->fname . ' ' . $user->lname }}?')" action="{{ route('restorepassword', [$user->id]) }}" >
                    {{csrf_field()}}
          
          
                  <button class="btn btn-primary" type="submit" data-toggle="tooltip" title="Restore Password to default : username@esmis"   > Restore Password</button>
               </form>
          
          </div>
        </div>

    </div>
    <br>















    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });



    </script>




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




<script type="text/javascript">


var selectdep = null;

function getdepedit() {
    selectdep = document.getElementById('directorate').value;

    $.ajax({
        method: 'GET',
        route: 'get_depa,[$user->id]',
        data: {id: selectdep}
    })
        .done(function(msg){
            var object = JSON.parse(JSON.stringify(msg['direct_torate']));
            $('#department').empty();


      var option = document.createElement('option');
      option.innerHTML = 'Choose...';
      option.value = '';
      document.getElementById('department').appendChild(option);


            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].description;
                option.value = object[i].id;
                document.getElementById('department').appendChild(option);
            }
        });
}
</script>

    @endSection
