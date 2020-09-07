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
                <h5 style=" text-transform: capitalize;"   id="Add New House" >Register new company</h5>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>
          
                <form method="POST" action="{{ route('company.save.renew') }}" class="col-lg-12">
                    @csrf

                <div align="center">
     
                    
                    <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate"><b>Company name</b></label>

                        </div>
                        <input style="color: black;" type="text" required class="form-control" id="name"
                               name="company_name"  placeholder="Enter company name"  >
                    </div>



             
               <!-- <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">
                            
                          <label style="width:150px;" class="input-group-text" for="directorate">Area</label>

                        </div>
                                            
                     <select style="color: black; width:  310px;" required class="custom-select"  name="area"  required >
                             <option value="" selected>Choose area... 
                            </option>
                         
                                @foreach($carea as $carea)
                                    <option value="{{ $carea->id }}">{{ $carea->cleaning_name}}
                                    </option>
                                @endforeach
                            </select>
           
          
                    
                      
                 </div>-->




                    <div class="input-group mb-3 col-lg-6" >
                        <div class="input-group-prepend">
                            
                            <label style="width:150px;" class="input-group-text" for="directorate">Type </label>
                        </div>
                         <select required style="color: black;" class="custom-select" name="type" >
                                
                                 @if(auth()->user()->type == 'Supervisor Landscaping')
                                  <option value="Exterior">Exterior</option>
                                  @endif

                                    @if((auth()->user()->type == 'Administrative officer')||(auth()->user()->type == 'USAB'))
                                   <option selected value="Interior">Interior</option>
                                   @endif

                         </select>
                    </div> 



    <div class="jumbotron" style="width: 500px;">
                

                    
                        <div class="input-group-prepend">
                            

                          <label style="width:150px;" class="input-group-text" for="directorate"><b>Tender number</b> </label>

                     <TABLE id="dataTable" width="300px" border="1">
                            <TR>
                          <TD><INPUT type="checkbox" name="chk"/></TD>
                                 <TD>
                            <input style="color: black;" type="text" required class="form-control" id="type"
                               name="tender[]" placeholder="Enter tender number"  >
   
                                 </TD> 
                           </TR>
                     </TABLE>
                        </div>
                  

    <div style="padding-left: 300px;">  <INPUT  class="btn btn-outline-primary" type="button" value="Add" onclick="addRow('dataTable')" />

    <INPUT id="deleterowbutton" style="display: none;" class="btn btn-outline-danger" type="button" value="Delete " onclick="deleteRow('dataTable')" /></div>
    </div>



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


       







@endSection


