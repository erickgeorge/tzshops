@extends('layouts.master')

@section('title')
    Material Reserved
    @endSection

@section('body')
@if(count($items)>0)


    <br>
    <br>


    <div>
        <div>
            <h3 align="center" class="container"><b style="text-transform: uppercase;">Material Reserved for Works Order</b></h3>
        </div>
       
    </div>


    <br>

    <hr class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
   
    <div class="container " >
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
           <tr style="color: white;">
                <th >#</th>
       
                <th >Material Name</th>
                <th >Description</th>
                <th >Unit Measure</th>
                <th >Type</th>
                <th >Quantity Requested</th>
                <th >Quantity Reserved</th>
                <th >Status</th>
               
    
                
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                   
                    <td>{{ $item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->brand }}</td>
                    <td>{{ $item['material']->type }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="color: blue;">{{ $item->reserved_material }}</td>
                    @if($item->status == 15 )
                    <td> <span class="badge badge-warning"> Purchased </span> </td>
                    @elseif($item->status == 3)
                    <td> <span class="badge badge-info"> Sent to Head of Section </span> </td>
                    @else
                    <td> <span class="badge badge-primary"> Reserved </span> </td>
                    @endif
                   

                    </tr>
                    @endforeach
            </tbody>
        </table>
        
        
                  
    </div>
    @else
        <div style="padding-top: 300px;">
        <div>
            <h3 align="center">No available Material Reserved by Works Orders</h3>
        </div>
       
    </div>

    @endif
    
    
    @endSection