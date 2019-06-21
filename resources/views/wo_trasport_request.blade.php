@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3><b>All transport Requests</b></h3>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
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
                <th >HOS name</th>
				<th >Location</th>
				<th >Date</th>
				<th >Time</th>
				
				<th >Action</th>
				
            </tr>
            </thead>

            <tbody>

            <?php $i=0;  ?>
            @foreach($items as $item)

                <?php $i++ ?>
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $item['requester']->fname.'  '.$item['requester']->lname  }}</td>
                    @if(empty($item['workorder']->location))
                    <td>{{ 
				$item['workorder']['room']['block']->location_of_block  
				
				}}</td>
				
				@else
				<td>{{ 
				$item['workorder']->location

				}}</td>
				
				@endif
				
				
					<td>{{ date('F d Y', strtotime($item->time)) }}</td>
					
					<td>{{ date('h:m:s a', strtotime($item->time)) }}</td>
					<?php
					$idt=$item->id;

					 ?>
					 
					
					 <td>
					  @if(($item->time)>Carbon\Carbon::now())
					<a class="btn btn-success btn-sm" href="{{ route('transportrequest.accept',[$idt]) }}" role="button">Accept</a> 
						  &nbsp &nbsp 
					<a class="btn btn-danger btn-sm" href="{{ route('transportrequest.reject',[$idt]) }}" role="button">Reject</a> </td>
						
						@else
				 EXPIRED REQUEST 
						@endif
				   </tr>
                    @endforeach
            </tbody>
        </table>
	
    </div>
	
	  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Transport form details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please fill details of your transport form.</p>
                    <form method="POST" action="" role="button">
					
					  &nbsp &nbsp 
					   @csrf
					   
					   <input   id="transportid" name="transportid"   type="number"  />
                        <textarea name="details" required maxlength="100" class="form-control"  rows="5" id="details"></textarea>
                        <br>
						
					
                        <button type="submit" class="btn btn-danger">Submit</button>
						
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
	<p id="n" > j </p> 
	
    @endSection
	
	
	<script>
	
	
	
	
	</script>