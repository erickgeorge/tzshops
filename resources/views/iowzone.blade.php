@extends('layouts.master')

@section('title')
    Assign zone for IoW
    @endSection
@section('body')

      <br>
      <div  class="container">
            <br>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
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
                <h5  id="new_dep">Assign Zone for Inspector of Work</h5>
                <hr>



<table class="table table-responsive table-striped" id="myTable">
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
    @foreach($IoW as $user)
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
         <td style="text-transform: lowercase;">{{ $user->type }} , <h7 style="color: red;" >No zone assigned</h7> </td>
         <td>{{ $user['department']['directorate']->name }}</td>
        <td>{{ $user['department']->name }}</td>
        <td>
       &nbsp;&nbsp;&nbsp;
        <a style="color: green;" href="{{ route('iow.assign.zone', [$user->id]) }}"  data-toggle="tooltip" title="Assign Zone"><i class="fas fa-address-book"></i></a>




      </td>
    </tr>
    @endforeach
  </tbody>


</table>


            </div>





     @endSection
