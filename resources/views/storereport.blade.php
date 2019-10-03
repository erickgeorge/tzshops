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
            <h3><b>Available Materials in Store </b></h3>  <button   name="b_print" type="button" class="btn btn-success mb-2"   onClick="printdiv('div_print');"  style="font-size:24px ">Export to pdf <i class="fa fa-file-pdf-o" style="color:red"></i></button>
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
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                 
                   
                    <th>Type</th>

                    <th>Tottal Number of Type</th>


                     <th>Current Available Material</th>
                   
                </tr>
                </thead>

                   <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
 
                    <td>{{ $item->type }}</td>
                                        <td>{{ $item->totalstock }}</td>

                                        <td>{{ $item->stock }}</td>


                  
                    
                    </tr>
                    @endforeach
            </tbody>

                
            </table>
       
    </div>
    
    @endSection