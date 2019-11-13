
<!DOCTYPE html>
<html>
<head>
    <title>Change password</title>
</head>
<body>
     <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/fontawesome/css/all.css') }}">


<div class="container">

    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Its your first time to log in into the system please change your password</b></h3>
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

 
        <div style="text-align: center" >
        <p style="color: red">All fields are compulsory</p>

        <form action="{{ route('password.change') }}" method="POST">
            @csrf

           <div style="padding-left: 300px;" >
           <div class="input-group mb-3">
           <div class="input-group-prepend">
               <span class="input-group-text " id="basic-addon1" style="width: 180px">Old Password <sup style="color: red;">*</sup></span>
           </div>
               <input type="password" required class="form-control col-md-4" id="old-pass" name="old-pass"
                       placeholder="Enter old password" value="{{ old('old-pass') }}">
           </div>


           <div class="input-group mb-3">
           <div class="input-group-prepend">
               <span class="input-group-text" id="basic-addon1" style="width: 180px;">New password <sup style="color: red;">*</sup></span>
           </div>
              <input type="password" required class="form-control col-md-4" id="new-pass" name="new-pass"
                        value="{{ old('new-pass') }}"  maxlength="15"  minlength="8" placeholder="Must 8 characters minimum">
           </div>


           <div class="input-group mb-3">
           <div class="input-group-prepend">
               <span class="input-group-text" id="basic-addon1" style="width: 180px">Confirm password <sup style="color: red;">*</sup></span>
           </div>
             <input  type="password" required class="form-control col-md-4" id="confirm-pass" name="confirm-pass"
                      value="{{ old('confirm-pass') }}" maxlength="15"  minlength="8" placeholder=" Must 8 characters minimum" >
           </div>


            <button type="submit" class="btn btn-primary">Change password</button>
            
            <!--<a href="{{ url('/') }}" style="background-color:#F9B100;border-color:#F9B100;" class="btn btn-danger">Cancel</a>-->

        </form>
        </div>

 
    
</body>
</html>
   