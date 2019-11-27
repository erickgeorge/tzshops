@extends('layouts.master')

@section('title')
    Add Technician
    @endSection
@section('body')
    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center">Add new technician</h3>
        </div>
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
</div>
<div class="container">
    <div class="col-lg-12">
        <form method="POST" action="{{ route('tech.create') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group ">
                <label for="fname">First name <sup style="color: red;">*</sup></label>
                <input type="text" required maxlength="20" class="form-control" id="fname" aria-describedby="emailHelp" name="fname" placeholder="Enter first name" onkeypress="return  event.charCode > 57 " value="{{ old('fname') }}">
            </div>
                </div>
                <div class="col">
                    <div class="form-group ">
                <label for="lname">Last name <sup style="color: red;">*</sup></label>
                <input type="text"  required maxlength="20" class="form-control" id="lname" aria-describedby="emailHelp" name="lname" placeholder="Enter last name" onkeypress="return  event.charCode > 57 " value="{{ old('lname') }}">
            </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group ">
                <label for="phone">Phone number <sup style="color: red;">*</sup></label>
                <input  required type="text"     name="phone"  value="{{ old('phone') }}"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "10"  minlength = "2"
                        class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 " >
            </div>
                </div>
                <div class="col">
                    <div class="form-group ">
                <label for="email">Email Address <sup style="color: red;">*</sup></label>
                <input style="color: black; height: 28px;" required   type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ old('email') }}">
            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label style="height: 28px" class="input-group-text" for="inputGroupSelect01">Type of technician</label>
            </div>
            <?php 
        use App\UserRole;
            $role=UserRole::where('user_id',auth()->user()->id)->first();
            $roleofuser=$role->role_id;

            /////////////////////////////
             use App\User;
        $usersec = User::Where('id',auth()->user()->id)->first();
        $secuser = $usersec->type;

            /////////////////////////////
            ?>
            
             <input hidden  type="number"  class="form-control" id="role" name="role"  value="{{ $roleofuser }}">
     
             @if($roleofuser == 1 )
             
            <select  style="width: 380px" class="custom-select" id="typetechadmin" name="typetechadmin">
                
                @if(($secuser == 'HOS Carpentry/Painting')||($secuser == 'HOS CARPENTRY/PAINTING'))<option value="Carpentry/Painting">Carpentry/Painting Technician</option>
               @elseif(($secuser == 'HOS Electrical')||($secuser == 'HOS ELECTRICAL'))<option value="Electrical">Electrical Technician</option>
                @elseif(($secuser == 'HOS Masonry/Road')||($secuser == 'HOS MASONRY/ROAD'))<option value="Masonry/Road">Masonry/Road Technician</option>
                @elseif(($secuser == 'HOS Mechanical')||($secuser == 'HOS MECHANICAL'))<option value="Mechanical">Mechanical Technician</option>
                @elseif(($secuser == 'HOS Plumbing')||($secuser == 'HOS PLUMBING'))<option value="Plumbing">Plumbing Technician</option>
                @endif
                
            </select>
            
            @else
                 <input readonly  type="text"  class="form-control" id="typetechhos" name="typetechhos"  value="{{ substr(strstr(auth()->user()->type, " "), 1) }}">
         @endif
        </div>
                </div>
            </div>
            
            
         <div align="center">

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-danger" href="/technicians" role="button">Cancel </a>
        </div>
        </form>
    </div>
    <br>
    @endSection