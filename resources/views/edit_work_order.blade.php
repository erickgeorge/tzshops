@extends('layouts.master')

@section('title')
    work order
    @endSection

@section('body')
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
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center">Work order details</h3>
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
    <h5>This work order is submitted by  <span
                style="color: green">{{ $wo['user']->fname.' '.$wo['user']->lname }}</span>  also has been processed by  <span
                style="color: green">{{ $wo['hos']->fname.' '.$wo['hos']->lname }}</span> &nbsp;<br>It Has been submitted on <span style="color: green">{{ date('F d Y', strtotime($wo->created_at)) }}</span></h5>
    <h5 style="color: black">Contacts: {{ $wo['user']->phone }} ,&nbsp;{{ $wo['user']->email }}</h5>
    <br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type of a problem</label>
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
            <!--<div class="form-group ">
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
            </div>-->
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/home" class="btn btn-danger">Cancel</a>
            
                </form>
                <!-- <a href="/workorder/procurement/?id={{$wo->id}}" class="btn btn-dark">Procurement Request</a> -->
    
        <br>
        <h4>Work order forms.</h4>
        {{-- tabs --}}
        <div class="payment-section-margin">
            <div class="tab">
                <div class="container-fluid">
                    <div class="tab-group row">
                        <button required class="tablinks col-md-3" onclick="openTab(event, 'assigntechnician')"><b style="color:black">ASSIGN TECHNICIAN FOR WORK</b></button>
                        <button  style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'request_transport')">REQUEST TRASPORT
                        </button>
                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'material_request')" id="defaultOpen">MATERIAL REQUEST FORM</button>
                        
                        <!--<button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'material_request_store')" id="defaultOpen">MATERIAL REQUEST FROM STORE</button>-->
                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'crosscheck_material_requested')" id="defaultOpen">CROSS CHECK MATERIAL REQUESTED</button>
                        
                        <button style="color:black" class="tablinks col-md-2" onclick="openTab(event, 'customer')">INSPECTION FORMS</button>
                        
                        
                    </div>
                </div>





            {{-- ASSIGN TECHNICIAN tab--}}
               
                    @csrf
                    <div id="assigntechnician" class="tabcontent">
                        <?php
                        use App\WorkOrderStaff;
                        use App\Technician;
                        $checktech = WorkOrderStaff::where('work_order_id',$wo->id)->get();
                        $i = 1;
                         ?>
                         @if($checktech)

                         <?php $named = Technician::get(); ?>
                         <div class="row">
                            <div class="col-lg-12" style="font-weight: bold; color: black;">
                            Technicians Assigned for this work order:
                            </div><br><br>
                         @foreach($checktech as $fetchtech)
                         @foreach($named as $names)
                         @if($fetchtech->staff_id == $names->id)
                         <div class="col-lg-12"><b style="font-weight: bold; color: black;">{{ $i }}. {{ $names->fname }} {{ $names->lname }}<?php $i++; ?></b></div>
                         <br>
                         @endif
                         @endforeach
                         @endforeach
                     </div><br><br>

                         @else
                         @endif
                        <div class="row">
                            <div class="col-md-6">
                                <p>Assign Technician for this work-order</p>
                            </div>
                        </div>
                        <div >
                        <p id="alltechdetails">  </p>
                        
                        
                        
                        </div>
                        
                        
                       
                        <form method="POST" action="{{ route('work.assigntechnician', [$wo->id]) }}">
                        @csrf
                          <div class="form-group">
                          <!-- <input  id="technician_work"  type="text" hidden> </input>  -->
                            <select   id="techid" required class="custom-select"  name="technician_work" style="width: 700px;">
                               
                               
                               
                               
                               
                               
                               <?php 
                $p=-1;
      ?>
                               
                                @foreach($techs as $tech)
                                <?php
                                
                                $wo_technician_count = WorkOrderStaff::
                     select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                     ->where('status',0)
                     ->where('staff_id',$tech->id)
                     ->groupBy('staff_id')
                     ->first();
                     
                               ?>
                               @if(empty($wo_technician_count->total_wo))
                                   <?php $t=0;?>
                               
                               @else
                                    <?php $t=$wo_technician_count->total_wo;?>
                                
                                @endif
                               
                              <?php
                             $p++;
                              $name[$p]=$tech->fname.' '.$tech->lname;
                              $ident[$p]=$tech->id;
                              $cwo[$p]=$t;
                              
                              ?>
                              
                              
                              
                                    
                                @endforeach
                                <?php
                                for($i=0;$i<=$p-1;$i++){
                                    for($j=$i+1 ;$j<=$p;$j++){
                                        if($cwo[$i]>$cwo[$j]){
                                            $t1=$name[$i];
                                            $t2=$ident[$i];
                                            $t3=$cwo[$i];
                                            
                                            $name[$i]=$name[$j];
                                            $ident[$i]=$ident[$j];
                                            $cwo[$i]=$cwo[$j];
                                            
                                            
                                            $name[$j]=$t1;
                                            $ident[$j]=$t2;
                                            $cwo[$j]=$t3;
                                }}}
                                
                                    for($x=0;$x<=$p;$x++){      
                                    ?><option  value="{{ $ident[$x] }}"> {{$name[$x].'        - assigned ('.$cwo[$x].') Workorders'}} </option>
                                    <?php }  ?>
                                            
                                
                            </select>
                        </div>
                         
                        <button  type="submit" class="btn btn-primary bg-primary">Assign Technician</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </form>
                        
                        
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
                            <input type="date" style="color: black; width:  700px;" max="<?php echo date('Y-m-d'); ?>"  name="inspectiondate" required class="form-control"  rows="5" id="date"></input>
                        </div>
                        <div class="form-group">
                            <label>Select Technician on Duty</label>
                            <br>
                            <select style="color: black; width:  700px;" required class="custom-select"  name="technician">
                                <option  selected value="" >Choose...</option>
                                
                                
                                
                                
                                $staff= WorkOrderStaff::where('work_order_id',$wo->id)->where('status',1)->get();
                        
                                
                                
                                @foreach($staff as $tech)
                                    <option value="{{ $tech->staff_id }}">{{ $tech['technician_assigned']->lname.' '.$tech['technician_assigned']->fname }}</option>
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
                
                
                
                
                {{-- material_request tab--}}
                
                 <div id="material_request" class="tabcontent">
                <form method="POST"  action="{{ route('work.materialadd', [$wo->id]) }}" >
                    @csrf
                   
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
                           
                            <select  required class="custom-select"  id="materialreq" name="1" style="width: 700px">
                                <option   selected value="" >Choose...</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name.', Brand:('.$material->description.') ,Value:( '.$material->brand.' ) ,Type:( '.$material->type.' )' }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        
                         <p>Quantity</p>
                        <div class="form-group">
                            <input type="number" min="1"  style="color: black; width: 700px" name="2" required class="form-control"  rows="5" id="2"></input>
                        </div>
                        
                        
                        <div id="newmaterial" style="width: 700px">

                        </div>
                       <input  type="hidden" id="totalmaterials" value="2"  name="totalmaterials" ></input>
                         <button style="background-color: blue; color: white" onclick="newmaterial()" class="btn btn-success">New Material</button>
                         <br> <br>
                      
                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save Material</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                    </form>
                    

                       
                 </div>
                {{-- end material_request  --}}
                
                
                
                
                


            
                
     {{-- crosscheck material--}}
                <div class="container">
                 <div id="crosscheck_material_requested" class="tabcontent">
                
                        <?php
                        
                        use App\WorkOrderMaterial;
                        $wo_materials= WorkOrderMaterial::where('work_order_id',$wo->id)->where('status',20)->get();
                        
                        ?>
                         @if(COUNT($wo_materials)!=0)
                        <table class="table table-striped" style="width:100%">
  <tr>
     <th>No</th>
    <th>Material Name</th>
    <th>Brand Name</th>
    <th>Type</th>
     <th>Quantity Requested</th>
      <th>Action</th>

  </tr>

  <?php $i=1; 
 

  ?>
    @foreach($wo_materials as $matform)
    
  <tr>
    <td>{{$i++}}</td>
    <td>{{$matform['material']->name }}</td>
     <td>{{$matform['material']->description }}</td>
     <td>{{$matform['material']->type }}</td>
     <td>{{$matform->quantity }}</td>
      <td>


                            <div class="row">


                                    <a style="color: green;"
                                       onclick="myfunc1( '{{ $matform->id }}','{{ $matform->quantity }}', '{{$matform->name}}')"
                                       data-toggle="modal" data-target="#exampleModali" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Material from the list? ')"
                                          action="{{ route('material.delete', [$matform->id]) }}">
                                        {{csrf_field()}}


                                        <button style="width:20px;height:20px;padding:0px;color:red" type="submit"
                                                data-toggle="tooltip" title="Delete"><a style="color: red;"
                                                                                        data-toggle="tooltip"><i
                                                        class="fas fa-trash-alt"></i></a>
                                        </button>
                                    </form>
                                </div>

                         </td>
  </tr>   
    @endforeach
</table>   
    <button class="btn btn-success" style="color: white" > <a  href="/send/material_again/{{$wo->id}}"   > REQUEST MATERIAL </a></button> 


</div>

</div>

<!--modal for edit --->
     <div class="modal fade" id="exampleModali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div >
         <div class="modal-dialog" style="padding-right: 655px; background-color: white" role="document">
         <div class="modal-content">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-left:600px; ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                    <div class="modal-header ">
                     <div>
                        <h5  style="width: 600px;" id="exampleModalLabel">Edit Material</h5>
                        <hr>
                    </div>  
                  </div>
                <div class="modal-body">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />




                      <form method="POST" action="edit/Material_hos/{{ $matform->work_order_id }}" class="col-md-6">
                        @csrf
                       


                        <div class="form-group">
                            <select  required class="custom-select"  id="materialedit" name="material" style="width: 550px">
                                <option   selected value="" >Choose...</option>
                                @foreach($materials as $material)
                                   <option value="{{ $material->id }}">{{ $material->name.', Brand:('.$material->description.') ,Value:( '.$material->brand.' ) ,Type:( '.$material->type.' )' }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    
                         <div class="form-group">
                            <label for="name_of_house">Quantity </label>
                            <input style="color: black;width:550px" type="number" required class="form-control"      id="editmaterial"
                                   name="quantity" placeholder="Enter quantity again">
                            <input id="edit_mat" name="edit_mat" hidden>
                         </div>
                                                    <div> 
                                                       <button style="background-color: darkgreen; color: white; width: 205px;" type="submit" class="btn btn-success">Save
                                                       </button>
                                                    </div>
                                         
                                            </form>
                  
                                                       <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


     <script type="text/javascript">

      $("#materialedit").select2({
            placeholder: "Choose materia..",
            allowClear: true
        });
     </script>

   
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        </div>
    </div>
     @endif

    <!--end modal for edit --->



                {{-- end material_request  --}}
                
                
                

                {{-- Purchasing order tab --}}
                
                <div id="purchasingorder" class="tabcontent">
                <form method="POST"  action="{{ route('work.purchasingorder', [$wo->id]) }}" >
                    @csrf
                    <h4>Purchasing Order Request</h4>
                   <div class="form-group">
                           
                            <select onchange="stock();" required class="custom-select"  id="materialreq" name="1">
                                <option   selected value="" >Choose...</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name.' '.$material->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        
                         <p>Quantity</p>
                        <div class="form-group">
                            <input type="number" min="1"  style="color: black" name="2" required class="form-control"  rows="5" id="2"></input>
                        </div>
                        
                        
                        <div id="newmaterialproc" >
                        
                        
                        </div>
                    <input type="hidden" id="totalmaterials" value="2"  name="totalmaterials" ></input>
                      
                        <button style="background-color: darkgreen; color: white" type="submit" class="btn btn-success">Save Material</button>
                        <a href="#" onclick="closeTab()"><button type="button" style="background-color: #212529; color: white" class="btn btn-dark">Cancel</button></a>
                   
                </form>
                    <button style="background-color: blue; color: white" onclick="newmaterialproc()" class="btn btn-success">New Material</button>
                       
                 
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
    
</div>
  @endSection
     
     <?php  
                        $mat= Material::get();
                        $matvalue= Material::get();
                        ?>
     <script type="text/javascript" language="javascript">
    var array = new Array();
     var arrayvalue = new Array();
    <?php foreach($mat as $key){ ?>
        array.push('<?php echo $key->name.', Brand:('.$key->description.') ,Value:( '.$key->brand.' ) ,Type:( '.$key->type.' )' ; ?>');
    <?php } ?>
    
    
    <?php foreach($mat as $key ){ ?>
        arrayvalue.push('<?php echo $key->id ; ?>');
    <?php } ?>
</script>
    
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
      
      
     
      function newmaterial(){
         
         total=total+1;
        
         
         var myDiv = document.getElementById("newmaterial");
         
         
         var node = document.createElement("label");
  var textnode = document.createTextNode("Material");
  node.appendChild(textnode);
myDiv.appendChild(node);
         
         
         

//Create array of options to be added
//var array = ["Volvo","Saab","Mercades","Audi"];

//Create and append select list
var selectList = document.createElement("select");
selectList.className = "custom-select";
selectList.required = true;


selectList.name = total;

myDiv.appendChild(selectList);

//Create and append the options
 var option = document.createElement("option");
   
    option.text = 'Choose ...';
     option.value = '';
     
    selectList.appendChild(option);
    
for (var i = 0; i < array.length; i++) {
    var option = document.createElement("option");
    option.value = arrayvalue[i];
    option.text = array[i];
    selectList.appendChild(option);
}

 var node = document.createElement("label");
  var textnode = document.createTextNode("Quantity");
  node.appendChild(textnode);
  myDiv.appendChild(node);


 var input = document.createElement("input");
         input.setAttribute('type', 'number');
         input.min=1;
         input.required = true;
         
         total=total+1;
        
         input.name = total;
         input.className = "form-control";
         var parent = document.getElementById("newmaterial");
         
         
        parent.appendChild(input);
         
         
         
         var node = document.createElement("br");

myDiv.appendChild(node);

document.getElementById("totalmaterials").value=total;
         
         
     }
      
      
      
      
      
      
    // getTechnician(5);



       function myfunc1(U, V, W) {


            document.getElementById("edit_mat").value = U;

            document.getElementById("editmaterial").value = V;

             document.getElementById("material").value = W;

       }
    </script>

    <script type="text/javascript">

      $("#newmaterial").select2({
            placeholder: "Choose Technician...",
            allowClear: true
        });
    </script>


    
    