@extends('layouts.land')

@section('title')
Company Registrartion
@endSection

@section('body')



<br>
<div class="container">
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


<div class="container">
                <h5 style=" text-transform: uppercase;"   id="Add New House" >Renew company contract</h5>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('company.save.renew' , [$company->id]) }}" class="col-lg-12">
                    @csrf

                <div align="center">
     
                    
                        <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Company name</label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="name"
                               name="name" value="{{ old('name') }}" placeholder="{{$company->company_name}}" disabled >
                    </div>



                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" >Type </label>

                        </div>
                   
                         <input style="color: black" type="text" required class="form-control" id="name"
                               name="name" value="{{ old('name') }}" placeholder="{{$company->type}}" disabled >

  
                    </div>


                 
                    <!--<div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Status </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="status" placeholder="Enter Company Status">
                    </div>-->


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Registration </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="Registration" placeholder="{{$company->registration}}" value="{{ old('Registration') }}" disabled>
                    </div>

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">TIN </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="TIN" placeholder="{{$company->tin}}" value="{{ old('TIN') }}" disabled>
                    </div>



                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Contract payment </label>

                        </div>
                        <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  style="color: black" type="number" required class="form-control" id="type"
                               name="payment" placeholder="{{$company->payment}}" value="{{$company->payment}}" >
                    </div>


                  <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">Start of contract</label>

                        </div>
                        <input style="color: black" type="date" required class="form-control" id="type"
                               name="datecontract" required min="<?php echo date('Y-m-d'); ?>"  value="{{ old('datecontract') }}" >

                 </div>


                  <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">End of contract</label>

                        </div>
                        <input style="color: black" type="date" required class="form-control" id="type"
                               name="duration" required min="<?php echo date('Y-m-d'); ?>" value="{{ old('duration') }}" >

                 </div>


     

                   <br>
                    
  




              
            <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a class="btn btn-danger" href="/cleaningcompany" role="button">Cancel </a>
                </div>
                </form>
            </div>

       







@endSection


