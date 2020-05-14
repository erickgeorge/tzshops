@extends('layouts.land')

@section('title')
    Assessment form
    @endSection

@section('body')

<?php 
    use App\User;
 
 

 ?>

 <style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

    


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
            <h5 align="center" style="text-transform: uppercase;">assessment form details</h5>
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
 



  @foreach($assessmmentcompany as $company)

    <br>
     <div class="row">
    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Company name</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$company['companyname']->company_name}} " 
               aria-describedby="emailHelp" value="" disabled>
    </div>
    
  
        
    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Cleaning area name</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$company['areaname']->cleaning_name}}" 
               aria-describedby="emailHelp" value="" disabled>
    </div>
        
    </div>

    <br>

         <div class="row">
    <div class="input-group mb-3 col">
        <div class="input-group-prepend">
            <label class="input-group-text">Assessment date</label>
        </div>
        <input style="color: black" type="text" required class="form-control" placeholder="{{$company->assessment_month}}"
               aria-describedby="emailHelp" value="" disabled>
    </div>
    
  
        
    <div class="input-group mb-3 col">
        
    </div>
        
    </div>

    @endforeach

<br>

 <!-- begin of assessment activity -->

<p><u>ACTIVITY FORM</u></p>

 @if(count($crosscheckassessmmentactivity) > 0)

 <table style="width:100%">
  <tr >
    <thead style="color: white;">
    <th style="width: 300px"><b>Activity</b></th>
     <th style="width: 100px"><b>Percentage(%)</b></th>
    <th style="width: 100px"><b>Score(%)</b></th>
     <th style="width: 300px"><b>Remark</b></th>
     </thead>
     


  </tr>
  <?php  
   $sum = 0;
   $summ = 0;
   ?>
  @foreach($crosscheckassessmmentactivity as $assesment)
  <?php   $sum += $assesment->percentage;  $summ += $assesment->score;?>
  <tbody>
  <tr>
   <td>{{$assesment->activity}}</td>
   <td align="center">{{$assesment->percentage}}</td>
    <td align="center">{{$assesment->score}}</td>
    <td>{{$assesment->remark}}</td>
 </tr>
 </tbody>
  @endforeach
  <th><b>Tottal</b></th>
  <td align="center"><b><?php echo $sum ?>%</b></td>
  <td align="center"><b><?php echo $summ ?>%</b></td>
  </table>
   <br>


  <p><u>Payment description:  <?php $pay = $company['companyname']->payment; echo number_format("$pay"); ?> Tshs</u><br>
  
  <u>According to the total score of <?php echo $summ ?>% on this month {{$company['companyname']->company_name}} should be payed: <?php $erickpnd = $summ *  $company['companyname']->payment * 0.01; echo number_format("$erickpnd"); ?> Tshs</u></p>

  @if(($assesment->status == 4)||($assesment->status == 2)||($assesment->status == 3)||($assesment->status == 10)||($assesment->status == 11)||($assesment->status == 12))


  @if(($assesment->status == 10))
  <b>Rejected by Head PPU : {{ $assesment['rejection']->fname .' ' . $assesment['rejection']->lname }}  on: {{ $assesment->rejected_on }}     <td> <a onclick="myfunc5('{{$assesment->reason}}')"><span data-toggle="modal" data-target="#viewreason"
                                                                         class="badge badge-danger">View Reason</span></a></td></b><br>@endif


  @if($assesment->status == 11)
  <br>
  <b>Rejected by Estates Director : {{ $assesment['rejectionestate']->fname .' ' . $assesment['rejectionestate']->lname }}  on: {{ $assesment->rejected_on }}     <td> <a onclick="myfunc6('{{$assesment->reasonestate}}')"><span data-toggle="modal" data-target="#viewreasonestate"
                                                                         class="badge badge-danger">View Reason</span></a></td></b><br>@endif    
  @if($assesment->status == 12)
  <br>
  <b>Rejected by DVC Admin : {{ $assesment['rejectiondvc']->fname .' ' . $assesment['rejectiondvc']->lname }}  on: {{ $assesment->rejected_on }}     <td> <a onclick="myfunc7('{{$assesment->reasondvc}}')"><span data-toggle="modal" data-target="#viewreasondvc"
                                                                         class="badge badge-danger">View Reason</span></a></td></b><br>@endif


  @endif


  <br>






  @if($assesment->status == 1)
  <b>status:</b><b style="color: blue;">  Not Approved</b>
  @elseif(($assesment->status == 2)||($assesment->status == 3))
  <b>Approved by Head PPU : {{ $assesment['approval']->fname .' ' . $assesment['approval']->lname }} on: {{ $assesment->accepted_on }}</b>
  @endif
  <br>
  
  @if(auth()->user()->type == 'Head PPU')
  @if($assesment->status == 1)
  <b style="padding-left: 800px;">Approve <a href="{{route('approveassessment', [$assesment->assessment_id])}}" title="Approve assessment form  "><i style="color: blue;" class="far fa-check-circle"></i> </a></b> <br>
     <b style="padding-left: 800px;">Reject <a data-toggle="modal" data-target="#rejectppu"
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Reject assessment form with reason "><i  class="fas fa-times-circle" style="color: red" ></i></a> </b>
  @endif
  @endif






  @if(auth()->user()->type == 'Estates Director')
   @if($assesment->status == 2)
  <b style="padding-left: 800px;">Approve<a href="{{route('approveassessmentforpayment', [$assesment->assessment_id])}}" title="Approve assessment form "><i style="color: blue;" class="far fa-check-circle"></i> </a></b><br> <b style="padding-left: 800px;">Reject <a data-toggle="modal" data-target="#rejectestate"
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Reject assessment form with reason "><i  class="fas fa-times-circle" style="color: red" ></i></a> </b>
   @endif
   @endif
  
  @if($assesment->status == 3)
  <b>Approved by Estate Director : {{ $assesment['approvalpayment']->fname .' ' . $assesment['approvalpayment']->lname }}  on: {{ $assesment->approved_on }}</b>
  <br>
 @endif 

  
 
     @if(auth()->user()->type == 'Supervisor Landscaping')
   @if($assesment->status == 1)
  <!--<b style="padding-left: 800px;">Update payment <a data-toggle="modal" data-target="#payment"
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Update payment"><i class="fas fa-edit"></i></a> </b>-->
   @endif
   @endif

<br>
     @if(auth()->user()->type == 'DVC Admin')
  @if($assesment->status == 3)
  
  <b style="padding-left: 750px;">Approve<a href="{{route('approveassessmentforpayment', [$assesment->assessment_id])}}" title="Approve assessment form "><i style="color: blue;" class="far fa-check-circle"></i> </a></b><br> <b style="padding-left: 750px;">Reject <a data-toggle="modal" data-target="#rejectdvc"
                                                            style="color: green;" 
                                           data-toggle="tooltip" title="Reject assessment form with reason "><i  class="fas fa-times-circle" style="color: red" ></i></a> </b>
                                           <b style="padding-left: 750px;">Print  form <a href="{{route('assessmentpdfform', [$assesment->assessment_id])}}" title="Print assessment from"><i style="color: blue;" class="far fa-file"></i> </a></b>

  @endif
  @endif
  
  
  
    <!--Update Payment-->
    <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>UPDATE PAYMENT</b></h5>
                   

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <form method="POST" action="{{route('updatepayment', [$assesment->assessment_id])}}">
                             @csrf                   
                        
                        <input style="color: black" type="number" required class="form-control"   maxlength = "30"  
                               name="payment" placeholder="Update Payment ..." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                               <br>


                               <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                    
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




    <!--reject by Head PPU-->
    <div class="modal fade" id="rejectppu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>REJECT ASSESSMENT FORM</b></h5>
                   

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <form method="POST" action="{{route('rejectwithreasonassessment', [$assesment->assessment_id])}}">
                             @csrf                   
                        
                        <textarea style="color: black" type="number" required class="form-control"     
                               name="reason" placeholder="Give reason ..."  required></textarea> 
                               <br>


                               <button type="submit" class="btn btn-danger">Reject</button>
                    </form>

                    
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



     <!-- Modal for view Reason -->
    <div class="modal fade" id="viewreason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red;"><b></b> Rejection reason from Head PPU .</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h5 id="reason"><b> </b></h5>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




    <!--reject by ESTATE DIRECTOR-->
    <div class="modal fade" id="rejectestate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>REJECT ASSESSMENT FORM</b></h5>
                   

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <form method="POST" action="{{route('rejectwithreasonassessmentestate', [$assesment->assessment_id])}}">
                             @csrf                   
                        
                        <textarea style="color: black" type="number" required class="form-control"     
                               name="reason" placeholder="Give reason ..."  required></textarea> 
                               <br>


                               <button type="submit" class="btn btn-danger">Reject</button>
                    </form>

                    
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


     <!-- Modal for view Reason ESTATE-->
    <div class="modal fade" id="viewreasonestate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red;"><b></b> Rejection reason from Estate Director.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h5 id="resonestates"><b> </b></h5>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>



    <!--reject by ESTATE DIRECTOR-->
    <div class="modal fade" id="rejectdvc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center" style="color: black"><b></b>REJECT ASSESSMENT FORM</b></h5>
                   

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <form method="POST" action="{{route('rejectwithreasonassessmentdvc', [$assesment->assessment_id])}}">
                             @csrf                   
                        
                        <textarea style="color: black" type="number" required class="form-control"     
                               name="reason" placeholder="Give reason ..."  required></textarea> 
                               <br>


                               <button type="submit" class="btn btn-danger">Reject</button>
                    </form>

                    
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


     <!-- Modal for view Reason ESTATE-->
    <div class="modal fade" id="viewreasondvc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red;"><b></b> Rejection reason from DVC Admin.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h5 id="resondvc"><b> </b></h5>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




 @if(auth()->user()->type == 'Supervisor Landscaping')
  @if(($assesment->status == 10)||($assesment->status == 11)||($assesment->status == 12))


   <div class="tab">

  <button class="tablinks" onclick="openCity(event, 'activity')">Preview and sent again</button>

  </div>
  



<div id="activity" class="tabcontent">

     <table>
      <tr>
         <thead style="color: white;">
        <th style="width: 310px">Activity</th>
        <th style="width: 155px">Percentage(%)</th>
        <th style="width: 155px">Score(%)</th>
        <th style="width: 310px">Remark</th>
      </thead>
      </tr>
     </table>

     <table>

     <form method="POST" action="{{ route('edited.assessment.activity.landscaping', [$company->id ]) }}">
                    @csrf

  @foreach($crosscheckassessmmentactivity as $assesment)

  <tbody>
  <tr>

      <TD  ><input  style="width: 300px;" class="form-control" type="text" name="activity[]" placeholder="activity..." value="{{$assesment->activity}}" required="required" ></TD> 
           
      <TD><input style="width: 150px;" oninput="totalitem()"  id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="{{$assesment->percentage}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="{{$assesment->percentage}}" required="required">    </TD> 
              
      <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="{{$assesment->score}}" value="{{$assesment->score}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required" ></TD> 
                  
       <TD><input  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="{{$assesment->remark}}" value="{{$assesment->remark}}" ></TD> 



 </tr>


 </tbody>

  @endforeach
 
  </table>
  <br>




     <button id="bt" type="submit" class="btn btn-primary">Save</button>
                 <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-danger">Cancel</button></a>




</form>



 </div>



  @endif
  @endif





 @else
     <br>
  <p style="color:blue;">No assessment activity form submitted yet</p>
  @endif
    <br><hr>



    
     
     <br>
        @if(auth()->user()->type == 'Supervisor Landscaping')
  @if(count($crosscheckassessmmentactivity) == 0)
    
    
  @if(count($assessmmentactivity) == 0)

   <div class="tab">

  <button class="tablinks" onclick="openCity(event, 'activity')">Acticity form</button>

  </div>



<div id="activity" class="tabcontent">
  </br>


     <table>
    
      <tr>
     <thead style="color: white;">
        <th style="width: 19px"></th>
        <th style="width: 310px">Activity</th>
        <th style="width: 160px">Percentage(%)</th>
        <th style="width: 150px">Score(%)</th>
        <th style="width: 310px">Remark</th>
     </thead>
      </tr>

     </table>

     <form method="POST" action="{{ route('work.assessment.activity.landscaping', [$company->id]) }}">
                    @csrf


    <TABLE id="dataTable" width="350px" border="1">
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  value="To cut grass, rake and maintain clean the road leading to the dumping site" style="width: 300px; height: 60px;" class="form-control" type="text" name="activity[]"  placeholder ="activity..." required="required"  ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   value="10">    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock"  min="0" max="6" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>

                <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px; " class="form-control" type="text" name="activity[]"  value ="To provide full labour , materials , tools and protective gears for such works "  required="required"  placeholder ="activity..." ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"  value="10" >    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>


                <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px;" class="form-control" type="text" name="activity[]" value="To ensure no waste is dumped arround the road leading to the dumping site "  required="required"  placeholder ="activity..." ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"  value="15" >    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>

                <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px; " class="form-control" type="text" name="activity[]" value="Push all the waste materials disposed at the site to the required destination "  required="required"  placeholder ="activity..." ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"  value="20">    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>

                <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px; " class="form-control" type="text" name="activity[]" value="Proper reporting and ensure that no unauthorized vehicles dispose waste to the dumping site"  required="required"  placeholder ="activity..."  ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   value="10" >    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>

                <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px; " class="form-control" type="text" name="activity[]" value="Ensure the damping site is maintained according to municiple waste management regurations"  required="required"  placeholder ="activity..."  ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"  value="10" >    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>

                <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px; " class="form-control" type="text" name="activity[]" value="Grade and level the road leading to the dumping site including dumping site to ground level when requested  "  required="required"  placeholder ="activity..." ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"  value="10" >    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>

                <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px;" class="form-control" type="text" name="activity[]" value="Adequate supervision "  required="required" placeholder ="activity..." ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   value="10" >    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><input  style="width: 300px; height: 60px; " class="form-control" type="text" name="activity[]" value="Provision and wearing uniforms and identity cards"  required="required" placeholder ="activity..." ></TD> 
           
            <TD><input style="width: 150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"  value="5">    </TD> 
              
            <TD><input style="width: 150px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="Score" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required" ></TD> 
                  
           <TD><textarea  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="Remark"  ></textarea></TD> 
            
        </TR>

       
             
     
    </TABLE>

    <INPUT class="btn badge-primary" type="button" value="Add Row" onclick="addRow('dataTable')" />

    <INPUT class="btn badge-danger" type="button" value="Delete Row" onclick="deleteRow('dataTable')" />
    <br>
    <br>

     <button id="bt" type="submit" class="btn btn-primary">Save</button>
                 <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-danger">Cancel</button></a>

</form>



 </div>
 @else

   <div class="tab">

  <button class="tablinks" onclick="openCity(event, 'activity')">Crosscheck Acticity form</button>

  </div>
  



<div id="activity" class="tabcontent">

     <table>
      <tr>
         <thead style="color: white;">
        <th style="width: 410px">Activity</th>
        <th style="width: 110px">Percentage(%)</th>
        <th style="width: 100px">Score(%)</th>
        <th style="width: 300px">Remark</th>
      </thead>
      </tr>
     </table>

     <table>

     <form method="POST" action="{{ route('croscheck.assessment.activity.landscaping', [$company->id ]) }}">
                    @csrf

   <?php  
   $summ = 0;
   $summm = 0;
   ?>
  @foreach($assessmmentactivity as $assesment)
   <?php   $summ += $assesment->percentage;  $summm += $assesment->score;?>

  <tbody>
  <tr>

      <TD  ><input  style="width: 400px;" class="form-control" type="text" name="activity[]" placeholder="activity..." value="{{$assesment->activity}}" required="required" ></TD> 
           
      <TD><input style="width: 100px;" oninput="totalitem()"  id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="{{$assesment->percentage}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="{{$assesment->percentage}}" required="required">    </TD> 
              
      <TD><input style="width: 100px;" class="form-control" type="number" id="tstock" name="score[]" placeholder="{{$assesment->score}}" value="{{$assesment->score}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required" ></TD> 
                  
       <TD><input  style="width: 300px;" class="form-control" type="text" name="remark[]" placeholder="{{$assesment->remark}}" value="{{$assesment->remark}}" ></TD> 



 </tr>
 </tbody>
  @endforeach

 <th><b>Tottal</b></th>
  <td ><b><?php echo $summ ?>%</b></td>
  <td ><b><?php echo $summm ?>%</b></td>

 
 
  </table>



    <br>
    <br>

     <button id="bt" type="submit" class="btn btn-primary">Save</button>
                 <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-danger">Cancel</button></a>




</form>



 </div>

 @endif
 @endif
 @endif

 <br><br>








<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>


<SCRIPT language="javascript">
        function addRow(tableID) {
             
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;



            for(var i=0; i<colCount; i++)
             {

                var newcell = row.insertCell(i);
                 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;

                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;


                }

                  

            }

           
        }



        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>


        <script type="text/javascript">

   function myfunc5(x) {
            document.getElementById("reason").innerHTML = x;
        }

         function myfunc6(x) {
            document.getElementById("resonestates").innerHTML = x;  
  }  


        function myfunc7(x) {
            document.getElementById("resondvc").innerHTML = x;  
  }
   </script>


      <script>
function totalitem() {
  var x = 0;
  var y = document.getElementById("istock").value;
  var z  = parseInt(x) + parseInt(y);
  document.getElementById("tstock").value=z;
  document.getElementById("tstock").innerHTML = z;
}
</script>




    
    
    

    


                
  @endSection

