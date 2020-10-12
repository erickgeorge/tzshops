@extends('layouts.master')

@section('title')
    Material Request
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h5   style="text-transform: capitalize;"><b>PROCUREMENT REQUEST OF WORKs ORDER</b></h5>
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

    <div class="container " style="margin-right: 2%; margin-left: 2%;">
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead >
          <tr style="color: white;">
                <th >#</th>

				<th >Material Name</th>
				<th >Material Description</th>
				<th >Type</th>
				<th >Quantity</th>



            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>

                    <td>{{$item['material']->name }}</td>
                    <td>{{ $item['material']->description }}</td>
                    <td>{{ $item['material']->type }}</td>
					  <td>{{ $item->quantity }}</td>




                    </tr>
                    @endforeach
            </tbody>

        </table>
		 <td>

					 <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" role="button" data-toggle="modal" data-target="#exampleModal">ISSUE GRN</a></td>


    </div>








 <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Signing GRN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>By signing this note you prove that Material(s) for this procurement are received</p>
                    <form method="POST" action="{{ route('procurement.grn',['id'=>$item->work_order_id]) }}">
                        @csrf
<label>   Supplier <sup style="color: red;">*</sup></label>

                        <input required name="supplier" required maxlength="20" class="form-control"  rows="5" id="supplier"/>
</br>
<label> Date received   <sup style="color: red;">*</sup></label>
<input required type="date" data-provide="datepicker" name="date" id="date"  max="<?php echo date('Y-m-d'); ?>" />
                        <br>
                        <button type="submit" class="btn btn-primary">Sign GRN</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>










    @endSection
