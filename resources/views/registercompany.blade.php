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
                <h5 style=" text-transform: uppercase;"   id="Add New House" >register New tender</h5>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('company.save') }}" class="col-lg-12">
                    @csrf

                <div align="center">


<div class="jumbotron" style="width: 500px;">
     <table>
    
      <tr>
     <thead style="color: white;">
        <th style="width: 25px"></th>
        <th style="width: 250px">Area</th>
        <th style="width: 250px">Assessment sheet</th>
     
     </thead>
      </tr>

     </table>


         
       <TABLE id="dataTable" width="350px" border="1">
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  >
                          
                            <select style="color: black; width:  200px;" required class="custom-select"  name="area[]"  required >
                             <option value="" selected>Choose area... 
                            </option>
                         
                                @foreach($carea as $carea)
                                    <option value="{{ $carea->id }}">{{ $carea->cleaning_name}}
                                    </option>
                                @endforeach
                            </select>      
                      
              </TD> 
           
            <TD>
                         <select style="color: black; width:  200px;" required class="custom-select"  name="sheets[]"  required >
                             <option value="" selected>Choose assessment sheet... 
                            </option>
                         
                                @foreach($sheets as $sheet)
                                  @if($sheet->percentage == 100)
                                    <option value="{{$sheet->name }}">{{ $sheet->name}}
                                    </option>

                                  @endif  
                                @endforeach
                        </select> 
           </TD> 
              
          
        </TR>
     </TABLE>

    <div style="padding-left: 300px;">  <INPUT  class="btn btn-outline-primary" type="button" value="Add" onclick="addRow('dataTable')" />

    <INPUT  id="deleterowbutton" style="display: none;" class="btn btn-outline-danger" type="button" value="Delete " onclick="deleteRow('dataTable')" /></div>

  </div>

                
                     
                 
                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Company name</label>

                        </div>
                          

                           <select  class="custom-select"  name="companyid" id="companyi"  onchange="getcompany()" required>
                             <option value="" selected>Choose company... 
                            </option>
                         
                                @foreach($companyall as $carea)
                                    <option value="{{ $carea->id }}">{{ $carea->company_name}}
                                    </option>
                                @endforeach
                          </select> 
                     </div>


                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Tender number</label>

                        </div>
                          

                           <select   class="custom-select"  name="tendern" id="tendernumber" required  >
                             <option value="" selected>Choose tender number... 
                            </option>
                         
                               
                          </select> 
                     </div>



 

                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate">Contract payment </label>

                        </div>
                        <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  style="color: black" type="number" required class="form-control" id="type"
                               name="payment" placeholder="Enter monthly payment" value="{{ old('payment') }}" >
                    </div>


                  <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">Start of contract</label>

                        </div>
                       
                        <input style="color: black" type="date" required class="form-control" id="type"
                               name="datecontract" required min="<?php echo date('Y-m-d', strtotime("-1 month")); ?>" max="<?php echo date('Y-m-d'); ?>" value="{{ old('datecontract') }}" >

                 </div>


                  <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">Contract Duration</label>

                        </div>
                       <!-- <input style="color: black" type="date" required class="form-control" id="type"
                               name="duration" required min="<?php //echo date('Y-m-d' , strtotime("+1 //year")); ?>" value="{{ old('duration') }}" >-->



                       <select   class="custom-select"  name="duration" id="tendernumber" required  >
                            <option value="" selected>Choose contract duration...</option>
                             <option value="1">1 Year</option>
                             <option value="2">2 Years</option>
                             <option value="3">3 Years</option>
                             <option value="4">4 Years</option>
                             <option value="5">5 Years</option>
                             <option value="6">6 Years</option>
                             <option value="7">7 Years</option>
                             <option value="8">8 Years</option>
                             <option value="9">9 Years </option>
                             <option value="10">10 Years</option>
                         
                               
                      </select> 

                 </div>


                

                         <br>
                         <br>
             
                    
  




              
            <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a class="btn btn-danger" href="/tender" role="button">Cancel </a>
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

              
               if(rowCount = 1) {
                      
                          document.getElementById('deleterowbutton').style.display='inline-block';



                    }

                


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


                        if(rowCount <= 2) {
                       

                        document.getElementById('deleterowbutton').style.display='none';
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
var selectedcompany = null;

function getcompany() {
    selectedcompany = document.getElementById('companyi').value;

    $.ajax({
        method: 'GET',
        url: 'companytender/',
        data: {id: selectedcompany}
    })
        .done(function(msg){
            var object = JSON.parse(JSON.stringify(msg['companytender']));
            $('#tendernumber').empty();
      
      
      var option = document.createElement('option');
      option.innerHTML = 'Choose...';
      option.value = '';
      document.getElementById('tendernumber').appendChild(option);
      
      
            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].tender;
                option.value = object[i].tender;
                document.getElementById('tendernumber').appendChild(option);
            }
        });
}

</script>








@endSection


