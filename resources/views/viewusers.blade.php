@extends('layouts.master')

@section('title')
view users
@endSection
@section('body')
<br>
<div class="row container-fluid">
  <div class="col-md-7">
    <h3>Available Users</h3>
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
<br>
<hr>
<a href="{{ route('createUserView') }}">  <button  style="margin-bottom: 20px" type="button" class="btn btn-primary">Add new user</button></a>
<table class="table table-striped" id="myTable"">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th title="phone" scope="col">Phone</th>
      <th scope="col">Department</th>
      <th scope="col">Section</th>
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
      <td>{{ $user->phone }}</td>
      <td>{{ $user['section']['department']->name }}</td>
      <td>{{ $user['section']->section_name }}</td>
     
      <td>
        <div class="row">
        <a style="color: green;" href="{{ route('user.edit.view', [$user->id]) }}"  data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>


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