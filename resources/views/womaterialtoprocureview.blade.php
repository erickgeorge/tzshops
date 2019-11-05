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

        <h4  style="     color: #c9a8a5;"> Notify Store Manager to assign Good Receiving Note about material purchased.</h4>
         <a class="btn btn-primary btn-sm" href="{{ route('store.materialafterpurchase', [$item->work_order_id]) }}" role="button">Notify Store Manager</a>
         <a class="btn btn-success btn-sm" href="#" role="button" data-toggle="modal" data-target="#exampleModal">Create Minute Sheet</a>
                 
        
        </div>
           

            @if(strpos(auth()->user()->type, "HOS") !== false)
          {{-- <div class="col">     
                                <a href="{{ url('rejected/materials')}}">
                                    <button style="margin-bottom: 20px" type="button" class="btn btn-danger">rejected materials
                                    </button>
                                </a>
                            </div> --}}
            @endif
                     <?php
use App\User;
 ?>
<!-- SOMETHING STRANGE HERE -->
          

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ url('newsheets') }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create new Minute Sheet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>
      <div class="modal-body">
      
      </div>
      <div class="modal-body">
        
      <div class="row">
        <div class="col">
            <select name="_to" class="form-control mr-sm-2" required="">
                <option value="" selected="selected">Send To</option>
          <?php $user = User::get();
          foreach ($user as $used) {
            if(($used['id']!=auth()->user()->id)&&($used['type'] == 'Head Procurement') || ($used['type'] == 'STORE' )){
              echo "<option value='".$used['id']."'>".$used['fname']." ".$used['lname']." - ".$used['type']."</option>";
            }
          }
           ?>
            </select>
        </div>
      </div>
    </div>
    <input type="hidden" name="id" value="{{ $item->work_order_id }}">
    <div class="modal-body">
      <div class="row">
        <div class="col">
          <textarea cols="12" rows="12" placeholder="Message" name="message" class="form-control mr-sm-2" required="">
    
            </textarea>
      </div>
      </div>
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </div>
</form>
  </div>

          <!-- ---------------------- -->
  
               
    </div>


    
    @endSection