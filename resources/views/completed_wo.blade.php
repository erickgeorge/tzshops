@extends('layouts.master')

@section('title')
    Unattended work orders
    @endSection

@section('body')
<?php
use App\User;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
 ?>
    <br>
    <div class="row container-fluid" style="margin-top: 6%; margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h3><b>Unattended Work orders</b></h3>
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
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Filter</button>
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

    
   
    <div  id="div_print" class="container" style="margin-right: 2%; margin-left: 2%;">
      <!-- SOMETHING STRANGE HERE -->
                <div class="col" align="right">
           <button data-toggle="modal" class="btn btn-outline-primary mb-2" data-target="#exampleModal"><i class="fa fa-file-pdf-o"></i> PDF </button>
        </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('unattendedwopdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To <i class="fa fa-file-pdf-o"></i> PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="name" class="form-control mr-sm-2">
                    <option selected="selected" value="">name</option>
                    <?php
////////////WADUDUUUUUUUUUUUU

  $userwithid = WorkOrder::select('staff_id')->Where('status','-1')->distinct()->get();
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

//WADUDUUUUUUUUUUUUUUUUUUUUUUU

      ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="problem_type" class="form-control mr-sm-2">
                    <option value="" selected="selected">Problem type</option>
                    <?php
                    $type = WorkOrder::select('problem_type')->distinct()->Where('status','-1')->get();
                    foreach ($type as $typo) {
                        echo "<option value='".$typo->problem_type."'>".$typo->problem_type."</option>";
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
                    <option value="" selected="selected">Location</option>
                    <?php
                    $location = WorkOrder::select('location')->distinct()->Where('status','-1')->get();
                    foreach ($location as $located) {
                        echo "<option value='".$located->location."'>".$located->location."</option>";
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
        @if(count($wo) > 0)
            <table class="table table-striped display" id="myTable" style="width:100%">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Status</th>
                    <th>Created date</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>

                {{-- CREATE A CLASS WITH DEFINED W.O STASTUS FROM 1-7 THAT WILL CHECK THE STATUS NUMBER AND RETURN STATUS WORDS --}}
                <?php $i = 0;  ?>
                @foreach($wo as $work)

                  
                        <?php $i++ ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td id="wo-details">{{ $work->details }}</td>
                            <td>{{ $work->problem_type }}</td>
                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                            @if($work->status == -1)
                                <td><span class="badge badge-warning">new</span></td>
                            @elseif($work->status == 1)
                                <td><span class="badge badge-success">accepted</span></td>
                                
                            @elseif($work->status == 2)
                                <td><span class="badge badge-success">CLOSED</span></td>
                            @elseif($work->status == 3)
                                <td><span class="badge badge-info">technician assigned</span></td>
                            @elseif($work->status == 4)
                                <td><span class="badge badge-info">transportation stage</span></td>
                            @elseif($work->status == 5)
                                                            <td><span class="badge badge-info">pre-implementation</span></td>
                            @elseif($work->status == 6)
                                                            <td><span class="badge badge-info">post implementation</span></td>
                            @elseif($work->status == 7)
                                                            <td><span class="badge badge-info">material requested</span></td>
                            @else
                                <td><span class="badge badge-success">procurement stage</span></td>                             
                            @endif
                            
                            <td><?php $time = strtotime($work->created_at); echo date('d/m/Y',$time);  ?></td>
                            <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}</td>
                            @else

                                {{ $work->location }}
                            @endif
                            <td>
                            
                                @if(strpos(auth()->user()->type, "HOS") !== false)

                                    @if($work->status == -1)
                                        <a href=" {{ route('workOrder.view', [$work->id]) }} "><span
                                                    class="badge badge-success">View</span></a>
                                    @elseif($work->status == 2)
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
                                    @else
                                        {{--<a href="{{ route('workOrder.view', [$work->id]) }}" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>--}}
                                        &nbsp;
                                        <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>&nbsp;
                                    @endif
                              

                                @endif
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">Currently no available unattended work order</h1>
        @endif
    </div>
    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });


        });
        
        
        function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body><h1> Completed Work orders list </h1>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
//var exclude = document.getElementByid('exclude').innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;

window.print();
document.body.innerHTML = oldstr;
return false;
}

    </script>
    </div>
    @endSection