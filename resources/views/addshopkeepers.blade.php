@extends('layouts.master')

@section('title')
    Add New Shop Keeper
    @endSection
@section('body')


    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Shopkeeper</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
          
              <li class="breadcrumb-item active">Shopkeeper</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
        <hr>
    </section>



  <div class="container">
              
                    
                <!-- <p align="center" style="color: red">All fields are compulsory</p>-->
                 <?php $id = Crypt::encrypt($idz); ?> 
                <form method="POST" action="{{ route('postshopkeeper',[$id]) }}" class="col-lg-12">
                    @csrf

                <div align="center">

   <div >


     <table>


     </table>

    <TABLE id="dataTable" >
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
          
            <TD  ><input  class="form-control" type="text" name="name[]"  placeholder ="Name" required="required"  ></TD>

            <TD><input   oninput="totalitem()" id="istock"  min="1"  class="form-control" type="number" name="price[]" placeholder="Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"    >    </TD>


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
