@extends('layouts.master')

@section('title')
    Material to be purchased
    @endSection

@section('body')
<?php
use App\User;
use App\MinuteSheet; ?>
    <br>



    <div>
        <div>
            <h5 class="container"><b>Material(s) to be Purchased </b></h5>
        </div>

    </div>


    <br>
    <hr class="container">
    <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    </div>

    <div class="container " >
        <table class="table table-responsive table-striped display" id="myTableproc"  style="width:100%">
            <thead >
            <tr style="color: white;">
                <th >#</th>

                <th >Material Name</th>
                <th >Material Description</th>
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

                    <td>{{ $item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->brand }}</td>
                    <td>{{ $item['material']->type }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->reserved_material }}</td>

                    <td> {{ $item->quantity- $item->reserved_material  }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>

       {{--  @if(auth()->user()->type == 'Head Procurement')

        <h4> Notify Store Manager to assign good receiving note about material(s) purchased.</h4>


         <a class="btn btn-primary btn-sm" href="{{ route('store.materialafterpurchase', [$item->work_order_id]) }}" role="button">Notify Store Manager</a>


         @endif --}}
<?php
$checkes = Minutesheet::where('Woid',$item->work_order_id)->get();
 ?>
 @if(count($checkes)>0)
  <b class="badge badge-info btn-sm">Minutes sheet already created</b> <a class="btn btn-success" href="{{ url('minutesheet',[$item->work_order_id]) }}">View</a>

  @else

        </div>
    @endif

            @if(strpos(auth()->user()->type, "HOS") !== false)
          {{-- <div class="col">
                                <a href="{{ url('rejected/materials')}}">
                                    <button style="margin-bottom: 20px" type="button" class="btn btn-danger">rejected materials
                                    </button>
                                </a>
                            </div> --}}
            @endif

<!-- SOMETHING STRANGE HERE -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ url('newsheets') }}"  id="mySign">
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
                <option value="" selected="selected">Send To <sup style="color: red;">*</sup></option>
          <?php $user = User::get();
          foreach ($user as $used) {
            if(($used['id']!=auth()->user()->id)&&($used['type'] == 'Head Procurement') || ($used['type'] == 'Acountant' ) || ($used['type'] == 'Estates Director') ){
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
  <div class="modal-body" class="border-dark">

  <label class="label" style="margin:5px;"> Signature :</label>
   @if(auth()->user()->signature_ == null)
       <p style="padding: 3em;">No Signature <a href="{{ url('s-minutesheet') }}" class="btn btn-primary">Add signature</a></p>
       @else
        <img src="{{ auth()->user()->signature_ }}" alt="signature can't be shown" style="height: 100px;">
        @endif
  </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Create</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
</form>
  </div>

          <!-- ---------------------- -->


    </div>


    @endSection
