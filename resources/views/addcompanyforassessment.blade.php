@extends('layouts.land')

@section('title')
    Add company to assess
    @endSection
@section('body')

 
      <div  class="container">
            <br>
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
                <h5 style=" text-transform: uppercase;"  id="new_dep" >COMPANY ASSESSMENT</h5>
                <hr>
               <form method="POST" action="{{ route('work.assessment.landscaping' , [$company->id , $company->datecontract , $company->status , $company->nextmonth]) }}">
                    @csrf

                   
                     <div class="form-group">
                            <label>Company name </label>
                            <br>
                            <input value="{{ $company->company_name }}" style="color: black; width:  700px;" type="text" name="{{ $company->company_name }}" class="custom-select" disabled>
                      </div>


                       <p>Assessment month</p>
                        <div class="form-group">
                            <input type="month"  style="color: black; width:  700px;" name="assessmment"  class="form-control"  max="<?php echo date('Y-m'); ?>"  min="<?php echo date('Y-m'); ?>" required ></input>
                        </div>



                       <div class="form-group">
                            <label>Area name</label>
                            <br>
                    
                          

                     <TABLE id="dataTable"  border="1">
                      <TR>
                                <TD><INPUT type="checkbox" name="chk"/></TD>
                                <TD  ><select style="color: black; width:  670px;" required class="custom-select"  name="area[]"  required >
                             <option value="" selected>Choose... 
                            </option>
                         
                                @foreach($carea as $carea)
                                    <option value="{{ $carea->id }}">{{ $carea['cleaning_area']->cleaning_name}}
                                    </option>
                                @endforeach
                            </select></TD> 
           
          
                     </TR>
                    </TABLE> 
                       

                         <INPUT class="btn badge-primary" type="button" value="Add area" onclick="addRow('dataTable')" />

                         <INPUT class="btn badge-danger" type="button" value="Delete" onclick="deleteRow('dataTable')" />
             
                        </div>


<br>    

                    


                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{route('cleaningcompany')}}" onclick="closeTab()"><button type="button" 
                         class="btn btn-danger">Cancel</button></a>
                 
                </form>
            </div>








  



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