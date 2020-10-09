@extends('layouts.master')

@section('title')
    works orders
    @endSection

@section('body')
<br>
<?php
use App\User;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
use Carbon\Carbon;
 ?>
@if((auth()->user()->type == 'CLIENT')&&($role['user_role']['role_id'] != 1))
<!--  -->
<br>
    <div class="container">
    <div class="row container-fluid" >
        <div class="col-md-6">

            <h5 ><b>All Works Orders List </b></h5>


        </div>
@if(count($wo) > 0)
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

@endif

    </div>
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


    <div id="div_print" class="container">
        <div class="row ">
        <div class="col">
            <a href="{{url('createworkorders')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-primary">Create new works order</button>
            </a>
        </div>






<!-- SOMETHING STRANGE HERE -->
@if(count($wo) > 0)
          @if(auth()->user()->type == 'CLIENT')
          <button style="max-height: 40px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button>
       @else
          <button style="max-height: 40px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button>
@endif
@endif

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('pdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
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
            <select id="typeselector1" name="problem_type" class="form-control mr-sm-2" onchange="getlocation1()">
                <option value="" selected="selected">Select Problem Type</option>
                <?php
                  $prob = WorkOrder::select('problem_type')->where('client_id',auth()->user()->id)->distinct()->get();
                  foreach ($prob as $problem) {
                    echo "<option value='".$problem->problem_type."'>".ucwords(strtolower($problem->problem_type))."</option>";
                  }
                 ?>
            </select>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col">
          <select id="locationselector1" name="location" class="form-control mr-sm-2">
                <option value="" selected="selected">Select Location</option>
<?php
                 $loca = WorkOrder::select('location')->where('client_id',auth()->user()->id)->Where('location','<>',null)->distinct()->get();
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
            <select name="userid" id="nameselector1" class="form-control mr-sm-2">
              @if(auth()->user()->type == 'CLIENT')
              <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
              @else
              <option value="">Select name</option>



  <?php
//

  $userwithid = WorkOrder::select('client_id')->where('client_id',auth()->user()->id)->distinct()->get();
foreach($userwithid as $userwithid)
{

  $userfetch = user::where('id',$userwithid->client_id)->get();
  foreach($userfetch as $userfetch)
  {
      //echo '<option>yay</option>';



      $departmentor = department::where('id',$userfetch->section_id)->get();
      foreach($departmentor as $departmentor)
      {

          $directora = directorate::where('id',$departmentor->directorate_id)->get();
          foreach($directora as $directora){?>
<option value="{{ $userfetch->id }}">{{ $userfetch->fname }} {{ $userfetch->lname }} - {{ $directora->name }}</option>
          <?php }
      }


  }
}

      ?>
   @endif
            </select>
          </div>
      </div>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col">
              <select id="statusselector1" name="status" class="form-control mr-sm-2">
                <option value='' selected="selected">Select status</option>
    <?php $statusago = WorkOrder::select('status')->where('client_id',auth()->user()->id)->distinct()->get();
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
      {echo"<option value='".$statusname->status."'>Technician assigned for work</option>";}
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
    elseif($statusname->status == 30)
      { echo "<option value='".$statusname->status."'>Completly Closed</option>";}
     elseif($statusname->status == 70)
      { echo "<option value='".$statusname->status."'>Technician assigned for Inspection</option>";}
     elseif($statusname->status == 40)
      { echo "<option value='".$statusname->status."'>Material Requested Approved Succesifully</option>";}
     elseif($statusname->status == 52)
      { echo "<option value='".$statusname->status."'>Iow is checking for Works Order</option>";}
     elseif($statusname->status == 53)
      { echo "<option value='".$statusname->status."'>Works Order is not approved by IoW</option>";}
     elseif($statusname->status == 25)
      { echo "<option value='".$statusname->status."'>Succesifully approved by IoW</option>";}
     elseif($statusname->status == 18)
      { echo "<option value='".$statusname->status."'>Correct your Material</option>";}
     elseif($statusname->status == 19)
      { echo "<option value='".$statusname->status."'>Material missing in store</option>";}
     elseif($statusname->status == 15)
      { echo "<option value='".$statusname->status."'>Material accepted by IoW</option>";}
     elseif($statusname->status == 55)
      { echo "<option value='".$statusname->status."'>Materia on check by IoW</option>";}
     elseif($statusname->status == 57)
      { echo "<option value='".$statusname->status."'>Material on check by IoW by HoS</option>";}
     elseif($statusname->status == 9)
      {echo"<option value='".$statusname->status."'>Closed - SATISFIED BY CLIENT</option>";}
    
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
        <div class="container">
            <table class="table table-striped table-responsive display" id="myTable" style="width:100%">
                <thead >
                <tr style="color: white;">
                    <th>#</th>
          <th>ID</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th style="width: 100px;">Status</th>
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

                            <td id="wo-details">  <?php if (strlen($work->details) > 20) {
                             echo substr($work->details, 0, 20); echo "...";
                            }
                              else{
                                echo $work->details;
                              } ?>

                              </td>
                            <td>{{ ucwords(strtolower($work->problem_type)) }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                            @if($work->status == -1)
                                <td><span>new</span>
                                <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif($work->status == 1)
                                <td><span>Accepted</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span">Emergency</span></td>
                                @endif
                            @elseif($work->status == 0)
                                <td><span>Rejected</span></td>
                            @elseif($work->status == 2)
                                <td><span>Waiting response from client</span></td>

                            @elseif($work->status == 30)
                                <td><span>Completely Closed</span></td>
                            @elseif($work->status == 3)
                                <td><span>technician assigned for work</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                             @elseif($work->status == 70)
                                <td><span>technician assigned <br> for inspection</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif

                            @elseif($work->status == 4)
                                <td><span>transportation stage for inspection</span>
                                 <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif

                             @elseif($work->status == 101)
                                <td><span>transportation stage for work</span>
                                 <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif($work->status == 5)
                              <td><span>pre-implementation</span></td>
                            @elseif($work->status == 6)
                              <td><span>post implementation</span></td>
                            @elseif($work->status == 7)

                              <td><span>material requested</span>
                                <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif($work->status == 40)

                              <td><span>Material Requested <br>Approved Succesifully</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                           @elseif($work->status == 52)

                              <td><span>IoW is checking for Works Order</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                           @elseif(($work->status == 53) and ($work->iowreject != 3))

                              <td><span>Works Order not  approved by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif(($work->status == 53) and ($work->iowreject == 3))

                              <td><span>Works order is on check by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif    

                          @elseif($work->status == 25)

                              <td><span>Works Order Succesifully <br> approved by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                           @elseif($work->status == 8)
                                  @if(auth()->user()->type == 'CLIENT')
                              <td><span>  Material requested on progress</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                  @else
                              <td><span>procurement stage</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                              @endif
                            @elseif($work->status == 9)
                              <td><span>Closed Satisfied by Client</span></td>

                            @elseif($work->status == 18)
                              @if(auth()->user()->type != 'CLIENT')

                               <td><span>Please correct your material</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                               @else
                               <td><span>  Material received from store!</span></td>
                                                             @endif

                             @elseif($work->status == 19)
                               @if(auth()->user()->type != 'CLIENT')
                              <td><span>Material missing in store, <br>Head Procurement  notified</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                              @else
                               <td><span>  Material requested on progress <br> please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif
                               @elseif($work->status == 15)
                                                            <td><span>Material Accepted by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif

                                @elseif($work->status == 55)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span>Some of Material Rejected</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span>Material on Check by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif

                                @elseif($work->status == 57)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span>Material Requested Again</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span>Material on Check by IoW and HoS</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif

                                @elseif($work->status == 16)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span>Material rejected by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span>  Material requested on progress please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif



                              @else
                                <td><span>Closed NOT SATISFIED BY CLIENT</span></td>
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

                                         @if($work->client_id == auth()->user()->id )
                                        <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                         @else

                                        <a href=" {{ route('workOrder.view', [$work->id]) }} "><span
                                                    class="badge badge-success">View</span></a>

                                         @endif
                                     @elseif($work->status == 2)

                                       @if($work->client_id != auth()->user()->id )

                     <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                          &nbsp; @endif

                     <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                        @elseif($work->status == 12)

                                                         @if($work->client_id != auth()->user()->id )
                                         <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>

                                           &nbsp; @endif
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                    <a onclick="myfunc('{{ $work->unsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>
                                                       @elseif($work->status == 53)

                                                        @if($work->client_id != auth()->user()->id )
                                         <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                           &nbsp; @endif
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                    <a onclick="myfunc('{{ $work->notsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>

                                   @elseif($work->status == 30 )
                                    <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>


                                    @elseif($work->status == 9)

                                    <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                      @else


                                           @if($work->client_id != auth()->user()->id )
                                        <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>  &nbsp; @endif
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                    @endif


                                @else
                                    @if($work->status == -1)
                                        <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                        @if($diff > 6)
                                        @if( $work['user']->id==Auth::user()->id)
                                        <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#exampleModal{{ $work->id }}">Complaint</a>

<!-- SOMETHING STRANGE HERE -->
<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $work->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ url('Complaint') }}">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Complaint Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>

  <div class="modal-body">
      <div class="row">
          <div class="col">
            <select name="name" class="form-control mr-sm-2" required="">
              <option selected="selected" value=""> Send To :</option>
             <?php $mtu = user::where('type','like','%Maintenance Coordinator%')->orWhere('type','like','%Director%')->get(); ?>
             @foreach($mtu as $mt)
             <option value="{{ $mt->id }}">{{ $mt->fname }} {{ $mt->lname }} - {{ $mt->type }}</option>
             @endforeach
            </select>
          </div>
      </div>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col">
 <div class="input-group">
  <textarea class="form-control" name="message" aria-label="With textarea" required="">Message</textarea>
</div>
          </div>
      </div>
      </div>
      <input type="text" name="work" hidden value="{{ $work->id }}">
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
                                        <br>
                                          @if(auth()->user()->type == 'Maintenance coordinator')

                                          @if($work->redirectwo == 1)
                                                                         <span class="badge badge-warning">Redirected</span>
                                                                         @else
                                        <!--   <a href="#"><span data-toggle="modal" data-target="#redirect"



                       &nbsp;&nbsp;&nbsp;&nbsp;<a style="color: green;"
                                       onclick="myfunc1( '{{ $work->id }}','{{ $work->reason }}')"
                                       data-toggle="modal" data-target="#exampleModali" title="Edit"><i
                                                class="fas fa-times-circle" style="color: red"></i></a>-->


                                      &nbsp;&nbsp;&nbsp;&nbsp;                                  <a
                                       onclick="myfunc5('{{$work->id}}','{{ $work->details }}' ,'{{ $work->p_type }}')"
                                       data-toggle="modal" data-target="#exampleModo"><i
                                  class="fas fa-recycle"  data-toggle="tooltip" data-placement="right" title="Redirect to Head of Section" style="color: blue"></i></a>

                                                                         @endif
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

                                @if(auth()->user()->type == 'Inspector Of Works' )
                                  @if($work->status == 53)


                                                    <a onclick="myfunc('{{ $work->notsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>

                                   @endif
                                   @endif
                                <br>

                            </td>

                        </tr>
                        @endforeach
                </tbody>
            </table>
          </div>
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no works order</h1>
            <div class="container" align="center">
              <br>
           <!-- <div class='row'>
              <div class="col-sm-3">
                <a href="{{ url('dashboard') }}" class="btn btn-primary">Dashboard</a>
              </div>
            </div>-->
            </div>
        @endif
    </div>

     <!-- Modal -->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: blue">Reason as why client not satisfied with attended works order.</h5>
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

    <div class="modal fade" id="exampleModo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

                <form method="POST" action="redirect/workorder/to/hos"
                  class="col-md-6">
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
            <select  style="width: 300px;min-width: 150px;" id="p_type" name="p_type">
                <option selected value="">Choose...</option>
                <option value="Carpentry/Painting">Carpentry/Painting</option>
                <option value="Electrical">Electrical</option>
                <option value="Masonry/Road">Masonry/Road</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Plumbing">Plumbing</option>
            </select>
             <!--<input  type="text" name="details"  id="details">-->
             <input hidden id="redirect_id" name="redirect_id" >

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
@else

    <br>
    <div class="container">
    <div class="row container-fluid" >
        <div class="col-md-6">

            <h5 ><b>On Progress Works Orders List </b></h5>


        </div>
@if(count($wo) > 0)
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

@endif

    </div>
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


    <div id="div_print" class="container">
        <div class="row ">
        <div class="col">
            <a href="{{url('createworkorders')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-primary">Create new works order</button>
            </a>
        </div>
         <div class="col">
            <a href="{{url('completed_works_order')}} ">
                <button  type="button" class="btn btn-success">Completed works orders
                </button>
            </a>
        </div>

        <div class="col">
            <a href="{{url('rejected/work/orders')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-danger">Rejected works orders
                </button>
            </a>
        </div>






<!-- SOMETHING STRANGE HERE -->
@if(count($wo) > 0)
          @if(auth()->user()->type == 'CLIENT')
          <button style="max-height: 40px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button>
       @else
          <button style="max-height: 40px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</button>
@endif
@endif

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('pdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
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
            <select id="typeselector1" name="problem_type" class="form-control mr-sm-2" onchange="getlocation1()">
                <option value="" selected="selected">Select Problem Type</option>
                <?php
                  $prob = WorkOrder::select('problem_type')->distinct()->get();
                  foreach ($prob as $problem) {
                    echo "<option value='".$problem->problem_type."'>".ucwords(strtolower($problem->problem_type))."</option>";
                  }
                 ?>
            </select>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col">
          <select id="locationselector1" name="location" class="form-control mr-sm-2">
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
            <select name="userid" id="nameselector1" class="form-control mr-sm-2">
              @if(auth()->user()->type == 'CLIENT')
              <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
              @else
              <option value="">Select name</option>



  <?php
//

  $userwithid = WorkOrder::select('client_id')->distinct()->get();
foreach($userwithid as $userwithid)
{

  $userfetch = user::where('id',$userwithid->client_id)->get();
  foreach($userfetch as $userfetch)
  {
      //echo '<option>yay</option>';



      $departmentor = department::where('id',$userfetch->section_id)->get();
      foreach($departmentor as $departmentor)
      {

          $directora = directorate::where('id',$departmentor->directorate_id)->get();
          foreach($directora as $directora){?>
<option value="{{ $userfetch->id }}">{{ $userfetch->fname }} {{ $userfetch->lname }} - {{ $directora->name }}</option>
          <?php }
      }


  }
}

      ?>
   @endif
            </select>
          </div>
      </div>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col">
              <select id="statusselector1" name="status" class="form-control mr-sm-2">
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
      {echo"<option value='".$statusname->status."'>Technician assigned for work</option>";}
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
    elseif($statusname->status == 30)
      { echo "<option value='".$statusname->status."'>Completly Closed</option>";}
     elseif($statusname->status == 70)
      { echo "<option value='".$statusname->status."'>Technician assigned for Inspection</option>";}
     elseif($statusname->status == 40)
      { echo "<option value='".$statusname->status."'>Material Requested Approved Succesifully</option>";}
     elseif($statusname->status == 52)
      { echo "<option value='".$statusname->status."'>Iow is checking for Works Order</option>";}
     elseif($statusname->status == 53)
      { echo "<option value='".$statusname->status."'>Works Order is not approved by IoW</option>";}
     elseif($statusname->status == 25)
      { echo "<option value='".$statusname->status."'>Succesifully approved by IoW</option>";}
     elseif($statusname->status == 18)
      { echo "<option value='".$statusname->status."'>Correct your Material</option>";}
     elseif($statusname->status == 19)
      { echo "<option value='".$statusname->status."'>Material missing in store</option>";}
     elseif($statusname->status == 15)
      { echo "<option value='".$statusname->status."'>Material accepted by IoW</option>";}
     elseif($statusname->status == 55)
      { echo "<option value='".$statusname->status."'>Materia on check by IoW</option>";}
     elseif($statusname->status == 57)
      { echo "<option value='".$statusname->status."'>Material on check by IoW by HoS</option>";}
     elseif($statusname->status == 9)
      {echo"<option value='".$statusname->status."'>Closed - SATISFIED BY CLIENT</option>";}
    
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
        <div class="container">
            <table class="table table-striped table-responsive display" id="myTable" style="width:100%">
                <thead >
                <tr style="color: white;">
                    <th>#</th>
          <th>ID</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th style="width: 100px;">Status</th>
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

                            <td id="wo-details">  <?php if (strlen($work->details) > 20) {
                             echo substr($work->details, 0, 20); echo "...";
                            }
                              else{
                                echo $work->details;
                              } ?>

                              </td>
                            <td>{{ ucwords(strtolower($work->problem_type)) }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                          @if($work->status == -1)
                                <td><span>new</span> <br>
                               @if(auth()->user()->type == 'Maintenance coordinator')
                                 @if($work->problem_type == 'Others')
                                   @if($work->redirectedhos == null)
                                      <span>From HoS</span>
                                      @else
                                      <span>Redirected by HoS</span>
                                      @endif
                                  @endif
                               @endif    
                                <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif($work->status == 1)
                                <td><span>Accepted</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span">Emergency</span></td>
                                @endif
                            @elseif($work->status == 0)
                                <td><span>Rejected</span></td>
                            @elseif($work->status == 2)
                                <td><span>Waiting response from client</span></td>

                            @elseif($work->status == 30)
                                <td><span>Completely Closed</span></td>
                            @elseif($work->status == 3)
                                <td><span>technician assigned for work</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                             @elseif($work->status == 70)
                                <td><span>technician assigned <br> for inspection</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif

                            @elseif($work->status == 4)
                                <td><span>transportation stage for inspection</span>
                                 <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif

                             @elseif($work->status == 101)
                                <td><span>transportation stage for work</span>
                                 <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif($work->status == 5)
                              <td><span>pre-implementation</span></td>
                            @elseif($work->status == 6)
                              <td><span>post implementation</span></td>
                            @elseif($work->status == 7)

                              <td><span>material requested</span>
                                <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif($work->status == 40)

                              <td><span>Material Requested <br>Approved Succesifully</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                           @elseif($work->status == 52)

                              <td><span>IoW is checking for Works Order</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                           @elseif(($work->status == 53) and ($work->iowreject != 3))

                              <td><span>Works Order not  approved by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                            @elseif(($work->status == 53) and ($work->iowreject == 3))

                              <td><span>Works order is on check by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif    

                          @elseif($work->status == 25)

                              <td><span>Works Order Succesifully <br> approved by IoW</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                           @elseif($work->status == 8)
                                  @if(auth()->user()->type == 'CLIENT')
                              <td><span>  Material requested on progress</span>
                                  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                  @else
                              <td><span>procurement stage</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                              @endif
                            @elseif($work->status == 9)
                              <td><span>Closed Satisfied by Client</span></td>

                            @elseif($work->status == 18)
                              @if(auth()->user()->type != 'CLIENT')

                               <td><span>Please correct your material</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                               @else
                               <td><span>  Material received from store!</span></td>
                                                             @endif

                             @elseif($work->status == 19)
                               @if(auth()->user()->type != 'CLIENT')
                              <td><span>Material missing in store, <br>Head Procurement  notified</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                              @else
                               <td><span>  Material requested on progress <br> please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif
                               @elseif($work->status == 15)
                                                            <td><span>Material Accepted by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif

                                @elseif($work->status == 55)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span>Some of Material Rejected</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span>Material on Check by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif

                                @elseif($work->status == 57)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span>Material Requested Again</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span>Material on Check by IoW and HoS</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif

                                @elseif($work->status == 16)
                                                          @if(auth()->user()->type != 'CLIENT')
                                                            <td><span>Material rejected by IoW</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                            @else
                                                             <td><span>  Material requested on progress please wait!</span>  <br>
                                @if($work->emergency == 1)
                                <span>Emergency</span></td>
                                @endif
                                                             @endif



                              @else
                                <td><span>Closed NOT SATISFIED BY CLIENT</span></td>
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
                               @if(auth()->user()->type == 'Maintenance coordinator')
                               @if(($work->status != -1) and ($work->status != 53) )
                                <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                               @endif
                               @endif
                                @if(strpos(auth()->user()->type, "HOS") !== false)


                                        @if($work->status == -1)

                                         @if($work->client_id == auth()->user()->id )
                                        <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                         @else

                                        <a href=" {{ route('workOrder.view', [$work->id]) }} "><span
                                                    class="badge badge-success">View</span></a>

                                         @endif
                                
                               @elseif($work->status == 2)

                               @if($work->client_id != auth()->user()->id )

                     <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                          &nbsp; @endif

                     <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                        @elseif($work->status == 12)

                                                         @if($work->client_id != auth()->user()->id )
                                         <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>

                                           &nbsp; @endif
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                    <a onclick="myfunc('{{ $work->unsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>
                                                       @elseif($work->status == 53)

                                                        @if($work->client_id != auth()->user()->id )
                                         <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                           &nbsp; @endif
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                                    <a onclick="myfunc('{{ $work->notsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>

                                   @elseif($work->status == 30 )
                                    <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>


                                    @elseif($work->status == 9)

                                    <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                      @else


                                           @if($work->client_id != auth()->user()->id )
                                        <a style="color: green;" href="{{ url('edit/work_order/view', [$work->id]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>  &nbsp; @endif
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>
                                    @endif


                                @else
                                    @if($work->status == -1)
                                      @if(auth()->user()->type != 'Maintenance coordinator')
                                        <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                     @endif   
                                        @if($diff > 6)
                                        @if( $work['user']->id==Auth::user()->id)
                                        <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#exampleModal{{ $work->id }}">Complaint</a>

<!-- SOMETHING STRANGE HERE -->
<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $work->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ url('Complaint') }}">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Complaint Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>

  <div class="modal-body">
      <div class="row">
          <div class="col">
            <select name="name" class="form-control mr-sm-2" required="">
              <option selected="selected" value=""> Send To :</option>
             <?php $mtu = user::where('type','like','%Maintenance Coordinator%')->orWhere('type','like','%Director%')->get(); ?>
             @foreach($mtu as $mt)
             <option value="{{ $mt->id }}">{{ $mt->fname }} {{ $mt->lname }} - {{ $mt->type }}</option>
             @endforeach
            </select>
          </div>
      </div>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col">
 <div class="input-group">
  <textarea class="form-control" name="message" aria-label="With textarea" required="">Message</textarea>
</div>
          </div>
      </div>
      </div>
      <input type="text" name="work" hidden value="{{ $work->id }}">
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
                                        <br>
                                          @if(auth()->user()->type == 'Maintenance coordinator')
                                             @if($work->client_id == auth()->user()->id )
                                              <a href="#"><span class="badge badge-success">Waiting...</span></a>
                                              @else
                                                 @if($work->status == -1)
                                                <a href=" {{ route('workOrder.view', [$work->id]) }} "><span
                                                    class="badge badge-success">View</span></a>
                                                 @endif

                                             @endif


                                          <!--@if($work->redirectwo == 1)
                                                                         <span class="badge badge-primary">Redirected</span>
                                          @endif -->
                                          
                                          @if($work->problem_type == 'Others')                             
                                                                        
                                        <!--   <a href="#"><span data-toggle="modal" data-target="#redirect"



                                   &nbsp;&nbsp;&nbsp;&nbsp;<a style="color: green;"
                                       onclick="myfunc1( '{{ $work->id }}','{{ $work->reason }}')"
                                       data-toggle="modal" data-target="#exampleModali" title="Edit"><i
                                                class="fas fa-times-circle" style="color: red"></i></a>-->


                                    <!--  &nbsp;&nbsp;&nbsp;&nbsp;                                  <a
                                       onclick="myfunc5('{{$work->id}}','{{ $work->details }}' ,'{{ $work->p_type }}')"
                                       data-toggle="modal" data-target="#exampleModo"><i
                                  class="fas fa-recycle"  data-toggle="tooltip" data-placement="right" title="Redirect to Head of Section" style="color: blue"></i></a>-->

                                         @endif
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

                                @if(auth()->user()->type == 'Inspector Of Works' )
                                  @if($work->status == 53)


                                                    <a onclick="myfunc('{{ $work->notsatisfiedreason }}')"><span data-toggle="modal" data-target="#viewReason"
                                                                         class="badge badge-success">View reason</span></a>

                                   @endif
                                   @endif
                                <br>

                            </td>

                        </tr>
                        @endforeach
                </tbody>
            </table>
          </div>
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no works order</h1>
            <div class="container" align="center">
              <br>
           <!-- <div class='row'>
              <div class="col-sm-3">
                <a href="{{ url('dashboard') }}" class="btn btn-primary">Dashboard</a>
              </div>
            </div>-->
            </div>
        @endif
    </div>

     <!-- Modal -->
    <div class="modal fade" id="viewReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: blue">Reason as why client not satisfied with attended works order.</h5>
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





    @endif
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

          <script type="text/javascript">

                         function myfunc5(U, V , W) {


            document.getElementById("redirect_id").value = U;

            document.getElementById("details").value = V;

            document.getElementById("p_type").value = W;
                                }

        </script>


    @endSection
