@extends('layouts.land')

@section('title')
Renew Tender Contract
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
                <h5 style=" text-transform: capitalize;"   id="Add New House" >Extend Company Contract</h5>
                      <hr>
                <!-- <p align="center" style="color: red">All fields are compulsory</p>-->
          
                <form method="POST" action="{{ route('companyrenewcontract',[$comp->id]) }}" class="col-lg-12">
                    @csrf

                <div align="center">
     
                    
                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate"><b>Company Name <sup style="color: red;"></sup></b></label>

                        </div>
                        <input style="color: black;"  class="form-control" 
                                placeholder="{{$comp['compantwo']->company_name}}"  readonly>
                    </div>


                     <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate"><b>Tender Number<sup style="color: red;"></sup></b></label>

                        </div>
                        <input style="color: black;" class="form-control" 
                                 placeholder="{{$comp->tender}}"  readonly>
                    </div>

                      <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate"><b>Cleaning Area<sup style="color: red;"></sup></b></label>

                        </div>
                        <input style="color: black;" class="form-control" 
                                 placeholder="{{$comp['are_a']->cleaning_name}}" readonly >
                    </div>


                      <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">

                          <label style="width:150px;" class="input-group-text" for="directorate">Extend Up To<sup style="color: red;">*</sup></label>

                        </div>

                        <input style="color: black" type="date" required class="form-control" 
                               name="datecontract" required min="<?php echo date('Y-m-d', strtotime("+3 month")); ?>" max="<?php echo date('Y-m-d', strtotime("+9 month")); ?>"  value="{{ old('datecontract') }}" >

                      </div>


            <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a class="btn btn-danger" href="/cleaningcompany" role="button">Cancel </a>
                </div>
                </form>
            </div>










@endSection


