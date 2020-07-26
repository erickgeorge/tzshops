@extends('layouts.land')

@section('title')
add new assessment sheet
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
                <h5 style="text-transform: capitalize;"   id="Add New House" >Assessmet Sheet</h5>
                      <hr>
                 <p align="center" style="color: red">All fields are compulsory</p>

                <form method="POST" action="{{ route('addnew.sheet') }}" class="col-lg-12">
                    @csrf

                <div align="center">


                        <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">


                          <label style="width:150px;" class="input-group-text" for="directorate">Name</label>

                        </div>
                        <input style="color: black" type="text" required class="form-control" id="name"
                               name="name"  placeholder="Enter sheet name"  >
                    </div>



                        <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">


                          <label style="width:150px;" class="input-group-text" for="directorate">Type</label>

                        </div>
                       <select  class="form-control" name="type" required="required">
                         <option value="">Choose type...</option>
                          <option value="Exterior">Exterior</option>
                           <option value="Interior">Interior</option>
                       </select>
                    </div>


                    <div>


   <div class="jumbotron" style="width: 500px;">


     <table>

      <tr>
     <thead style="color: white;">
        <th style="width: 25px"></th>
        <th style="width: 420px">Activity</th>
        <th style="width: 200px">Percentage(%)</th>

     </thead>
      </tr>

     </table>



    <TABLE id="dataTable" width="350px" border="1">
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><textarea style="width: 250px; height: 60px;" class="form-control" type="text" name="activity[]"  placeholder ="activity..." required="required"  ></textarea></TD>

            <TD><input style="width:150px;"  oninput="totalitem()" id="istock"  min="1" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   >    </TD>


        </TR>



    </TABLE>
   <div style="padding-left: 300px;">  <INPUT  class="btn btn-outline-primary" type="button" value="Add" onclick="addRow('dataTable')" />

    <INPUT id="deleterowbutton" style="display: none;" class="btn btn-outline-danger" type="button" value="Delete " onclick="deleteRow('dataTable')" /></div>

  </div>





                    <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a class="btn btn-danger" href="/assessmentsheet" role="button">Cancel </a>
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


