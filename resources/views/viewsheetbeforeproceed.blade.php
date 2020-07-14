@extends('layouts.land')
@section('title')
Company report
@endsection
@section('body')
<br>


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
 

<h5 align="center" style="text-transform: uppercase;">
 ASSESSMENT SHEET DETAILS </h5>
<hr>
<div class="container">
<div class="row">
	<div class="col">
   <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Name</label>
        </div>
        <input style="color: black; width: 34px;" type="text" required class="form-control" placeholder="{{$assessmmentcompany->name}}" name="problem"
               aria-describedby="emailHelp"  disabled>
    </div>
      </div>


 

<div class="col">
     <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">Type</label>
        </div>


        <input style="color: black" type="text" required class="form-control" placeholder="{{$assessmmentcompany->type}}" name="location"
               aria-describedby="emailHelp"  disabled>
    </div>
 </div>   


 </div>

</div>




<div class="container">
 <table class="table table-striped" id="myTable">
        
         <thead style="color: white;">
           <tr>
        <th >#</th>
        <th style="width: 800px">Activity</th>
        <th style="width: 150px">Percentage(%)</th>
        <th style="width: 100px">Action</th>
        </tr>
      </thead>
      <?php  
   $summ = 0;
   $summm = 0;
   $i = 0;
   ?>
       <tbody>
  @foreach($assessmmentactivity as $assesment)
   <?php $i++;  $summ += $assesment->percentage; ?>
  
        <tr>
          <td>{{$i}}</td>
          <td>{{$assesment->activity}}</td>
          <td align="center">{{$assesment->percentage}}</td>
          <td >
                            
                            <div class="row">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                                    <a style="color: green;"
                                       onclick="myfunc('{{ $assesment->id }}','{{ $assesment->activity }}','{{ $assesment->percentage }}' )"
                                       data-toggle="modal" data-target="#editarea" title="Edit"><i
                                                class="fas fa-edit"></i></a>


                                    <form method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this activity and percentage completely? ')"
                                          action="{{ route('assess.sheet.delete', [$assesment->id , $assesment->name]) }}">
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
   </tbody>
   <tr><td  align="center" colspan="2" >TOTAL PERCENTAGE</td><td  align="center">{{ $summ}}% </td></tr>  
     
</table>





     <!-- Modal for view Reason ESTATE-->
    <div class="modal fade" id="editarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b></b> Edit activity.</b></h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <form method="POST" action="edit/assessment/sheets" class="col-md-6">
                  

                        @csrf

                        <div class="form-group" style="width: 440px">
                            <label for="name_of_house">Activity <sup style="color: red;">*</sup></label>
                            <textarea type="text" required class="form-control"
                                   id="activity"
                                   name="activity" placeholder="Enter activity"></textarea> 
                            <input id="activity_id" name="activity_id" hidden>
                        </div>
                       

                             <div class="form-group" style="width: 440px">
                            <label for="name_of_house">Percentage <sup style="color: red;">*</sup></label>
                           <input   oninput="totalitem()" id="type"  min="1" max="100"  class="form-control" type="number" name="percentage" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   > 

                          
                        </div>
                                   <div style="float: left; width: 130px"> 
                                                      
                                                        <button  type="submit" class="btn btn-primary">Save 
                                                        </button>
                  
                                                       
                 </form>                              </div>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@if($summ == 100)
 <a  href="{{route('finalsavesheet',[$assessmmentcompany->name])}}"> <button type="submit" class="btn btn-primary float-right"> Save assessment sheet
                    </button></a>
                     @csrf
@endif


@if($summ < 100)

<br><br>


    <div class="row">
    <div class="col">
            <div >
                 <div class="checkbox">
            <label><input id="checkdiv" name="checkdiv" type="checkbox" value="yesmanual" onclick="ShowHideDiv(this)">
                Please fix total percentage to 100%</label>
               </div>
            </div>
      
               <div id="divmanual">
              

 
                

   <div align="center">

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
      

     <form method="POST"  action="{{ route('edit.assessment.proceeding', [$assessmmentcompany->name , $assessmmentcompany->type]) }}" >
      @csrf

    <TABLE id="dataTable" width="350px" border="1">
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><textarea style="width: 250px; height: 60px;" class="form-control" type="text" name="activity[]"  placeholder ="activity..." required="required"  ></textarea></TD> 
           
            <TD><input style="width:150px;"  oninput="totalitem()" id="istock"  min="0" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   >    </TD> 
              
          
        </TR>

      

    </TABLE>
   <div style="padding-left: 300px;">  <INPUT  class="btn btn-outline-primary" type="button" value="Add" onclick="addRow('dataTable')" />

    <INPUT  class="btn btn-outline-danger" type="button" value="Delete " onclick="deleteRow('dataTable')" /></div>

<br>
                    <button type="submit" class="btn btn-primary float-right">Save
                    </button>
  </form>

  </div>
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

                 
           
                

                </div>

        </div>


        @endif










        <script type="text/javascript">

        function myfunc(A, B, C, D, E , F , G, H) {

            document.getElementById("activity_id").value = A;

            document.getElementById("activity").value = B;

           document.getElementById("type").value = C;
           
       
       }



   </script>








@endsection


