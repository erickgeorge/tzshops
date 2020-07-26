@extends('layouts.ppu')

@section('title')
    Infrastructure Project
@endsection
<?php use App\ppuprojectprogress;
      use App\ppudocument;
      use  App\ppuprojectdrawing;
      use App\ppuprojectbudget;
      use App\User;

?>
@section('body')<br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5   ><b style="text-transform: capitalize;">PPU Infrastructure Project Details</b></h5>
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

                        @if($progress->status == 1) <div class="badge badge-primary">Project Sent to DVC Admin
                          @if(auth()->user()->type == 'DVC Admin')
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                          @endif </div>
                        @endif
                        @if($progress->status == 11) <div class="badge badge-primary">Plans & Drawings Sent to Director DES for Approval
                         @if(auth()->user()->type == 'Estates Director')
                         <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                         @endif </div>
                        @endif
                        @if($progress->status == 12) <div class="badge badge-primary">Approved Plans & Drawings sent to Head PPU
                            @if(auth()->user()->type == 'Head PPU')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                        @if($progress->status == -1) <div class="badge badge-danger"><a class="link">Project Rejected by DVC Admin  </a>
                          @if(auth()->user()->type == 'Director DPI')
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                          @endif </div>
                        @endif
                        @if($progress->status == 2) <div class="badge badge-primary"><a class="link">Project Forwarded to Director DES  </a>
                          @if(auth()->user()->type == 'Estates Director')
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                          @endif </div>
                        @endif
                        @if($progress->status == 3) <div class="badge badge-primary"><a class="link">Project Forwarded to Head PPU  </a>
                          @if(auth()->user()->type == 'Head PPU')
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                          @endif </div>
                        @endif
                        @if($progress->status == 4) <div class="badge badge-primary"><a class="link">Forwarded to Draftsman  </a>
                          @if(auth()->user()->type == 'Architect & Draftsman')
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                          @endif </div>
                        @endif
                        @if($progress->status == 5) <div class="badge badge-primary"><a class="link">Plans Sent to Head PPU  </a>
                            @if(auth()->user()->type == 'Head PPU')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                          @endif
                          @if($progress->status == 6) <div class="badge badge-primary"><a class="link">Plans Sent to DVC Admin  </a>
                            @if(auth()->user()->type == 'DVC Admin')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                          @endif
                          @if($progress->status == 7) <div class="badge badge-primary"><a class="link">Plans Approved By DVC Admin  </a>
                            @if(auth()->user()->type == 'Head PPU')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                          @endif
                          @if($progress->status == 8)
                          <div class="badge badge-primary"><a class="link">Approved Plans & Drawings Forwarded to QS For Budget Preparation</a>
                            @if(auth()->user()->type == 'Quality Surveyor')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                            @endif
                            @if($progress->status == 9)
                            <div class="badge badge-primary"><a class="link">Project Budget Forwarded to Head PPU</a>
                              @if(auth()->user()->type == 'Head PPU')
                              <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                              @endif </div>
                              @endif
                              @if($progress->status == 10)
                              <div class="badge badge-primary"><a class="link">Project Budget Forwarded to Director DES for Approval</a>
                                @if(auth()->user()->type == 'Estates Director')
                                <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                                @endif </div>
                                @endif
                                @if($progress->status == 13)
                                <div class="badge badge-primary"><a class="link">Project Budget Forwarded to DVC Admin for Approval</a>
                                  @if(auth()->user()->type == 'DVC Admin')
                                  <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                                  @endif </div>
                                  @endif
                                  @if($progress->status == 14)
                                  <div class="badge badge-primary"><a class="link">Project Budget approved by DVC Admin</a>
                                   </div>
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
                            Accept & Send To Draftsman For Drawing Plans
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
                            <p>
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal5">
                            Add Drawings & Plans
                          </button></p>
                        </div>
                        @endif
                      @endif




     </div>
     @if(auth()->user()->type == 'Architect & Draftsman')
        @if($progress->status == 4)
        <div class="card card-body " style="background-color: #8080804d;">
          {{$progress->remarks}}
        </div>
      @endif
    @endif
<div class="collapse" id="collapseExample">
  <div class="card card-body " style="background-color: #8080804d;">
    {{$progress->remarks}}
  </div>
</div>

 <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="POST" action="{{ route('ppudraftsdraws') }}" enctype="multipart/form-data">
        @csrf
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Drawings & Plans</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true" style="color: red;">X</span> </button>
                </div>
                <input type="text" name="projectid" value="{{ $project->id }}" hidden>
                <div class="modal-body" id="rows_here">
                  <div class="row">
                     <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label  class="input-group-text">Drawing </label>
                            </div>
                            <input type="file" name="file" class="form-control" required >
                        </div>
                    </div>
                  </div>

                </div>
                <div class="modal-body" id="rows_here">
                   <div class="row">
                    <div class="col">
                      <div class="input-group">
                        <div class="input-group-prepend">
                            <label  class="input-group-text">Drawn By</label>
                        </div>
                        <input type="text" name="author" placeholder="Drawn By" required>
                    </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                    <label> Description </label>
                    <textarea name="description" rows="7" class="form-control" required>

                    </textarea>
                  </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  <button id="bt" type="submit" class="btn btn-primary">Submit & Send Plans to Head PPU</button>
                </div>
            </div>
          </form>
        </div>
      </div>
      <br>
      @if($progress->status == 5)
         @if((auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Architect & Draftsman'))
        <div class="card" style="background-color:#343a4017 !important;">
          <?php $documented = ppuprojectdrawing::where('project_id',$project->id)->get(); ?>
          @foreach ($documented as $documented)
          <div class="card-header" style="text-transform:uppercase;">
              <b>Project Plans & Drawings</b>
          </div>

            <?php $drawing = ppudocument::where('document_identifier',$documented->document_identifier)->get(); ?>
            @foreach ($drawing as $drawing)
            <div class=" card-body ">
              Descriprion:  {{$documented->description}}
            </div>
            <div class="card-footer">
            <div class="row"> <div class="col">Drawn By : {{$documented->drawn_by}}</div><div class="col"> Uploaded on : <?php $time = strtotime($documented->created_at); echo date('d/m/Y',$time);  ?> </div><div class='col'>Document Type : {{$drawing->type}}
              </div><div class='col'><a href=" {{route('viewppudraws',[$project->id,$drawing->type,$drawing->doc_name])}} " class='btn btn-success'>View Plan Documents</a></div></div>
            </div>
            @endforeach

          @endforeach
        </div>
        @if (auth()->user()->type == 'Head PPU')
        <br>
    <a href="{{ route('ppuforwardplanDvcAdmin',[$project->id]) }}" class=" btn btn-primary">Forward Plans to Director DES for Approval</a> <br>
        @endif
        @endif
      @endif

      @if($progress->status == 11)
      @if((auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Architect & Draftsman')||(auth()->user()->type == 'Estates Director'))
     <div class="card" style="background-color:#343a4017 !important;">
       <?php $documented = ppuprojectdrawing::where('project_id',$project->id)->get(); ?>
       @foreach ($documented as $documented)
       <div class="card-header" style="text-transform:uppercase;">
           <b>Project Plans & Drawings</b>
       </div>

         <?php $drawing = ppudocument::where('document_identifier',$documented->document_identifier)->get(); ?>
         @foreach ($drawing as $drawing)
         <div class=" card-body ">
           Descriprion:  {{$documented->description}}
         </div>
         <div class="card-footer">
         <div class="row"> <div class="col">Drawn By : {{$documented->drawn_by}}</div><div class="col"> Uploaded on : <?php $time = strtotime($documented->created_at); echo date('d/m/Y',$time);  ?> </div><div class='col'>Document Type : {{$drawing->type}}
           </div><div class='col'><a href=" {{route('viewppudraws',[$project->id,$drawing->type,$drawing->doc_name])}} " class='btn btn-success'>View Plan Documents</a></div></div>
         </div>
         @endforeach

       @endforeach
     </div>
     @if (auth()->user()->type == 'Estates Director')
     <br>
 <a href="{{ route('ppuforwardplanDES',[$project->id]) }}" class=" btn btn-primary">Approve & Forward to Director DVC Admin for Approval</a> <br>
     @endif
     @endif
   @endif



      @if($progress->status == 9)
      @if((auth()->user()->type == 'Quality Surveyor')||(auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'DVC Admin'))
      <div class="card">
          @php
              $budget = ppuprojectbudget::where('project_id',$project->id)->orderBy('budget_item','ASC')->get(); $x=1;
          @endphp
          <div class="card-header">
              Project Budget
          </div>
          <div class="card-body">
                  <table class="table display" id="myTable" style="width:100%">
                      <thead class="thead-light">
                          <tr>
                              <th>#</th>
                              <th>Budget Item</th>
                              <th>Amount</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($budget as $budget)
                          <tr>
                              <td>{{$x}}</td>
                              <td>{{$budget->budget_item}}</td>
                              <td>{{number_format($budget->amount)}}</td>
                              @php
                                  $x++;
                              @endphp
                          </tr>
                          @endforeach

                      </tbody>
                  </table>
              </p>
          </div>
      </div>
      <br>
          @if($progress->status == 9)
              @if (auth()->user()->type == 'Head PPU')
                  <a href="{{route('ppubudgetAppoveDES',[$project->id])}}" class="btn btn-primary">Forward to Director DES for Approval</a><br>
              @endif
          @endif
      @endif
    @endif


    @if($progress->status == 14)
    @if((auth()->user()->type == 'Quality Surveyor')||(auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'DVC Admin'))
    <div class="card">
        @php
            $budget = ppuprojectbudget::where('project_id',$project->id)->orderBy('budget_item','ASC')->get(); $x=1;
        @endphp
        <div class="card-header">
            Project Budget
        </div>
        <div class="card-body">
                <table class="table display" id="myTable" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Budget Item</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budget as $budget)
                        <tr>
                            <td>{{$x}}</td>
                            <td>{{$budget->budget_item}}</td>
                            <td>{{number_format($budget->amount)}}</td>
                            @php
                                $x++;
                            @endphp
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </p>
        </div>
    </div>
    <br>
    <i class="fa fa-check text-success btn btn-outline-success"> Approved </i><br>
    @endif
  @endif

    @if($progress->status==10)
    @if((auth()->user()->type == 'Quality Surveyor')||(auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'DVC Admin'))
    <div class="card">
        @php
            $budget = ppuprojectbudget::where('project_id',$project->id)->orderBy('budget_item','ASC')->get(); $x=1;
        @endphp
        <div class="card-header">
            Project Budget
        </div>
        <div class="card-body">
                <table class="table display" id="myTable" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Budget Item</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budget as $budget)
                        <tr>
                            <td>{{$x}}</td>
                            <td>{{$budget->budget_item}}</td>
                            <td>{{number_format($budget->amount)}}</td>
                            @php
                                $x++;
                            @endphp
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </p>
        </div>
    </div>
    <br>

        @if($progress->status == 10)
            @if (auth()->user()->type == 'Estates Director')
                <a href="{{route('ppubudgetAppoveDVC',[$project->id])}}" class="btn btn-primary">Forward to DVC Admin for Approval</a><br>
            @endif
        @endif
    @endif
  @endif

  @if($progress->status==13)
  @if((auth()->user()->type == 'Quality Surveyor')||(auth()->user()->type == 'Head PPU')||(auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'DVC Admin'))
  <div class="card">
      @php
          $budget = ppuprojectbudget::where('project_id',$project->id)->orderBy('budget_item','ASC')->get(); $x=1;
      @endphp
      <div class="card-header">
          Project Budget
      </div>
      <div class="card-body">
              <table class="table display" id="myTable" style="width:100%">
                  <thead class="thead-light">
                      <tr>
                          <th>#</th>
                          <th>Budget Item</th>
                          <th>Amount</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($budget as $budget)
                      <tr>
                          <td>{{$x}}</td>
                          <td>{{$budget->budget_item}}</td>
                          <td>{{number_format($budget->amount)}}</td>
                          @php
                              $x++;
                          @endphp
                      </tr>
                      @endforeach

                  </tbody>
              </table>
          </p>
      </div>
  </div>
  <br>

      @if($progress->status == 13)
          @if (auth()->user()->type == 'DVC Admin')
              <a href="{{route('ppubudgetApprovedDVC',[$project->id])}}" class="btn btn-primary">Approve</a><br>
          @endif
      @endif
  @endif
@endif

      @if($progress->status == 8)
      @if(auth()->user()->type == 'Quality Surveyor')
         <div class="card" style="background-color:#343a4017 !important;">
             <div class="card-body">
                 <h5 class="card-title">Note From Head PPU :</h5>
                 <p class="card-text">{{$progress->remarks}}</p>
             </div>
         </div>
         <br>
         <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#my-modal7">Create Budget</button><br>
         <div id="my-modal7" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
             <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="my-modal-title">Create Project Budget</h5>
                         <button class="close" style="color:red;" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <p>
                            <form method="POST" action="{{ url('ppuForwardBudgetppu') }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="my-input">Description : </label>
                                    <textarea name="description" class="form-control" cols="30" rows="5" required></textarea>
                                  </div>
                                <div id="cont">

                                </div>
                            <input type="text" name="projectid" value="{{$project->id}}" hidden>
                                <input id="totalmaterials" type="text" name="totalinputs" value="" hidden>
                                <p>
                                    <div class="row">
                                        <div class="col">
                                            <a id="addRow" onclick="addRow()" class="btn btn-outline-info"><i class="fa fa-plus"></i> Add New Row</a>
                                        </div>
                                    </div><br>

                                    <br>
                                    <div class="row">

                                      <div class="col">
                                          <button id="bt" type="submit" class="btn btn-primary" >Submit</button>&nbsp;<a href="{{ url('ProcurementHistory') }}" class="btn btn-danger">Cancel</a>
                                      </div>
                                  </div>
                                </p>
                            </form>
                         </p>
                     </div>
                 </div>
             </div>
         </div>
        <!-- some js here -->
        <script>
            // ARRAY FOR HEADER.
            var arrHead = new Array();
            arrHead = ['','Budget Item', 'Amount', ];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

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

                var div = document.getElementById('cont');
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
                        button.setAttribute('disabled', 'true');

                        td.appendChild(button);

                        var i = document.createElement('i');
                            i.setAttribute('class', 'fa fa-trash');
                            button.appendChild(i);
                    }
                    else {
                        // CREATE AND ADD TEXTBOX IN EACH CELL.

                            var ele = document.createElement('input');

                        if(c==1){
                            ele.setAttribute('onClick','reply_click(this.id)');
                            ele.setAttribute('style','min-width:300px;');
                        }
                        if(c==2){
                            ele.setAttribute('onClick','reply_click1(this.id)');
                        }

                        ele.setAttribute('id',c);
                        if(c==2){
                            ele.setAttribute('type', 'number');
                            ele.setAttribute('min', '1');
                        }
                        else{
                            ele.setAttribute('type', 'text');
                        }

                        ele.setAttribute('required', '');
                        ele.setAttribute('class', 'form-control');
                        if(c==2){
                            ele.setAttribute('onClick','reply_click1(this.id)');
                        }
                        if(c==1){
                            ele.setAttribute('onClick','reply_click(this.id)');
                        }
                        ele.setAttribute('id',c);



            var value = parseInt(document.getElementById('totalmaterials').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('totalmaterials').value = value;

            var hide = document.getElementById('bt');
                if (value > 0) {
                    hide.disabled = false;
                }
                else {
                    hide.disabled = true;
                }

                ele.setAttribute('name', value);
                ele.setAttribute('id', value);
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

                            var ele = document.createElement('input');

                        if(c==1){
                            ele.setAttribute('onClick','reply_click(this.id)');
                            ele.setAttribute('style','min-width:300px;');
                        }
                        if(c==2){
                            ele.setAttribute('onClick','reply_click1(this.id)');
                        }

                        ele.setAttribute('id',c);
                        if(c==2){
                            ele.setAttribute('type', 'number');
                            ele.setAttribute('min', '1');
                        }
                        else{
                            ele.setAttribute('type', 'text');
                        }

                        ele.setAttribute('required', '');
                        ele.setAttribute('class', 'form-control');
                        if(c==2){
                            ele.setAttribute('onClick','reply_click1(this.id)');
                        }
                        if(c==1){
                            ele.setAttribute('onClick','reply_click(this.id)');
                        }




            var value = parseInt(document.getElementById('totalmaterials').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('totalmaterials').value = value;

            var hide = document.getElementById('bt');
                if (value > 0) {
                    hide.disabled = true;
                }
                else {
                    hide.disabled = false;
                }

                ele.setAttribute('name', value);
                ele.setAttribute('id', value);
                    td.appendChild(ele);

                    }
                }


            }

            // DELETE TABLE ROW.
            function removeRow(oButton) {
                var empTab = document.getElementById('MatForm');
            var value = parseInt(document.getElementById('totalmaterials').value, 10);
            value = isNaN(value) ? 0 : value; --value; --value;
            document.getElementById('totalmaterials').value = value;
                empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);

        var value = parseInt(document.getElementById('totalmaterials').value, 10);
            value = isNaN(value) ? 0 : value;

            var hide = document.getElementById('bt');
                if (value > 0) {
                    hide.disabled = false;
                }
                else {
                    hide.disabled = true;
                }
                      // BUTTON -> TD -> TR.
            }



        </script>
        <!-- some js ends here -->
       @endif
     @endif

      @if((($progress->status == 6)||($progress->status == 7))||($progress->status == 12))
      @if((auth()->user()->type == 'DVC Admin')||(auth()->user()->type == 'Estates Director')||(auth()->user()->type == 'Head PPU'))
     <div class="card" style="background-color:#343a4017 !important;">
       <?php $documented = ppuprojectdrawing::where('project_id',$project->id)->get(); ?>
       @foreach ($documented as $documented)
       <div class="card-header" style="text-transform:uppercase;">
           <b>Project Plans & Drawings</b>
       </div>

         <?php $drawing = ppudocument::where('document_identifier',$documented->document_identifier)->get(); ?>
         @foreach ($drawing as $drawing)
         <div class=" card-body ">
           Descriprion:  {{$documented->description}}
         </div>
         <div class="card-footer">
         <div class="row"> <div class="col">Drawn By : {{$documented->drawn_by}}</div><div class="col"> Uploaded on : <?php $time = strtotime($documented->created_at); echo date('d/m/Y',$time);  ?> </div><div class='col'>Document Type : {{$drawing->type}}
           </div><div class='col'><a href=" {{route('viewppudraws',[$project->id,$drawing->type,$drawing->doc_name])}} " class='badge badge-success'>View Plan Documents</a></div></div>
         </div>
         @endforeach

       @endforeach
     </div>
     @if (auth()->user()->type == 'DVC Admin')
     <br>
     @if($progress->status == 6)

 <a href="{{ route('ppuApproveplanDES',[$project->id]) }}" class=" btn btn-primary">Approve Project Plans</a> <br>
    @elseif($progress->status == 7)
    <i class="fa fa-check text-success btn btn-outline-success"> Approved</i><br>
     @endif
    @elseif (auth()->user()->type == 'Estates Director')
    <br>
    @if($progress->status == 7)
    <i class="fa fa-check text-success btn btn-outline-success"> Approved </i>
   <a class="btn btn-primary" href="{{route('ppuForwardDVCppu',[$project->id])}}">Forward To Head PPU</a><br>
    @endif
    @elseif (auth()->user()->type == 'Head PPU')
    <br>
    @if($progress->status == 12)
    <i class="fa fa-check text-success btn btn-outline-success"> Approved </i>
    <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal6"
      class="btn btn-primary" > Forward to Quality Surveyor for Budget Preparation</a><br>
    <div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="POST" action="{{ route('ppuForwardPlansQS',[$project->id]) }}" enctype="multipart/form-data">
            @csrf
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Forward Plans to Quality Surveyor for Budget Preparation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true" style="color: red;">X</span> </button>
                    </div>
                    <input type="text" name="projectid" value="{{ $project->id }}" hidden>
                    <div class="modal-body" id="rows_here">
                      <div class="row">
                        <div class="col">
                        <label> Note </label>
                        <textarea name="description" rows="7" class="form-control" placeholder="Note to Quality Surveyor" required>

                        </textarea>
                      </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                      <button id="bt" type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
    @endif
     @endif
     @endif

     <!---------->
   @endif


     <br>
     <div class="container">
         <div class="row">
             <div class="col">
                 <a class="btn btn-primary" href="{{route('pputrack',[$project->id])}}"> <i class="fa fa-door"></i> Track pogress</a>
             </div>
         </div>
     </div>
            @endforeach
    @else
    <center><h1 style="margin-top: 5%;">No Infrastructure Projects Found</h1></center>
    @endif

<br>
<br>
</div>
@endsection
