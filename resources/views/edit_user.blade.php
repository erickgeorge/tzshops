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
                <input  style="color: black" required type="text" name="phone" value="{{ $user->phone }}"
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
                <select style="width: 366px;" class="custom-select" name="college" id="directorate" onchange="getDepartments()">
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
                    <option value="{{ $dep->id }}">{{ $dep->description }}</option>
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

    <div>
       <div >
        <label>Type of User</label><br>
        <input id="Button1" type="checkbox" value="Click" onclick="switchVisible();"/>Head of Section
       </div>
              <div id="Div1" >
               <select class="custom-select" name="type[]" id="type">
                      <option value="" selected>Choose...</option>
                      <option value="Accountant">Accountant</option>
                      <option value="Auditor">Auditor</option>
                      <option value="CLIENT">Client</option>
                      <option value="DVC Admin">DVC Admin</option>
                      <option value="Estates Director">Estates Director</option>
                      <option value="Head Procurement">Head of Procurement</option>
                      <option value="Inspector Of Works">Inspector Of Works</option>
                      <option value="Maintenance coordinator">Maintenance Coordinator</option> 
                      <option value="STORE">Store Manager</option>
                      <option value="Transport Officer">Transport Officer</option>

               </select>
               </div>
               <br>

               <div  id="Div2">
                
              
                <label> 
                 <input  type="checkbox" name="type[]" @if (in_array('HOS Electrical',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Electrical"> HOS Electrical </label>
         
           &nbsp; &nbsp; &nbsp;
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Plumbing',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Plumbing"> HOS Plumbing </label>
      
           &nbsp; &nbsp; &nbsp;
          
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Carpentry/Painting',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Carpentry/Painting"> HOS Carpentry/Painting </label>
          
           
             &nbsp; &nbsp; &nbsp;

      
                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Mechanical',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Mechanical"> HOS Mechanical</label>
  
             &nbsp; &nbsp; &nbsp;

                <label> 
                 <input type="checkbox" name="type[]" @if (in_array('HOS Masonry/Road',$str_array)) { checked = 'checked' } @else{} @endif value="HOS Masonry/Road"> HOS Masonry/Road </label>
       


             
             </div>

             
         </div>


  
            


  <script type="text/javascript">
    
    function switchVisible() {
            if (document.getElementById('Div1')) {

                if (document.getElementById('Div1').style.display == 'none') {
                    document.getElementById('Div1').style.display = 'block';
                    document.getElementById('Div2').style.display = 'none';
                }
                else {
                    document.getElementById('Div1').style.display = 'none';
                    document.getElementById('Div2').style.display = 'block';
                }
            }
}
  </script>


            
            
            
            
            
            
            
            


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