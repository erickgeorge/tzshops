@extends('layouts.land')

@section('title')
    work order
    @endSection

@section('body')

<?php use App\WorkOrderInspectionForm;
    use App\WorkOrderTransport;
    use App\WorkOrderStaff;
    use App\techasigned;
    use App\WorkOrderMaterial;
    use App\User;
    use App\iowzone;
 

 ?>

  <?php 
     $IoWzone = User::where('status', '=', 1)->where('type', 'inspector of works')->where('IoW', 2)->get(); ?>


<style type="text/css">
.label{
    width: 700px;
}
</style>
<div class="container">
<script>
var total=2;

</script>
    <br>
    <div class="row container-fluid">
        <div class="col-lg-12">
            <h3 align="center">landscaping works order details</h3>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="alert alert-danger">
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
    <div style="margin-right: 2%; margin-left: 2%;">
    <div class="row">
        <div class="col">
            <h5>Submitted by  <span
                style="color: green">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span> On <h5><span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span></h5>

    
    
        </div>
        <div class="col">
        <h5>  @if($wo->status == 0)Rejected@elseif($wo->status == 1) Accepted @else Processed @endif by <span
                style="color: green">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span></h5>
             <h5 style="color: black">Mobile number: <span style="color: green">{{ $wo['user']->phone }}</span> <br>
              Email: <span style="color:green"> {{ $wo['user']->email }} </span></h5>
        </div>
    </div>
    
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Maintainance Section</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="problem" name="problem"
               aria-describedby="emailHelp" value="{{ $wo->problem_type }}" disabled>
    </div>
    
    @if(empty($wo->room_id) )
        
    
     <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        
        
        <input style="color: black" type="text" required class="form-control" placeholder="location" name="location"
               aria-describedby="emailHelp" value="{{ $wo->location }}" disabled>
    </div>
    
    
    
    
    @else
        
    
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Location</label>
        </div>
        
        
        <input style="color: black" type="text" required class="form-control" placeholder="location" name="location"
               aria-describedby="emailHelp" value="{{ $wo['room']['block']['area']['location']->name }}" disabled>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Area</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="area" name="area" aria-describedby="emailHelp"
               value="{{ $wo['room']['block']['area']->name_of_area }}" disabled>
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
    
    @endif
    
    
    <div class="form-group ">
        <label for="">Details:</label>
        <textarea style="color: black" name="details" required maxlength="100" class="form-control" rows="5"
                  id="comment" disabled>{{ $wo->details }}</textarea>
    </div>
 
   

     <br>
        <h5>Landscaping works order forms.</h5>
        {{-- tabs --}}
        <div class="payment-section-margin">
            <div class="tab">
                <div class="container-fluid">
                    <div class="tab-group row">

                       <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'customer')">INSPECTION FORM</button>
                       <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'assesment')">ASSESSMENT FORM</button>
                        
                        <button  style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'request_transport')">REQUEST TRASPORT
                        </button>
                       
   
                    </div>
                </div>
    



                {{-- INSPECTION tab--}}
                <form method="POST" action="{{ route('work.inspection.landscaping', [$wo->id]) }}">
                    @csrf
                    <div id="customer" class="tabcontent">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Inspection status</p>
                            </div>
                        </div>
                        
                        
                         <div class="form-group">
                            
                            <select class="custom-select" required name="status" style="color: black; width:  700px;">
                                <option selected value="" >Choose...</option>
                               
                                    <option value="Report Before Work">Report Before Work</option>
                                       <option value="Report After Work">Report After Work</option>
                              
                            </select>
                            
                        </div>
                    
                        
                        
                        
                        <p>Inspection description</p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>
                        
                        </br>
                        <p>Inspection date</p>
                        <div class="form-group">
                            <input type="date" style="color: black; width:  700px;"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Select Supervisor of Landscaping</label>
                            <br>
                            <select style="color: black; width:  700px;" required class="custom-select"  name="supervisor" >
                         
                                @foreach($slecc as $slecc)
                                    <option value="{{ $slecc->id }}">{{ $slecc->lname.' '.$slecc->fname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </div>
                </form>
                {{-- end inspection --}}



                {{-- ASSESMENT tab--}}
                <form method="POST" action="{{ route('work.assessment.landscaping', [$wo->id]) }}">
                    @csrf
                    <div id="assesment" class="tabcontent">
                   
                     <div class="form-group">
                            <label>Company name assessed</label>
                            <br>
                            <select style="color: black; width:  700px;" required class="custom-select"  name="company" id="company" >
                         
                                @foreach($company as $comp)
                                    <option value="{{ $comp->id }}">{{ $comp->company_name }}
                                    </option>
                                @endforeach
                            </select>
                      </div>


                       <div class="form-group">
                            <label>Area name</label>
                            <br>
                            <select style="color: black; width:  700px;" required class="custom-select"  name="area" id="carea" >
                         
                                @foreach($carea as $carea)
                                    <option value="{{ $carea->id }}">{{ $carea->cleaning_name}}
                                    </option>
                                @endforeach
                            </select>
                      </div>
      
                       <p>Assessment date</p>
                        <div class="form-group">
                            <input type="date"  style="color: black; width:  700px;" name="assessmment"  min="<?php echo date('Y-m-d', strtotime($wo->created_at)); ?>" class="form-control" required ></input>
                        </div>
                         




                        <p>Activity</p>
                        <div class="form-group">
                            <textarea  style="color: black; width:  700px;" name="activity" required maxlength="500" class="form-control"  rows="5" id="comment" placeholder="Activity..."></textarea>
                        </div>


                        <p>Score</p>
                        <div class="form-group">
                            <input type="number"   style="color: black; width:  700px;" name="score" required maxlength="500" class="form-control"  rows="5" id="comment" placeholder="Score"></input>
                        </div>

                     <!--   <p>Assesor Remark</p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details"  maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        <p>Company Remark</p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details" required maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>

                        <p>Approval Remark</p>
                        <div class="form-group">
                            <textarea   style="color: black; width:  700px;" name="details"  maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div> -->


                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </div>
                </form>
                {{-- end assesment --}}

                
                
                
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
                            <input type="date" style="color: black; width:  700px;" name="date" required class="form-control" min="<?php echo date('Y-m-d'); ?>"  rows="5" id="date"></input>
                        </div>
                        
                          <p>Transport time</p>
                        <div class="form-group">
                            <input type="time" style="color: black; width:  700px;" name="time" required class="form-control"  rows="5" id="time"></input>
                        </div>

                         <p>Transport Details</p>
                        <div class="form-group">
                            <textarea  style="color: black;width: 700px;" name="coments" required maxlength="500" class="form-control"  rows="5" id="comment"></textarea>
                        </div>
                        <br>

                       
                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </div>
                </form>
                {{-- end request_transport form --}}
                
  @endSection
 

    
    