@extends('layouts.master')

@section('title')
view users
@endSection
@section('body')
<?php
use App\Technician;
use App\User;
use App\Directorate;
use App\Department;
use App\Section;
 ?>
<br>
<div class="row container-fluid" >
  <div class="col">
    <h5 style="padding-left: 90px;  text-transform: uppercase;">Available Registered Users</h5>


  </div>
 
  {{--<div class="col-md-5">
    <form class="form-inline my-2 my-lg-0">
      <input style="width:220px;" class="form-control mr-sm-2" type="search" placeholder="Search by Fullname, email" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>--}}
</div>
  @if(Session::has('message'))
    <br>
    <p class="alert alert-success">{{ Session::get('message') }}</p>
  @endif
  
  @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger" style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><?php echo $error; ?></li>
                @endforeach
            </ul>
        </div>
    @endif

<hr>

  
    
  
  
    <div id="div_print" style="margin-left: 2%; margin-right: 2%;">
  
  
  <div class="row">
     <div class="col-md-5">
    <a style="margin-left: 2%;" href="{{ route('createUserView') }}">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new user</button></a>
  </div>
  <div class="col-md-5" align="right">


</div>
@if(!$display_users->isEmpty())

<!-- SOMETHING STRANGE HERE -->
                <div class="col" align="right">
           <a href="" data-toggle="modal" class="btn btn-outline-primary mb-2" data-target="#exampleModal"><i class="fa fa-file-pdf-o"></i> PDF </a>
        </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('userpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="college" class="form-control mr-sm-2">
                    <option selected="selected" value="">select name</option>
                    <option value="">All users</option>
        <?php 
                 $userfetch = user::get();
  foreach($userfetch as $userfetch)
  {

    

      $departmentor = department::where('id',$userfetch->section_id)->get();
      foreach($departmentor as $departmentor)
      {

          $directora = directorate::where('id',$departmentor->directorate_id)->get();
          foreach($directora as $directora){?>
<option value="{{ $userfetch->id }}">{{ $userfetch->fname }} {{ $userfetch->lname }} - ( {{ $departmentor->name }}, {{ $directora->name }})</option>
          <?php }
      }

    
  }
        ?>

 
                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="type" class="form-control mr-sm-2">
                    <option selected="selected" value="">select Type</option>
                    <option value="">All Types</option>

                    <?php
                      $type = User::select('type')->distinct()->get();
                      foreach ($type as $typed) {
                        echo " <option  value='".$typed->type."'>".$typed->type."</option>";
                      }
                     ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->
  </div>
  
<table class="table table-striped" id="myTable">
  <thead >
    <tr style="color: white;">
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th title="phone" scope="col">Phone</th>
      <th scope="col">Type</th>
    <th scope="col">Directorate</th>
      <th scope="col">Department</th>
      <!--<th scope="col">Section</th>-->
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php 

 if (isset($_GET['page'])){
if ($_GET['page']==1){

  $i=1;
}else{
  $i = ($_GET['page']-1)*5+1; }
}
else {
 $i=1;
}
 $i=1;

   ?>
    @foreach($display_users as $user)
    <tr>
      <th scope="row">{{ $i++ }}</th>
      <td>{{ $user->fname . ' ' . $user->lname }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>

      <?php $phonenumber = $user->phone;
        if(substr($phonenumber,0,1) == '0'){

          $phonreplaced = ltrim($phonenumber,'0');
          echo '+255'.$phonreplaced;
          
        }else { echo $user->phone;}

      ?></td>

      @if( $user->type == "Inspector Of Works")
      <td style="text-transform: lowercase;">{{ $user->type }} ,  @if( $user->IoW == 2) <h7 style="color: green;" >{{ $user->zone }}</h7>@elseif( $user->IoW == 1 ) <h7 style="color: red;" >{{ $user->zone }}</h7> @endif</td>
       
      @else

             <td style="text-transform: lowercase;">{{ $user->type }} </td>
      
      @endif


         <td>{{ $user['department']['directorate']->name }}</td>
        <td>{{ $user['department']->name }}</td>
        <td>
        <div class="row">
        <a style="color: green;" href="{{ route('user.edit.view', [$user->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>  &nbsp;
 

         <form  method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" action="{{ route('user.delete', [$user->id]) }}" >
          {{csrf_field()}}


        <button type="submit" data-toggle="tooltip" title="Delete"   > <a style="color: red;" href=""  data-toggle="tooltip" ><i class="fas fa-trash-alt"></i></a>


       </button>
     </form>
   </div>
      </td>
    </tr>
    @endforeach
  </tbody>

 
</table>

</div>
  @endif






<script>
$(document).ready(function(){

  $('[data-toggle="tooltip"]').tooltip();   
  
 

$('#myTable').DataTable({
   "drawCallback": function ( settings ) {

    /*show pager if only necessary
    console.log(this.fnSettings());*/
    if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
        $('#dataTable_ListeUser_paginate').css("display", "block");     
    } else {                
        $('#dataTable_ListeUser_paginate').css("display", "none");
    }

    }
});
  
  
  jQuery('#myTable').DataTable({
    fnDrawCallback: function(oSettings) {
        var totalPages = this.api().page.info().pages;
        if(totalPages == 1){ 
            jQuery('.dataTables_paginate').hide(); 
        }
        else { 
            jQuery('.dataTables_paginate').show(); 
        }
    }
});
  
  
  
});


function warning (){
  alert("Are you sure you want to delete this?");
}
</script>
@endSection