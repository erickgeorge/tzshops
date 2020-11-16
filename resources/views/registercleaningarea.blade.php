@extends('layouts.land')

@section('title')
StaffHouse Registrartion
@endSection

@section('body')
<br>

@if ($errors->any())
<div class="alert alert-danger" >
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
@if(Session::has('message'))
<div class="alert alert-success" style="margin-top: 6%;">
	<ul>
		<li>{{ Session::get('message') }}</li>
	</ul>
</div>
@endif


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $("#Hall").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue=='1'){
              $('.MyHall').show(); 
                $('.NotHall').hide(); 
               //$('#hostels').attr('required', ''); 
            } 

            else if(optionValue=='2'){
              $('.NotHall').show();
                $('.MyHall').hide();  
            } 

        });
    }).change();
});
</script>


<script>
$(document).ready(function(){
    $("#Hostel").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue=='Mabibo'){
              $('.block').show(); 
               
               //$('#hostels').attr('required', ''); 
            } 
        
            else if(optionValue=='Magufuli'){
              $('.block').show(); 
               
               //$('#hostels').attr('required', ''); 
            } 

            else {
              $('.block').hide();
              
            } 

        });
    }).change();
});
</script>

 
<div class="container">


                <h5  id="Add New House">Register New Cleaning Area</h5>

                      <hr>
                <!-- <p align="center" style="color: red">All fields are compulsory</p>-->

                <form method="POST" action="{{ route('area.save') }}" class="col-lg-12">
                    @csrf

<div align="center">




                     <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;" class="input-group-text" for="directorate">Hostels/Halls <sup style="color: red;">*</sup> </label>
                        </div>
                         <select id="Hall" required style="color: black;" class="custom-select" name="hostel" >
                                <option  selected value="2">No</option>
                                <option  value="1">Yes</option>
                             
                        </select>
                       </div> 


         <div style="display: none;" class="MyHall">

                     <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">

                          <label style="width:200px;" class="input-group-text" for="directorate">Hostel/Hall Name <sup style="color: red;">*</sup> </label>
                        </div>

                           <select name="hallblock" style="color: black; " class="custom-select" id="Hostel" >
                                  <option selected value="" >Choose...</option>
                                  <option value="CoICT">CoICT</option>
                                  <option value="Hall 1">Hall 1</option>
                                  <option value="Hall 2">Hall 2</option>
                                  <option value="Hall 3">Hall 3</option>
                                  <option value="Hall 4">Hall 4</option>
                                  <option value="Hall 5">Hall 5</option>
                                  <option value="Hall 6">Hall 6</option>
                                  <option value="Hall 7">Hall 7</option>
                                  <option value="Kunduchi">Kunduchi</option>
                                  <option value="Ubungo">Ubungo</option>
                                  <option value="Mabibo">Mabibo</option>
                                  <option value="Magufuli">Magufuli</option>
                                  <option value="Ubungo">Ubungo</option>  
                            </select>

                     </div>

             
                    <div class="input-group mb-3 col-lg-6 block">
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;" class="input-group-text" for="directorate">Block <sup style="color: red;">*</sup></label>
                        </div>
                                <select  style="color: black; " class="custom-select" name="block" id="myblock" >
                                    <option selected value="" >Choose...</option>
                                    <option value="Block A">Block A</option>
                                    <option value="Block B">Block B</option>
                                    <option value="Block C">Block C</option>
                                    <option value="Block D">Block D</option>
                                    <option value="Block E">Block E</option>
                                    <option value="Block F">Block F</option>
                               
                                </select>
                    </div>


            
                    <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;" class="input-group-text" for="directorate">LOT Name <sup style="color: red;">*</sup></label>
                        </div>
                        <input style="color: black" type="text" class="form-control" id="Housename"
                               name="zones" placeholder="Enter LOT Name">
                    </div> 



                 




     </div>

     <div  class="NotHall">


               
                     <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">

                          <label style="width:200px;" class="input-group-text" for="directorate">Cleaning Area Name <sup style="color: red;">*</sup> </label>
                        </div>
                        <input style="color: black" type="text" class="form-control" id="Housename"
                               name="cleaning_name" placeholder="Enter Cleaning Area Name">
                     </div>



            
                    <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;" class="input-group-text" for="directorate">LOT Name <sup style="color: red;">*</sup></label>
                        </div>
                        <input style="color: black" type="text" class="form-control" id="Housename"
                               name="zone" placeholder="Enter LOT Name">
                    </div> 



                <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;" class="input-group-text" for="directorate">Type <sup style="color: red;">*</sup></label>
                        </div>
                         <select style="color: black;" class="custom-select" name="areatype" >
                                <option selected value=""> Choose .. </option>
                                <option  value="Exterior">Exterior</option>
                                <option  value="Interior">Interior</option>
                             
                         </select>
                    </div>



                     <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:200px;height: 28px;" class="input-group-text" > Directorate/College <sup style="color: red;">*</sup></label>
                        </div>
                         <select  style="color: black;" class="custom-select" name="college" id="directorate" >
                                  <option selected value="" >Choose ...</option>
                                   @foreach($directorates as $directorate)
                                  <option value="{{ $directorate->id }}">{{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
                                   @endforeach
                         </select>
                     </div> 

         
     </div>




                    <button type="submit" class="btn btn-primary">Save
                    </button>
                      <a class="btn btn-danger" href="/manage_Cleaning_area" role="button">Cancel </a>
                  </div>
                </form>

            </div>



@endSection
