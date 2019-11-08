@extends('layouts.master')

@section('title')
    Material Reserved
    @endSection

@section('body')


    <br>
    <br>

<br>
<br>

    <div>
        <div>
            <h3 class="container"><b>Material Purchased from Head of Procurement </b></h3>

        </div>
       
    </div>


    <br>
    <hr>
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
   
    <div class="container " >
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >HoS Name</th>
                <th >Material Name</th>
                <th >Brand Name</th>
                <th >Value/Capacity</th>
                <th >Type</th>
                
                <th >Quantity Purchased</th>
               
    
                
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['staff']->fname.' '.$item['staff']->lname }}</td>
                    <td>{{ $item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->brand }}</td>
                    <td>{{ $item['material']->type }}</td>
                 
                   <td style="color: blue"> {{ (0 -($item['material']->stock - $item->quantity) )}}</td>

                    </tr>
                    @endforeach
            </tbody>
        </table>
        
         <h4  style="     color: #c9a8a5;"> Please assign Good Receiving Note for received material then add material in Store.</h4>
         <a class="btn btn-primary btn-sm"  href="grnpdf/{{$item->work_order_id}}" role="button">Assign GRN</a>
       
                  
    </div>
    
    
    @endSection