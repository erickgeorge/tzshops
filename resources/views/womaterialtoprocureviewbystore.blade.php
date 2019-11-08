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
            <h3 class="container"><b>Material Reserved by Works Orders</b></h3>
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
                <th >Description</th>
                <th >Unit Measure</th>
                <th >Type</th>
                <th >Quantity Requested</th>
                <th >Quantity Reserved</th>
               
    
                
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
                    <td>{{ $item->quantity }}</td>
                    <?php $m = 0 -$item['material']->stock + $item->quantity ?>
                       @if($m < 0 )
                       <td style="color: red">{{ $item['material']->stock = $item->quantity  }} </td>
                       @else 
                       <td style="color: red">  {{ $item['material']->stock }}</td>
                       @endif

                    </tr>
                    @endforeach
            </tbody>
        </table>
        
        
                  
    </div>
    
    
    @endSection