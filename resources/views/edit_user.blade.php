@extends('layouts.master')

@section('title')
    User Registrartion
    @endSection

@section('body')
<div class="container">
    <br>
    <div class="row" style="margin-top: 6%; margin-right: 2%; margin-left: 2%;">
        <div class="col-lg-12" align="center">
            <h2>Edit user</h2>
        </div>
        {{--<div class="col-md-4">
            <a href="{{ url('viewusers') }}">
                <button type="" class="btn btn-primary">View all users</button>
            </a>
        </div>--}}
    </div>
    <br>
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
                <input style="color: black" required type="text" name="phone" value="{{ $user->phone }}"
                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                       maxlength="13" minlength="2"
                       class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone number"
                       onkeypress="return (event.charCode >= 48 && event.charCode <= 57 ) || event.charCode==43 ">
            </div>
    </div>
</div>
<div class="row">
    <div class="col">
         <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="email">Email <sup style="color: red;">*</sup></label>
                </div>
                <input style="color: black" required type="email" maxlength="25" class="form-control" id="email" aria-describedby="emailHelp"
                       name="email" placeholder="Enter email address" value="{{ $user->email }}">
            </div>
    </div>
    <div class="col">
        <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="directorate">Directorate/College <sup style="color: red;">*</sup></label>
                </div>
                <select class="custom-select" name="college" id="directorate" onchange="getDepartments()">
                    @foreach($directorates as $directorate)
                        <option <?php if(($user['section']['department']['directorate']->name) == $directorate->name) {?>
                                selected="selected"
                                <?php } ?>
                                value="{{ $directorate->id }}" > {{ '('.$directorate->name . ') ' . $directorate->directorate_description }}</option>
                    @endforeach 

                </select>
            </div>
    </div>
    <div class="col">
        <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="department">Department</label>
                </div>
                <select class="custom-select" name="department" id="department" onchange="getSections()">
                    <option value="{{ $user['section']['department']->id }}">{{ $user['section']['department']->description }}</option>
                </select>
            </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="section">Section</label>
                </div>
                <select class="custom-select" name="section" id="section">
                    <option value="{{ $user['section']->id }}">{{ $user['section']->section_name }}</option>
                </select>
            </div>
    </div>
    <div class="col">
        <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Role</label>
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
   <DIV>
         <div class="col">
        <div class="input-group mb-3">
           <div >
        <label>Type of User</label>
      </div>

    <?php $string = $user->type;
     $str_array = preg_split("/\,/", $string);
     ?>

    </div>
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Electrical',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Electrical"> HOS Electrical </label>
         

                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Plumbing',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Plumbing"> HOS Plumbing </label>
      
             
          
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Carpentry/Painting',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Carpentry/Painting"> HOS Carpentry/Painting </label>
          
           


      
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Mechanical',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Mechanical"> HOS Mechanical</label>
  


                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Masonry/Road',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Masonry/Road"> HOS Masonry/Road </label>
       



                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('Maintenance Coordinator',$str_array)) { checked = 'checked' } @else{} @endif value="Maintenance Coordinator"> Maintenance Coordinator </label>
     

          
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('DVC Admin',$str_array)) { checked = 'checked' } @else{} @endif value="DVC Admin"> DVC Admin</label>
    
                   


       
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('Secretary',$str_array)) { checked = 'checked' } @else{} @endif value="Secretary"> Secretary </label>


                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('Technician',$str_array)) { checked = 'checked' } @else{} @endif value="Technician"> Technician </label>



                 label> 
                 <input type="checkbox" name="type[]" @if (in_array('STORE',$str_array)) { checked = 'checked' } @else{} @endif value="STORE"> Store Manager </label>
      
      
        


                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('Estates Director',$str_array)) { checked = 'checked' } @else{} @endif value="Estates Director"> Estates Director </label>
  


    
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('Inspector Of Works',$str_array)) { checked = 'checked' } @else{} @endif value="Inspector Of Works"> Inspector Of Works </label>
            


          
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('Transport Officer',$str_array)) { checked = 'checked' } @else{} @endif value="Transport Officer"> Transport Officer </label>
     

              


                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('Head Procurement',$str_array)) { checked = 'checked' } @else{} @endif value="Head Procurement"> Head Procurement </label>
     


               <div class="checkbox">
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('CLIENT',$str_array)) { checked = 'checked' } @else{} @endif value="CLIENT"> CLIENT </label>
        



             
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('UDSM STAFF',$str_array)) { checked = 'checked' } @else{} @endif value="UDSM STAFF"> UDSM STAFF </label>
            


            
</DIV>

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

    </div>
    <br>


    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
		
		
		
    </script>
    @endSection