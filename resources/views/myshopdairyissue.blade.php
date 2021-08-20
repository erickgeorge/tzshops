@extends('layouts.master')

@section('title')
    Add New Issue
    @endSection
@section('body')


    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Used Issues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
          
              <li class="breadcrumb-item active">Uses</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
        <hr>
    </section>



  <div class="container">
              
                    
                <!-- <p align="center" style="color: red">All fields are compulsory</p>-->
                 <?php $id = Crypt::encrypt($idz); ?> 
                <form method="POST" action="{{ route('addnewissue',[$id]) }}" class="col-lg-12">
                    @csrf

                <div align="center">


                        <div class="input-group mb-3 col-lg-6">
                        <div class="input-group-prepend">


                          <label class="input-group-text" for="directorate">Date <sup style="color: red;">*</sup></label>

                        </div>
                        <input style="color: black" type="date" required class="form-control" 
                               name="date"  >
                        </div>


   <div >


     <table>


     </table>

    <TABLE id="dataTable" >
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD> <select style="color: black;" required class="custom-select" name="keeper[]" >
                <option value="" selected>Used by..</option>
                @foreach($shopkeeper as $kp)
                <option value="{{$kp->id}}">{{$kp->name}}</option>
                @endforeach
              </select> </TD>
            <TD  ><textarea  class="form-control" type="text" name="issue[]"  placeholder ="Used Issue.." required="required"  ></textarea></TD>

            <TD><input   oninput="totalitem()" id="istock"  min="1"  class="form-control" type="number" name="price[]" placeholder="Price.." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   >    </TD>

        </TR>

   </TABLE>
   <div align="right">  <INPUT  class="btn btn-primary" type="button" value="Add" onclick="addRow('dataTable')" />

    <INPUT id="deleterowbutton" style="display: none;" class="btn btn-danger" type="button" value="Delete " onclick="deleteRow('dataTable')" /></div>

  </div>


<br>

                    <button type="submit" class="btn btn-primary">Save
                    </button>
                    <a class="btn btn-danger" href="/assessmentsheet" role="button">Cancel </a>
               
  <br>  <br>  <br>
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
