@extends('layouts.master')

@section('title')
    Store Report
    @endSection

@section('body')

    <br>
     <br>
      <br>
       <br>
        <br>

<div id="div_print">
     <div class="container">
            <h5 style="padding-left: 90px; "><b style="text-transform: uppercase;">Available Materials in Store </b></h5>  
             <hr>
        </div>
    <br>
   
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif

   
    <div class="container">
     
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead >
               <tr style="color: white;">
                    <th>#</th>
                    <th>Material Name</th>
                    <th>Brand Name</th>
                    <th>Type</th>
                    <th>Available materials</th>
                    <th>Total Materials in store</th>
                   </tr>
                </thead>

                   <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                                  <td>{{ $item->name }}</td>
                                  <td>{{ $item->description }}</td>
                                  <td>{{ $item->type }}</td>
                                  <td>{{ number_format($item->totalstock) }}</td>
                                  <td>{{ $item->stock }}</td>    
                                  </tr>
                    @endforeach
            </tbody>

                
            </table>
       
    </div>
    
    @endSection