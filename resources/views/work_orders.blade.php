@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h3><b>Work orders list </b></h3>
        </div>

        <div class="col-md-6">
            <form method="GET" action="work_order" class="form-inline my-2 my-lg-0">
                From <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>" required class="form-control mr-sm-2" type="date" placeholder="Start Month"
                               max="<?php echo date('Y-m-d'); ?>">
                To <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end" required class="form-control mr-sm-2" type="date" placeholder="End Month"
                             max="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-info my-2 my-sm-0" type="submit">Filter</button>
            </form>
        </div>


       
    </div>
    <br>
    <hr>
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
    

    <div id="div_print" class="container">
        <div class="row ">
        <div class="col">
            <a href="{{url('createworkorders')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-success">Create new Work Order</button>
            </a>
        </div>
            <div class="col">
            <a href="{{url('rejected/work/orders')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-danger">rejected Work Orders
                </button>
            </a>
        </div>

          
           
         <?php
use App\User;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
use Carbon\Carbon;
 ?>
<!-- SOMETHING STRANGE HERE -->
          @if(auth()->user()->type == 'CLIENT')
       @else
          <button style="max-height: 40px;" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
  <i class="fa fa-file-pdf-o"></i> PDF
</button>
@endif

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('pdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>
      <div class="modal-body">
        
      <div class="row">

         <div class="col">From <input name="start" value="<?php
                if (request()->has('start')) {   echo $_GET['start'];   } ?>" class="form-control mr-sm-2" type="date" placeholder="Start Month"   max="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col">   To <input value="<?php  if (request()->has('end')) {  echo $_GET['end'];   } ?>"   name="end" class="form-control mr--2" type="date" placeholder="End Month"   max="<?php echo date('Y-m-d'); ?>">
             </div>  
      </div>
      
      </div>
      <div class="modal-body">
        
      <div class="row">
        <div class="col">
            <select name="problem_type" class="form-control mr-sm-2">
                <option value="" selected="selected">Select Problem Type</option>
                <?php
                  $prob = WorkOrder::select('problem_type')->distinct()->get();
                  foreach ($prob as $problem) {
                    echo "<option value='".$problem->problem_type."'>".$problem->problem_type."</option>";
                  }
                 ?>
            </select>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col">
          <select name="location" class="form-control mr-sm-2">
                <option value="" selected="selected">Select Location</option>
                <?php
                  $loca = WorkOrder::select('location')->Where('location','<>',null)->distinct()->get();
                  foreach ($loca as $location) {
                    echo "<option value='".$location->location."'>".$location->location."</option>";
                  }
                 ?>
            </select>
      </div>
      </div>
  </div>

  <div class="modal-body">
      <div class="row">
          <div class="col">
            <select name="userid" class="form-control mr-sm-2">
              <option value="">Select name</option>

  <?php
//

  $userwithid = WorkOrder::select('staff_id')->distinct()->get();
   foreach($userwithid as $userwithin){
      $userinid = User::get();

      foreach ($userinid as $usedid) {
        if ($userwithin->staff_id == $usedid['id']) {

              $user = User::Where('id',$usedid['id'])->get();
          foreach ($user as $userwith) 
          {
            
              $sectionised = Section::Where('id',$userwith->section_id)->get();

              foreach ($sectionised as $sectioner) {
                if ($sectioner->id == $userwith->section_id) 
                {
                  $departmentid = Department::Where('id',$sectioner->department_id)->get();
                  foreach ($departmentid as $departmentised) 
                  {
                    if ($departmentised->id == $sectioner->department_id ) 
                    {
                      $directorate = Directorate::Where('id',$departmentised->directorate_id)->get();
                      foreach ($directorate as $directory) {
                        if ($directory->id == $departmentised->directorate_id ) {
                          echo "<option value='".$userwith->id."'>".$userwith->fname." ".$userwith->lname." (".$directory->name."-".$departmentised->name.")</option>";
                        }
                      }
                    }
                  }
                }
              }
            
          }  }
      }
       }

//

      ?>
   
            </select>
          </div>
      </div>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col">
              <select name="status" class="form-control mr-sm-2">
                <option value='' selected="selected">Select status</option>
    <?php $statusago = WorkOrder::select('status')->distinct()->get();
    foreach ($statusago as $statusname) {

     if($statusname->status == -1)
      { echo "<option value='".$statusname->status."'>New</option>";}
     elseif($statusname->status == 1)
      {echo "<option value='".$statusname->status."'>Accepted</option>";}
     elseif($statusname->status == 0)
      {echo"<option value='".$statusname->status."'>Rejected</option>";}
     elseif($statusname->status == 2)
      {echo"<option value='".$statusname->status."'>Closed</option>";}
     elseif($statusname->status == 3)
      {echo"<option value='".$statusname->status."'>Technician assigned</option>";}
     elseif($statusname->status == 4)
      {echo"<option value='".$statusname->status."'>Transportation stage</option>";}
     elseif($statusname->status == 5)
      {echo"<option value='".$statusname->status."'>Pre-implementation</option>";}
     elseif($statusname->status == 6)
      {echo"<option value='".$statusname->status."'>Post implementation</option>";}
     elseif($statusname->status == 7)
      {echo"<option value='".$statusname->status."'>Material requested</option>";}
     elseif($statusname->status == 8)
      {echo"<option value='".$statusname->status."'>Procurement stage</option>";}
     elseif($statusname->status == 9)
      {echo"<option value='".$statusname->status."'>Closed - SATISFIED BY CLIENT</option>";}
     else {echo"<option value='10'>Closed - NOT SATISFIED BY CLIENT</option>";}   
 }
     ?>
              </select>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->
          

    </div>
        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
          <th>WorkOrder ID</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Status</th>
                    <th>Created date</th>
                    <th>Location</th>
                    <th>Duration</th>
                    <th>Actions</th>

                </tr>
                </thead>

                <tbody>

                {{-- CREATE A CLASS WITH DEFINED W.O STASTUS FROM 1-7 THAT WILL CHECK HE STATUS NUMBER AND RETURN STATUS WORDS --}}
                <?php $i = 0;  ?>
                @foreach($wo as $work)

                    @if($work->status !== 0)
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-id">00{{ $work->id }}</td>
                            <td id="wo-details">{{ $work->details }}</td>
                            <td>{{ $work->problem_type }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                            @if($work->status == -1)
                                <td><span class="badge badge-warning">new</span></td>
                            @elseif($work->status == 1)
                                <td><span class="badge badge-success">Accepted</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 0)
                                <td><span class="badge badge-danger">Rejected</span></td>
                            @elseif($work->status == 2)
                                <td><span class="badge badge-success">Temporally Closed</span></td>

                            @elseif($work->status == 30)
                                <td><span class="badge badge-success">Completely Closed</span></td>
                            @elseif($work->status == 3)
                                <td><span class="badge badge-info">technician assigned</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 4)
                                <td><span class="badge badge-info">transportation stage</span> 
                                 <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 5)
                              <td><span class="badge badge-info">pre-implementation</span></td>
                            @elseif($work->status == 6)
                              <td><span class="badge badge-info">post implementation</span></td>
                            @elseif($work->status == 7)
            
                              <td><span class="badge badge-info">material requested</span>
                                <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                            @elseif($work->status == 40)
            
                              <td><span class="badge badge-info">Material Requested Approved Succesifully</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                           @elseif($work->status == 8)
                                  @if(auth()->user()->type == 'CLIENT')
                              <td><span class="badge badge-warning">  Material requested on progress</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-danger">Emergency</span></td>
                                @endif
                                  @else
                              <td><span class="badge badge-info">procurement stage</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                              @endif
                            @elseif($work->status == 9)
                              <td><span class="badge badge-info">Closed Satisfied by Client</span></td>

                            @elseif($work->status == 18)
                              @if(auth()->user()->type != 'CLIENT')

                               <td><span class="badge badge-info">Please correct your material</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                               @else
                               <td><span class="badge badge-primary">  Material received from store!</span></td>
                                                             @endif

                             @elseif($work->status == 19)
                               @if(auth()->user()->type != 'CLIENT')
                              <td><span class="badge badge-info">Material missing in store also DES notified</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                              @else
                               <td><span class="badge badge-warning">  Material requested on progress please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-danger">Emergency</span></td>
                                @endif
                                                             @endif
                             @elseif($work->status == 15)
                                                            <td><span class="badge badge-info">Material Accepted by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif

                             @elseif($work->status == 16)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span class="badge badge-danger">Material rejected by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span class="badge badge-warning">  Material requested on progress please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span class="badge badge-warning">Emergency</span></td>
                                @endif
                                                             @endif

                                                            
                              
                              @else
                                <td><span class="badge badge-danger">Closed NOT SATISFIED BY CLIENT</span></td>               
                              @endif
 

                            <td><?php $time = strtotime($work->created_at); echo date('d/m/Y',$time);  ?> </td>
                            <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}</td>
                            @else

                                {{ $work->location }}
                            @endif
                                      <td>
                             @if($work->status == 2) 
                             <?php $date = Carbon::parse($work->created_at);
$now = Carbon::parse($work->updated_at);

$diff = $date->diffInDays($now);  echo $diff." Day(s)"; ?>
                             @else <?php $date = Carbon::parse($work->created_at);
$now = Carbon::now();

$diff = $date->diffInDays($now);  echo $diff." Day(s)"; ?>
                             @endif
                            </td>

                            <td>
                                @if(strpos(auth()->user()->type, "HOS") !== false)


                                    @if($work->status == -1)
                    
                                        <a href=" {{ route('workOrder.view', [$work->id]) }} "><span
                                                    class="badge badge-success">View</span></a>
                                     @elseif($work->status == 2)
                     <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                  
                     <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                        @elseif($work->status == 12)
                                         <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                    <a onclick="myfunc('{{ $work->unsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>

                                   @elseif($work->status == 30 )
                                    <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                    

                                    @elseif($work->status == 9)

                                    <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                      @else



                                        <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                    @endif
                                @else
                                    @if($work->status == -1)
                                        <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                        <br>
                                          @if(auth()->user()->type == 'Maintenance coordinator')
                                 <a href="#"><span data-toggle="modal" data-target="#redirect"
                                                                         class="badge badge-primary">Redirect..</span></a>
                                       @endif


                                                @elseif($work->status == 12)
                                         <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                    <a onclick="myfunc('{{ $work->unsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>
                                    @else
                                        {{--<a href="{{ route('workOrder.view', [$work->id]) }}" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>--}}
                                        &nbsp;
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>&nbsp;
                                    @endif
                                @endif

                                @endif
                                <br>
                              
                            </td>
                             
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no work oder</h1>
        @endif
    </div>

     <!-- Modal -->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: red">Reason as why Client not Satisfied with attended work order.</h5>
                    <div></div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h3 id="unsatisfiedreason"><b> </b></h3>
              </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

 
@foreach($wo as $work)
    <div class="modal fade" id="redirect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
           <form method="POST" action="{{ route('to.HoS.workorder', [$work->id]) }}">     
                @csrf
            <div class="modal-content" style="height: 430px; width: 400px;" >
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel" ><b>Choose problem type as you want to redirect.</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

   
                <div class="modal-body">

                     <div class="col">
                <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label style="height: 28px" class="input-group-text" for="inputGroupSelect01">Type of problem</label>
            </div>
            <select required style="width: 300px;min-width: 150px;" id="nameid" name="p_type">
                <option selected value="">Choose...</option>
                <option value="Carpentry/Painting">Carpentry/Painting</option>
                <option value="Electrical">Electrical</option>
                <option value="Masonry/Road">Masonry/Road</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Plumbing">Plumbing</option>
            </select>
             </div>
            </div>
            </div>
                <div class="modal-footer">
                </div>

         <button type="submit" class="btn btn-primary ">Send to Head of Section</button>
    </form>
            </div>
        </div>
    </div>
    @endforeach
    
    
    <script>

        

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });

         function myfunc(x) {
            document.getElementById("unsatisfiedreason").innerHTML = x;
        }
    </script>
    @endSection