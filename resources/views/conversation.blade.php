@extends('layouts.master')

@section('title')
    Minute Sheets Conversations
    @endSection

@section('body')


<?php use App\Material;
use App\User;
use App\WorkOrderStaff;
use App\WorkOrderMaterial;
use App\MinuteSheet;
use App\MinuteConversation;
?>
<style type="text/css">
    .chat {
  display: flex;
  flex-direction: column;
  padding: 10px;
  margin-bottom: 100px;
}

.messages {
  margin-top: 30px;
  display: flex;
  flex-direction: column;
}

.message {
  border-radius: 5px;
  padding: 8px 15px;
  margin-top: 5px;
  margin-bottom: 5px;
  display: inline-block;
}

.yours {
  align-items: flex-start;
}

.yours .message {
  margin-right: 25%;
  background-color: #eee;
  position: relative;
}

.yours .message.last:before {
  content: "";
  position: absolute;
  z-index: 0;
  bottom: 0;
  left: -7px;
  height: 20px;
  width: 20px;
  background: #eee;
  border-bottom-right-radius: 5px;
}
.yours .message.last:after {
  content: "";
  position: absolute;
  z-index: 1;
  bottom: 0;
  left: -10px;
  width: 10px;
  height: 20px;
  background: white;
  border-bottom-right-radius: 5px;
}

.mine {
  align-items: flex-end;
}

.mine .message {
  color: white;
  margin-left: 25%;
  background: linear-gradient(to bottom, #00D0EA 0%, #0085D1 100%);
  background-attachment: fixed;
  position: relative;
}





</style>
<br>
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h3><b>Minute Sheet - Conversation </b></h3>
        </div>
        <div class="col-md-6"> <button style="max-height: 40px;" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
 Minute sheet Details
</button>
        </div>


<!-- SOMETHING STRANGE HERE -->
         

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    
    <div class="modal-content">
      
     
      

  <div class="modal-body">
      <div class="row">
        <div class="col">
        <table class="table table-striped display">
            <th>From</th>
            <th>Material name</th>
            <th>Type</th>
            <th>Material to purchase</th>
            @foreach($worked as $woid)
           <?php $name = $woid->Woid; ?>
            @endforeach


            <?php $item= 
WorkOrderMaterial::select(DB::raw('work_order_id,staff_id,material_id,sum(quantity) as quantity'))->where('status',5)->where('work_order_id',$name)->groupBy('material_id')->groupBy('work_order_id')->groupBy('staff_id')->get();
            ?>
            @foreach($item as $item) 
            <?php $tot = 0 -($item['material']->stock - $item->quantity); if($tot > 0){?>
            <tr>

                <td>{{ $item['staff']->fname.' '.$item['staff']->lname }}</td>
<td>{{ $item['material']->name }}</td>
<td>{{ $item['material']->type }}</td>
<td style="color: blue"> <?php $tot = 0 -($item['material']->stock - $item->quantity); if($tot > 0){ echo 0 -($item['material']->stock - $item->quantity); }else{echo '-';}?></td>

            </tr><?php }else{echo '-';}?>@endforeach
        </table>
        </div>
      </div>
  </div>
     
    </div>
  </div>
</div>
          <!-- ---------------------- -->
       
    </div>
    <br>
    <hr>
     <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
   <div class="chat">
    @foreach($conversatt as $conv)

    @if($conv->_From == auth()->user()->id)

  <div class="mine messages">
    <div class="message last">
      To: <?php $huyu = User::Where('id',$conv->_To)->get(); ?>@foreach($huyu as $huyu) {{ $huyu->fname }} {{ $huyu->lname }}@endforeach <hr>
     <b>{{ $conv->Message }}</b><br><small><?php $time = strtotime($conv->Sent); echo date('d/m/Y',$time);  ?></small>&nbsp;&nbsp;&nbsp; | From : <?php $huyu = User::Where('id',$conv->_From)->get(); ?>@foreach($huyu as $huyu) {{ $huyu->fname }} {{ $huyu->lname }}@endforeach
     </div>
  </div>

    @else
     <div class="yours messages">
    <div class="message">
        To: <?php $huyu = User::Where('id',$conv->_To)->get(); ?>@foreach($huyu as $huyu) {{ $huyu->fname }} {{ $huyu->lname }}@endforeach<hr>
    <b>{{ $conv->Message }}</b><br><small><?php $time = strtotime($conv->Sent); echo date('d/m/Y',$time);  ?></small>&nbsp;&nbsp;&nbsp; | From : <?php $huyu = User::Where('id',$conv->_From)->get(); ?>@foreach($huyu as $huyu) {{ $huyu->fname }} {{ $huyu->lname }}@endforeach
    </div>
  </div>
    @endif
    @endforeach

</div>

</div>
@foreach($last as $him)
@if(($him->_From == auth()->user()->id)||($him->_To == auth()->user()->id)||($him->_With == auth()->user()->id))
<div style="position: fixed; bottom: 0; left: 0; right: 0;">
<div id="accordion">
 
  <div class="card">
    <div class="card-header bg-success" id="headingThree" align="center">
      <h5 class="mb-0">
        <button class="btn btn-succes collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <i class="fa fa-plus"></i> Write new message
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
<form  method="POST" action="{{ url('addconv') }}">
    @csrf
 <div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text">Message</span>
  </div>
  <textarea class="form-control" name="message" aria-label="With textarea"></textarea>
</div><br>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">To</span>
  </div>
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
            <div class="input-group-append">
    <button class="btn btn-outline-primary" type="submit">Send</button>
  </div>
@foreach($worked as $woid)
<input type="hidden" name="id" value="{{ $woid->Woid }}">
@endforeach
</div>
</form>
      </div>
    </div>
  </div>

</div>
 
</div>
@endif
@endforeach