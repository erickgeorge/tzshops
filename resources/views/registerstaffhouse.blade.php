@extends('layouts.master')

@section('title')
StaffHouse Registrartion
@endSection

@section('body')
<br>
<div class="container">
@if ($errors->any())
<div class="alert alert-danger" style="margin-top: 6%;">
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


<div class="container">
                <h4 style='margin-top: 7%;'  id="Add New House">Register  New House</h4>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('house.save') }}" class="col-lg-12">
                    @csrf

                <div align="center">
                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                            <label style="width:150px;" class="input-group-text" for="directorate">Campus Name </label>
                        </div>
                        <select required class="custom-select" name="campus" id="campus">
                            <option value="">Choose...</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->campus_name }}</option>
                            @endforeach

                        </select>
                    </div> 

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
<<<<<<< Updated upstream
                          <label style="width:150px;" class="input-group-text" for="directorate">House Grade </label>
=======
                          <label style="width:150px;" class="input-group-text" for="directorate">House Name </label>
>>>>>>> Stashed changes
                        </div>
                        

                        <select required class="custom-select" name="name_of_house" id="campus">
                            <option value="">Choose Grade...</option>
                            
<<<<<<< Updated upstream
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="A3">A3</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="B3">B3</option>
                                <option value="C1">C1</option>
                                <option value="C2">C2</option>
                                <option value="C3">C3</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                         

                        </select>
=======
                          <label style="width:150px;" class="input-group-text" for="directorate">House Name </label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="Housename"
                               name="name_of_house" placeholder="Enter House Name">
>>>>>>> Stashed changes
                    </div>

                 


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">House Location </label>
                        </div>
                       

                        <select required class="custom-select" name="location" id="campus">
                            <option value="">Choose Location...</option>
                                 
                                <option value="BIAFRA FLATS">BIAFRA FLATS</option>
                                <option value="DARAJANI HOUSES">DARAJANI HOUSES</option>
                                <option value="KILIMAHEWA HOUSES">KILIMAHEWA HOUSES</option>
                                <option value="KILIMAHEWA FLATS">KILIMAHEWA FLATS</option>
                                <option value="KILELENI HOUSES">KILELENI HOUSES</option>
                                <option value="KIJITONYAMA FLATS">KIJITONYAMA FLATS</option>
                                <option value="KINONDONI NGANO HOUSES">KINONDONI NGANO HOUSES</option>
                                <option value="KOROSHINI HOUSES">KOROSHINI HOUSES</option>
                                <option value="KUNDUCHI HOUSES">KUNDUCHI HOUSES</option>
                                <option value="KUNDUCHI QUARTERS">KUNDUCHI QUARTERS</option>
                                <option value="LAMBONI HOUSES">LAMBONI HOUSES</option>        
                                <option value="UBUNGO HOUSES">UBUNGO HOUSES</option>
                                <option value="MBEZI HOUSES">MBEZI HOUSES</option>
                                <option value="MABIBO HOSTEL">MABIBO HOSTEL</option>
                                <option value="MIKOCHENI HOUSES">MIKOCHENI HOUSES</option>
                                <option value="MIKOCHENI QUARTERS">MIKOCHENI QUARTERS</option>
                                <option value="MPAKANI QUARTERS">MPAKANI QUARTERS</option>
                                <option value="MWEMBENI HOUSES">MWEMBENI HOUSES</option>
                                <option value="MBUGANI HOUSES">MBUGANI HOUSES</option>
                                <option value="NEC HOUSES">NEC HOUSES</option>
                                <option value="NG'AMBO HOUSES">NG'AMBO HOUSES</option>
                                <option value="NG'AMBO FLATS ">NG'AMBO FLATS</option>
                                <option value="SIMBA FLATS">SIMBA FLATS</option>
                                <option value="SIMBA HOUSES">SIMBA HOUSES</option>
                                <option value="SINZA HOUSES">SINZA HOUSES</option>
                                <option value="SINZA FLATS">SINZA FLATS</option>
                                <option value="UBUNGO FLATS">UBUNGO FLATS</option>
                                <option value="UNIVERSITY ROAD">UNIVERSITY ROAD</option>
                                
                                

                        </select>
                    </div>


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
<<<<<<< Updated upstream
                          <label style="width:150px;" class="input-group-text" for="directorate">No of Bedrooms </label>
=======
                          <label style="width:150px;" class="input-group-text" for="directorate">Type of House </label>
>>>>>>> Stashed changes
                        </div>
                        <input style="color: black" type="number" required class="form-control" id="type"
                               name="type" placeholder="Enter Number of Bedrooms">
                    </div>


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
<<<<<<< Updated upstream
                          <label style="width:150px;" class="input-group-text" for="directorate">Quantity</label>
                        </div>
                        <input style="color: black" type="text" required class="form-control" id="no_room"
                               name="no_room" placeholder="Enter House Quantity"    onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) ">
=======
                          <label style="width:150px;" class="input-group-text" for="directorate">No of Rooms</label>
                        </div>
                        <input style="color: black" type="number" required class="form-control" id="no_room"
                               name="no_room" placeholder="Enter No of Rooms"    onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) ">
>>>>>>> Stashed changes
                    </div>


                       
                    <button type="submit" class="btn btn-primary">Register
                        New House
                    </button>
                    <a class="btn btn-danger" href="/manage_Houses" role="button">Cancel </a>
                </div>
                </form>
            </div>
            


@endSection