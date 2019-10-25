@extends('layouts.master')

@section('title')
    Material to be purchased 
    @endSection

@section('body')


    <br>
    <br>

<br>
<br>

    <div>
        <div>
            <h3 class="container"><b>Work order  with material to be purchased </b></h3>
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
                <th >Quantity Requested</th>
                <th >Quantity Reserved</th>
                <th >Material to Purchase</th>
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


                    <td style="color: blue"> {{ (0 -($item['material']->stock - $item->quantity) )}}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>

        <h3> Material purchased please notify Store Manager to add material in store  </h3>
         <a class="btn btn-primary btn-sm" href="{{ route('store.materialafterpurchase', [$item->work_order_id]) }}" role="button">Send Notification</a></td>              
    </div>


    
    @endSection