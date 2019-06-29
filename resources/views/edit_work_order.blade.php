@extends('layouts.master')

@section('title')
    work order
    @endSection

@section('body')

<script>
var total=5;

</script>
    <br>
    <div class="row container-fluid">
        <div class="col-md-8">
            <h3>Work order details</h3>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    <h5>This work order is from <span style="color: green">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span></h5>
    <h5>Has been submitted on <span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span></h5>
    <h3 style="color: black">Contacts:</h3>
    <h5>{{ $wo['user']->phone }}</h5>
    <h5>{{ $wo['user']->email }}</h5>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type of a problem</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{ $wo->problem_type }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="location not defined" name="location"
               aria-describedby="emailHelp" value="{{ $wo['room']['block']->location_of_block }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area" aria-describedby="emailHelp"
               value="{{ $wo->room_id }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Block</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="block" name="block" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']->name_of_block }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Room</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="room" name="room" aria-describedby="emailHelp"
               value="{{ $wo['room']->name_of_room }}" disabled>
    </div>
    <div class="form-group ">
        <label for="">Details:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
    <br>
        <h4>Fill the details below to complete the work order.</h4>
        <form method="POST" action="{{ route('workOrder.edit', [$wo->id]) }}">
            @csrf
            <div class="form-group ">
                {{--<p>Is this work order emergency?</p>--}}
                @if($wo->emergency == 1)
                    <input type="checkbox" name="emergency" checked> This work order is emergency.
                @else
                    <input type="checkbox" name="emergency"> This work order is emergency.
                @endif
            </div>
            <div class="form-group ">
                {{--<p>Does this work order needs labourer?</p>--}}
                @if($wo->needs_laboured == 1)
                    <input type="checkbox" name="labour" checked> This work order needs labourer.
                @else
                    <input type="checkbox" name="labour"> This work order needs labourer.
                @endif
            </div>
            <div class="form-group ">
                {{--<p>Does this work order needs contractor?</p>--}}
                @if($wo->needs_contractor == 1)
                    <input type="checkbox" name="contractor" checked> This work order needs contractor.
                @else
                    <input type="checkbox" name="contractor"> This work order needs contractor.
                @endif
            </div>
            <button type="submit" class="btn btn-success">Save changes</button>
            <a href="/home" class="btn btn-dark">Cancel Editing</a>
        </form>
        <br>
        <h4>Work order forms.</h4>
        {{-- tabs --}}
        <div class="payment-section-margin">
            <div class="tab">
                <div class="container-fluid">
                    <div class="tab-group row">
						<button class="tablinks col-md-3" onclick="openTab(event, 'assigntechnician')">ASSIGN TECHNICIAN FOR WORK</button>
						<button class="tablinks col-md-2" onclick="openTab(event, 'request_transport')">REQUEST TRASPORT
                        </button>
						<button class="tablinks col-md-2" onclick="openTab(event, 'material_request')" id="defaultOpen">MATERIAL REQUEST FORM</button>
                        
                        <button class="tablinks col-md-2" onclick="openTab(event, 'customer')">INSPECTION FORMS</button>
						 <button class="tablinks col-md-3" onclick="openTab(event, 'delivery')" id="defaultOpen">PROCUREMENT OF MATERIAL FORM</button>
                        
                    </div>
                </div>





			{{-- ASSIGN TECHNICIAN tab--}}
               
                    @csrf
                    <div id="assigntechnician" class="tabcontent">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Assign Technician for this work-order</p>
                            </div>
                        </div>
						<div >
						<p id="alltechdetails">hapa  </p>
						
						
						
						</div>
						
						
                        <div class="form-group">
                           
                            <select  id="techid" required class="custom-select"  name="techuser">
                               
                                @foreach($techs as $tech)
                                    <option value="{{ $tech->id }}">{{ $tech->fname.' '.$tech->lname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button data-toggle="modal" data-target="#exampleModal"  onclick="getTechnician()" style="background-color: darkgreen; color: white" type="button" class="btn btn-success">Save Technician</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </div>
               
                {{-- end ASSIGN TECHNICIAN  --}}

				
				
				








                {{-- INSPECTION tab--}}
                <form method="POST" action="{{ route('work.inspection', [$wo->id]) }}">
                    @csrf
                    <div id="customer" class="tabcontent">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Work order status</p>
                            </div>
                        </div>
						
						
						 <div class="form-group">
                            
							<select class="custom-select" required name="status">
                                <option selected value="" >Choose...</option>
                               
                                    <option value="Report Before Work">Report Before Work</option>
									   <option value="Report After Work">Report After Work</option>
                              
                            </select>
							
                        </div>
					
						
						
						
                        <p>Inspection description</p>
                        <div class="form-group">
                            <textarea  style="color: black" name="details" required maxlength="100" class="form-control"  rows="5" id="comment"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Select Technician on Duty</label>
                            <select  required class="custom-select"  name="technician">
                                <option  selected value="" >Choose...</option>
                                @foreach($techs as $tech)
                                    <option value="{{ $tech->id }}">{{ $tech->fname.' '.$tech->lname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save Inspections</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </div>
                </form>
                {{-- end inspection --}}
				
				
				
				 {{-- request_transport form--}}
                <form method="POST" action="{{ route('work.transport', [$wo->id]) }}">
                    @csrf
                    <div id="request_transport" class="tabcontent">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Work order Transport Request Form</p>
                            </div>
                        </div>
				</br>
                        <p>Transport date</p>
                        <div class="form-group">
                            <input type="date" style="color: black" name="date" required class="form-control"  rows="5" id="date"  min="<?php echo date('Y-m-d'); ?>" ></input>
                        </div>
						
						  <p>Transport time</p>
                        <div class="form-group">
                            <input type="time" style="color: black" name="time" required class="form-control"  rows="5" id="time"></input>
                        </div>
                       
                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save Transport Request</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </div>
                </form>
                {{-- end request_transport form --}}
				
				
				
				
				{{-- material_request tab--}}
                <form method="POST"  action="{{ route('work.materialadd', [$wo->id]) }}" >
                    @csrf
                    <div id="material_request" class="tabcontent">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Select material for work-order</p>
                            </div>
                        </div>
						
						<?php
						
						use App\Material;
						$materials= Material::get();
						
						?>
						
						
						
						
                        <div class="form-group">
                           
                            <select onchange="stock();" required class="custom-select"  id="mname" name="mname">
                                <option   selected value="" >Choose...</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name.' '.$material->description }}</option>
                                @endforeach
                            </select>
                        </div>
						
						
						 <p>Quantity</p>
                        <div class="form-group">
                            <input type="number" min="1"  style="color: black" name="mquantity" required class="form-control"  rows="5" id="mquantity"></input>
                        </div>
						
						
                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save Material</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </div>
                </form>
                {{-- end material_request  --}}
				
				
				
				

                {{-- materials tab --}}
                <div id="delivery" class="tabcontent">
                    <h4>Material Form</h4>
                    <p>To be populated.</p>
                </div>

                {{-- transportation tab --}}
                <div id="payment" class="tabcontent">
                    <h4>Transportation Form</h4>
                    <p>To be populated.</p>
					
                </div>
            </div>
        </div>
    <br>
	
	
	{{-- TECHNICIAN DETAILS FORM  --}}
	 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Technician details form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				
				<p id="detail" >
				ok
				</p>
				<h2> This technician has been assigned Following Number Of Work orders : </h2>
				
				<h3  id="totalwork" style="color:red">
				</h3>
				
				
				
				
                  
                    <form method="POST" action="{{ route('work.assigntechnician', [$wo->id]) }}">
                        @csrf
                         <br>
						 <input name="technician_work" id="technician_work"  type="text" hidden> </input>  
                        <button type="submit" class="btn btn-danger">Assign Technician</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
	 @endSection
	
	<script>
	async function getTechnician(){
		var detail;
		var techid;
		var id = document.getElementById("techid").value;
	var response = await fetch('/gettechniciandetails/'+id).then(function(response){
		return response.json();
		})
	.then(data => {
		total=data["workorderstaff"].length;
		detail='Full name : '+data["technician"].lname+data["technician"].fname+'  Type is : '+data["technician"].type+'  \r    Phone : '+data["technician"].phone+'  Email is : '+data["technician"].email ;
		techid=data["technician"].id;
		//h=data[0].work_order_id;
		//console.log(data[0].work_order_id);
		
	});
		
		
		document.getElementById("detail").innerHTML=detail;
		document.getElementById("totalwork").innerHTML=total;
		document.getElementById("technician_work").value=techid;
		
      }
	// getTechnician(5);
	</script>
	
	
	