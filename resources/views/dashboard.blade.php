@extends('layouts.master')

@section('title')
   Dashboard
    @endSection

@section('body')

  <!-- Content Wrapper. Contains page content -->
  <div >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <!--  <h1 class="m-0">Dashboard</h1>-->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

      <!-- Main content -->
   <!-- <section class="content">
      <div class="container-fluid">
      
        <div class="row">
          <div class="col-lg-3 col-6">
      
            <div class="small-box bg-info">
              <div class="inner">
             0

                <p>Idadi ya mali zako</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
           
            </div>
          </div>
     
          <div class="col-lg-3 col-6">
      
            <div class="small-box bg-success">
              <div class="inner">
               0

                <p>Idadi ya wapangaji</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            
            </div>
          </div>
         
          <div class="col-lg-3 col-6">
       
            <div class="small-box bg-warning">
              <div class="inner" style="color: white;">
             0
                       

                <p>Mda uliokaribia kuisha</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
          
            </div>
          </div>
        
          <div class="col-lg-3 col-6">
     
            <div class="small-box bg-danger">
              <div class="inner">
              0

                <p>Idadi ya mali zilizo wazi</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              
            </div>
          </div>
     
        </div>
      </div>
    </section> -->
    <h4 align="center">You Have Successifully Loggedin as <b> {{auth()->user()->name}}</b></h4>

  </div>


@endsection