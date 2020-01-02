@extends('layouts.master')

@section('title')
    store
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>All transport Requests</b></h3>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <br>
    <hr class="container">
    <div style="margin-right: 2%; margin-left: 2%;">
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
        <table class="table table-striped display" id="myTable"  style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th >#</th>
                <th >HOS name</th>
				<th >Location</th>
                <th >Details</th>
				<th >Date</th>
				
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

                <td>{{$item->coments}}</td>
				
				
					<td>{{ date('d/m/Y', strtotime($item->time)) }} - {{ date('h:m a', strtotime($item->time)) }}</td>
					<?php
					$idt=$item->id;

					 ?>
					 
					
					 <td>
					  @if(($item->time)>Carbon\Carbon::now())
					<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="return transportrequest('{{$idt}}','1');" href="#" role="button">Accept</a> 
						  &nbsp &nbsp 
					<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="return transportrequest('{{$idt}}','-1');" href="#" role="button">Reject</a> </td>
						
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
                    <p>Comments from Transport Officer .</p>
                    <form method="POST" action="transport_request/accept">
					
					  &nbsp &nbsp 
					   @csrf
					   
					   <input   id="transportid" name="transportid"  hidden  />
					    <input   id="status" name="status"  hidden  />
                      
                        <textarea name="details" required maxlength="100" class="form-control"  rows="5" ></textarea>
                        <br>
						
					
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
						
                </div>
            </div>
        </div>
    </div>
	<p id="n" > </p> 
</div>
	
    @endSection
	
	
	<script type="text/javascript">
    function transportrequest (id,status) {
		document.getElementById('transportid').value=id;
		document.getElementById('status').value=status;
        // return true or false, depending on whether you want to allow the `href` property to follow through or not
    }
</script>