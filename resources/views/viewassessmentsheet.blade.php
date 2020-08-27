@extends('layouts.land')
@section('title')
Assessment Sheet
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

<div class="container">
<h5   style="text-transform: capitalize;"><b>
 Assessment Sheet Details</b></h5>
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
        <th style="width: 950px">Activity</th>
        <th style="width: 200px">Percentage(%)</th>
         @if((auth()->user()->type == 'USAB') || (auth()->user()->type == 'Supervisor Landscaping')  || (auth()->user()->type == 'Administrative officer') || ($role['user_role']['role_id'] == 1))
        <th >Action</th>
         @endif
         </tr>
      </thead>



       <?php
   $summ = 0;
   $summm = 0;
   $i = 0;
   ?>
    <tbody>
  @foreach($assessmmentactivity as $assesment)
   <?php $i++;   $summ += $assesment->percentage; ?>


  <tr>
       <TD>{{$i}}</TD>

      <TD  >{{$assesment->activity}}</TD>

      <TD align="center">{{$assesment->percentage}}</TD>


 @if((auth()->user()->type == 'USAB') || (auth()->user()->type == 'Supervisor Landscaping')  || (auth()->user()->type == 'Administrative officer') || ($role['user_role']['role_id'] == 1))
           <td >

                            <div class="row">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                                    <a style="color: green;"
                                       onclick="myfunc('{{ $assesment->id }}','{{ $assesment->activity }}','{{ $assesment->percentage }}' )"
                                       data-toggle="modal" data-target="#editarea" title="Edit"><i
                                                class="fas fa-edit"></i></a>

                                        &nbsp;&nbsp;


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


      @endif   

 </tr>

  @endforeach
   </tbody>

     <tr><td  align="center" colspan="2" >TOTAL PERCENTAGE</td><td  align="center">{{ $summ}}% </td></tr>


     </table>






 <!--<form method="POST"  action="{{ route('edit.assessment.sheet', [$assessmmentcompany->name]) }}" >
                    @csrf

</form>-->





  <!-- Modal for view Reason ESTATE-->
    <div class="modal fade" id="editarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b></b> Edit activity.</b></h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <form method="POST" action="{{route('assessment.sheet.edit')}}" class="col-md-6">

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
                                                      </div>


                 </form>
                  </div>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


@if($summ > 100)
<br>
<div class="container jumbotron" style="color: red;"><p>Please edit the assessment sheet, The total percentage has exceeded 100%. Hence this assessment sheet will not used until total percentage equal to 100%.</p></div>
<br>

@endif

@if($summ < 100)

<br><br>


    <div >
    <div >

            <div >

            <label class="container" >
                Please crosscheck the assessment sheet in the form below to make total percentage of 100% .</label>

               </div>
            </div>





                    @csrf

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


     <form method="POST"  action="{{ route('edit.assessment.proceeding.two', [$assessmmentcompany->name , $assessmmentcompany->type]) }}" >
      @csrf

    <TABLE id="dataTable" width="350px" border="1">
        <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>
            <TD  ><textarea style="width: 250px; height: 60px;" class="form-control" type="text" name="activity[]"  placeholder ="activity..." required="required"  ></textarea></TD>

            <TD><input style="width:150px;"  oninput="totalitem()" id="istock"  min="1" max="100"  class="form-control" type="number" name="percentage[]" placeholder="Percentage" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="required"   >    </TD>


        </TR>



    </TABLE>
   <div style="padding-left: 300px;">  <INPUT  class="btn btn-primary" type="button" value="Add" onclick="addRow('dataTable')" />

    <INPUT id="deleterowbutton" style="display: none;"  class="btn btn-danger" type="button" value="Delete " onclick="deleteRow('dataTable')" /></div>

<br>
                    <button type="submit" class="btn btn-primary float-right">Save
                    </button>
  </form>

  </div>
</div>



  </div>


                </div>




        @endif

      </div>

     </div>




  <script type="text/javascript">

        function myfunc(A, B, C, D, E , F , G, H) {

            document.getElementById("activity_id").value = A;

            document.getElementById("activity").value = B;

           document.getElementById("type").value = C;


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







@endsection


