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
            <h3 align="center"><b>Material Purchased by Head of Procurement </b></h3>

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
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >HoS Name</th>
                <th >Material Name</th>
                <th >Brand Name</th>
                <th >Value/Capacity</th>
                <th >Type</th>
                
                <th >Quantity Purchased</th>
                <th>Action</th>
               
    
                
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
                 
                   <td style="color: blue"> {{ $item->quantity - $item->reserved_material}}</td>

                   @if($item['material']->stock == 0)
                      <td>
                        &nbsp;&nbsp;&nbsp;
                        <a style="color: green;" href="{{ route('storeIncrement.view', [$item->material_id]) }}"  data-toggle="tooltip" title="Increment material"><i class="fas fa-plus"></i></a>&nbsp;
                        <!--<a style="color: black;" href="" data-toggle="tooltip" title="Track"><i class="fas fa-tasks"></i></a>-->
                        </td>
                    @else
                    <td><span class="badge badge-info">sccesifully added</span></td>
                    @endif

                    </tr>
                    @endforeach
            </tbody>
        </table>
        
         <h4  style="     color: #c9a8a5;"> Please assign Good Receiving Note for received material then add material in Store.</h4>
         <a class="btn btn-primary btn-sm"  href="grnpdf/{{$item->work_order_id}}" role="button">Assign GRN</a>
       
                  
    </div>
    
    
    @endSection