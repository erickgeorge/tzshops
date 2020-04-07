@extends('layouts.ppu')

@section('title')
    Infrastructure Project
@endsection
<?php use App\ppuprojectprogress; ?>
@section('body')<br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5 style="padding-left: 90px;  text-transform: uppercase;" ><b style="text-transform: uppercase;">PPU Infrastructure Project Details</b></h5>
        </div>
@if(count($projects)>0)
        
  @endif     
    </div>
    <br>
    <hr class="container">
    <div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger" style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><?php echo $error; ?></li>
                @endforeach
            </ul>
        </div>
    @endif

    </div>
    

<div class="container">
    @if(count($projects)>0)
    
            @foreach($projects  as $project)
            <div class="card">
                
               
                    <div class="card-header">
                        <h4>Project Name: <b>{{ $project->project_name }}</b></h4>
                    </div>
                <div class="card-body">
                 <div class="row" style="font-weight: bold;">
                    <div class="col">
                        <p>Description: <p>{{ $project->description }}</p></p>
                    </div>
                </div>
            </div>
            </div>
                <br>
                <div class="row" style="font-weight: bold;">
                    <div class="col-lg-3">Created on: 
                        <?php  $time = strtotime($project->created_at)?> {{ date('d/m/Y',$time)  }}
                    </div>
                    <div class="col"> Status:
                            <?php $progress = ppuprojectprogress::orderBy('id','Desc')->where('project_id',$project->id)->first(); ?> 
                         @if($progress->status == 0) <div class="badge badge-primary">New Project </div>@endif

                        @if($progress->status == 1) <div class="badge badge-primary">Sent to DVC Admin  
                          @if(auth()->user()->type == 'DVC Admin') 
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b> 
                          @endif </div>
                        @endif
                        @if($progress->status == -1) <div class="badge badge-danger"><a class="link">Rejected by DVC Admin  </a>
                          @if(auth()->user()->type == 'Director DPI') 
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b> 
                          @endif </div>
                        @endif
                        @if($progress->status == 2) <div class="badge badge-primary"><a class="link">Forwarded to Director DES  </a>
                          @if(auth()->user()->type == 'Estates Director') 
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b> 
                          @endif </div>
                        @endif
                        @if($progress->status == 3) <div class="badge badge-primary"><a class="link">Forwarded to Head PPU  </a>
                          @if(auth()->user()->type == 'Head PPU') 
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b> 
                          @endif </div>
                        @endif
                        @if($progress->status == 4) <div class="badge badge-primary"><a class="link">Forwarded to Draftsman  </a>
                          @if(auth()->user()->type == 'Architect & Draftsman') 
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b> 
                          @endif </div>
                        @endif
                    </div>
                    @if($progress->status == -1) <button  class="col-sm-1 badge badge-primary text-light" data-toggle="modal" data-target="#exampleModal1">View Reason</button>

                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                       
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reason for Project Request Rejection</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" style="color: red;">X</span>
                            </button>
                          </div>
                         <input type="text" name="projectid" value="{{ $project->id }}" hidden>
                          <div class="modal-body">
                            
                          <div class="row">
                            <div class="col" style="font-weight: bold;">
                               {{ $progress->notification }}
                            </div>
                          </div>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                          </div>
                        </div>
                      </div>
                    </div>
                        @endif
                    @if(auth()->user()->type == 'Estates Director')
                      @if($progress->status == 2)
                           <div class="col">
                           
                            <a href="{{ route('ppuprojectforwardppu', [$project->id]) }}" class="btn btn-primary">Accept & Forward To Head PPU</a>
                          </div>
                      @endif
                    @endif
                    @if(auth()->user()->type == 'Director DPI')
                    @if($progress->status == 0)
                        <div class="col">
                            <a class="btn btn-warning" href="{{ route('ppueditproject', [$project->id]) }}">Edit</a>
                            <a href="{{ route('ppuprojectforwarddvc', [$project->id]) }}" class="btn btn-primary">Forward To DVC Admin</a>
                        </div>
                    @endif
                     @if($progress->status == -1)
                        <div class="col">
                            <a class="btn btn-warning" href="{{ route('ppueditproject', [$project->id]) }}?reediting=1">Edit</a>
                        </div>
                    @endif
                    @endif

                    @if(auth()->user()->type == 'DVC Admin')
                    @if($progress->status == 1)
                        <div class="col">
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                            Reject
                          </button>
                            <a href="{{ route('ppuprojectforwarddes', [$project->id]) }}" class="btn btn-primary">Accept & Forward To Director DES</a>
                        </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form method="POST" action="{{ route('ppurejectproject', [$project->id]) }}">
                          @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Provide reason of rejection</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" style="color: red;">X</span>
                            </button>
                          </div>
                         <input type="text" name="projectid" value="{{ $project->id }}" hidden>
                          <div class="modal-body">
                            
                          <div class="row">
                            <div class="col">
                               <textarea name="reason" rows="5" class="form-control" placeholder="Write a reason of rejection" required></textarea>
                            </div>
                          </div>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                    </form>
                      </div>
                    </div>
                    @endif
                    @endif

                     @if(auth()->user()->type == 'Head PPU')
                    @if($progress->status == 3)
                        <div class="col">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Accept & Send To Draftsman
                          </button>
                            
                        </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form method="POST" action="{{ route('ppuprojectdraftsman') }}">
                          @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Comments & Notes to Draftsman</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" style="color: red;">X</span>
                            </button>
                          </div>
                         <input type="text" name="projectid" value="{{ $project->id }}" hidden>
                          <div class="modal-body">
                            
                          <div class="row">
                            <div class="col">
                               <textarea name="reason" rows="5" class="form-control" placeholder="Write Comments & Notes to send to Draftsman" required></textarea>
                            </div>
                          </div>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Send</button>
                          </div>
                        </div>
                    </form>
                      </div>
                    </div>
                    @endif
                    @endif

                    @if(auth()->user()->type == 'Architect & Draftsman')
                    @if($progress->status == 4)
                        <div class="col">
                            <p> <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">  Note from DES Director <i class="fa fa-comment" style="color: yellow;"></i> </a> <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal5">
                            Add Drawings & Plans
                          </button></p>
                        </div>
                    @endif
                    @endif
                    

     </div>
<div class="collapse" id="collapseExample">
  <div class="card card-body " style="background-color: #8080804d;">
    {{$progress->remarks}}
  </div>
</div>

 <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="POST" action="">
        @csrf
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Comments & Notes to Draftsman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true" style="color: red;">X</span> </button>
                </div>
                <input type="text" name="projectid" value="{{ $project->id }}" hidden>
                <div class="modal-body" id="rows_here">
                  <div class="row">
                     <div class="col">
                        <a id="addRow" onclick="addRow()" class="btn btn-outline-info"><i class="fa fa-plus"></i> Add New Row</a>
                    </div>
                  </div>
                   <input id="totalmaterials" type="text" name="totalinputs" value="" hidden="">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  <button id="bt" type="submit" class="btn btn-primary" disabled=''>Submit</button>
                </div>
            </div>
          </form>
        </div>
      </div>
            @endforeach
    @else
    <center><h1 style="margin-top: 5%;">No Infrastructure Projects Found</h1></center>
    @endif


</div>
<script>
    // ARRAY FOR HEADER.
    var arrHead = new Array();
    arrHead = ['','', ];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

    // FIRST CREATE A TABLE STRUCTURE BY ADDING A FEW HEADERS AND
    // ADD THE TABLE TO YOUR WEB PAGE.
    function createTable() {
        var MatForm = document.createElement('table');
        MatForm.setAttribute('id', 'MatForm');            // SET THE TABLE ID.

        var tr = MatForm.insertRow(-1);

        for (var h = 0; h < arrHead.length; h++) {
            var th = document.createElement('th');                

                     // TABLE HEADER.
            th.innerHTML = arrHead[h];
            tr.appendChild(th);
        }

        var div = document.getElementById('rows_here');
        div.appendChild(MatForm);    // ADD THE TABLE TO YOUR WEB PAGE.

        var empTab = document.getElementById('MatForm');

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
        tr = empTab.insertRow(rowCnt);

        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                 // ADD A BUTTON.
                var button = document.createElement('button');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-danger')

                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);

                var i = document.createElement('i');
                  i.setAttribute('class', 'fa fa-trash');
                  button.appendChild(i);
            }
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
               if(c==1)
                {
                        var ele = document.createElement('input');
                }else
                {
                    var ele = document.createElement('input');
                }

                ele.setAttribute('id',c);
                if(c==1){
                    ele.setAttribute('type', 'file');
                }                

                ele.setAttribute('required', '');
                ele.setAttribute('class', 'form-control');
                ele.setAttribute('name',c);
                ele.setAttribute('id',c);

               

    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('totalmaterials').value = value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }

            ele.setAttribute('value', '');
            ele.setAttribute('name',value);
            ele.setAttribute('id',value);
            td.appendChild(ele);            

            }
        }

       
    }

    // ADD A NEW ROW TO THE TABLE.s
    function addRow() {
        var empTab = document.getElementById('MatForm');

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
        tr = empTab.insertRow(rowCnt);

     for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                 // ADD A BUTTON.
                var button = document.createElement('button');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-danger')

                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);

                var i = document.createElement('i');
                  i.setAttribute('class', 'fa fa-trash');
                  button.appendChild(i);
            }
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
               if(c==1)
                {
                        var ele = document.createElement('input');
                }else
                {
                    var ele = document.createElement('input');
                }

                ele.setAttribute('id',c);
                if(c==1){
                    ele.setAttribute('type', 'file');
                }                

                ele.setAttribute('required', '');
                ele.setAttribute('class', 'form-control');
                ele.setAttribute('name',c);
                ele.setAttribute('id',c);

               

    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('totalmaterials').value = value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }

            ele.setAttribute('value', '');
            ele.setAttribute('name',value);
            ele.setAttribute('id',value);
            td.appendChild(ele);            

            }
        }

        
    }

    // DELETE TABLE ROW.
    function removeRow(oButton) {
        var empTab = document.getElementById('MatForm');
    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    --value; 
        document.getElementById('totalmaterials').value = value;
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex); 

var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }
              // BUTTON -> TD -> TR.
    }

    // EXTRACT AND SUBMIT TABLE DATA.
    function submit() {
        var myTab = document.getElementById('MatForm');
        var values = new Array();

        // LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length - 1; row++) {
            for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'text') {
                    values.push("'" + element.childNodes[0].value + "'");
                }
            }
        }
        
        // SHOW THE RESULT IN THE CONSOLE WINDOW.
        console.log(values);
    }



</script>
@endsection