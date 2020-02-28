@extends('layouts.master')

@section('title')
    Insert Users Data
    @endSection

@section('body')
<br>
    <div class="row" style=" margin-left:2%; margin-right:2%;">
        <div class="col-md-8">
            <h2>Upload Excel user's Data</h2>
        </div>
    </div>
    <hr>
 <div class="container">
   @if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <br><br>
   <div class="container" style="margin-top: 3%;">
    <form method="post" enctype="multipart/form-data" action="{{ url('importUserExcel') }}">
    @csrf
    <div class="form-group">
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Select File for Upload</label></td>
       <td width="30">
        <input type="file" name="select_file" />
       </td>
       <td>
       </td>
   </tr>
       <tr>
       	<td width="40%"></td>
       <td width="30%" align="left">
        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
       </td>
       <td></td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <td width="30"><span class="text-muted">File type must be .xls, .xslx</span></td>
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>

