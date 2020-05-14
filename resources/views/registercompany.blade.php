@extends('layouts.land')

@section('title')
Company Registrartion
@endSection

@section('body')



<br>
<div class="container">
@if ($errors->any())
<div class="alert alert-danger" >
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
@if(Session::has('message'))
<div class="alert alert-success" style="margin-top: 6%;">
	<ul>
		<li>{{ Session::get('message') }}</li>
	</ul>
</div>
@endif


<div class="container">
                <h5 style=" text-transform: uppercase;"   id="Add New House" >Register  new comapany</h5>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('company.save') }}" class="col-lg-12">
                    @csrf

                <div align="center">
     
                    
                        <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Company name</label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="name"
                               name="name" value="{{ old('name') }}" placeholder="Enter company name" >
                    </div>



                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" >Type </label>

                        </div>
                   

                        <select required class="custom-select"  name="type" required>
                            <option value="">Choose type...</option>
                            <option value="Cleaning Garden">Cleaning Garden</option>
                            <option value="Other">Other</option>     

                        </select>

  
                    </div>


                 
                    <!--<div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Status </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="status" placeholder="Enter Company Status">
                    </div>-->


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Registration </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="Registration" placeholder="Enter company registration" value="{{ old('Registration') }}" >
                    </div>

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">TIN </label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="type"
                               name="TIN" placeholder="Enter company tin" value="{{ old('TIN') }}" >
                    </div>



                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Contract payment </label>

                        </div>
                        <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  style="color: black" type="number" required class="form-control" id="type"
                               name="payment" placeholder="Enter company payment" value="{{ old('payment') }}" >
                    </div>


                  <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">Start of contract</label>

                        </div>
                        <input style="color: black" type="date" required class="form-control" id="type"
                               name="datecontract" required min="<?php echo date('Y-m-d'); ?>"  value="{{ old('datecontract') }}" >

                 </div>


                  <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">End of contract</label>

                        </div>
                        <input style="color: black" type="date" required class="form-control" id="type"
                               name="duration" required min="<?php echo date('Y-m-d'); ?>" value="{{ old('duration') }}" >

                 </div>


                <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">Area</label>

                        </div>
                                                 <TABLE id="dataTable"  border="1">
                      <TR>
                                <TD><INPUT type="checkbox" name="chk"/></TD>
                                <TD  ><select style="color: black; width:  310px;" required class="custom-select"  name="area[]"  required >
                             <option value="" selected>Choose area... 
                            </option>
                         
                                @foreach($carea as $carea)
                                    <option value="{{ $carea->id }}">{{ $carea->cleaning_name}}
                                    </option>
                                @endforeach
                            </select></TD> 
           
          
                     </TR>
                        </TABLE> 
                      
                 </div>
                 <div style="padding-left: 300px;">
                         <INPUT class="btn badge-primary" type="button" value="Add area" onclick="addRow('dataTable')" />

                         <INPUT class="btn btn-danger" type="button" value="remove" onclick="deleteRow('dataTable')" />
                 </div>       

                         <br>
                         <br>
             
                    
  




              
            <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a class="btn btn-danger" href="/cleaningcompany" role="button">Cancel </a>
                </div>
                </form>
            </div>

       



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








@endSection


