@extends('layouts.master')

@section('title')
    work orders
    @endSection

@section('body')
@if(count($wo) > 0)
    <br>
    <div class="row container-fluid" style="margin-left: 4%; margin-right: 4%;">
        <div class="col-md-6">
            <h5 style=" "><b style="text-transform: capitalize;">Works orders with duration </b></h5>
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
        @endif



    </div>
    <br>
    <hr>
    <div style="margin-right: 2%; margin-left: 2%;">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif


    <div id="div_print" class="container">

   <!-- SOMETHING STRANGE HERE -->
                  <?php
use App\User;
use App\Directorate;
use App\Department;
use App\Section;
use App\WorkOrder;
 ?>
         <!-- SOMETHING STRANGE HERE -->
         @if(count($wo) > 0)
                <div class="col" align="right">
           <button data-toggle="modal" class="btn btn-primary mb-2" data-target="#exampleModal">  Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
        </div>
        @endif
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="GET" action="{{ url('wowithdurationpdf') }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
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
///////////

  $userwithid = WorkOrder::select('staff_id')->Where('status','2')->distinct()->get();
   foreach($userwithid as $userwithin){
      $userinid = User::get();

      foreach ($userinid as $usedid) {
        if ($userwithin->staff_id == $usedid['id']) {

              $user = User::Where('id',$usedid['id'])->get();
          foreach ($user as $userwith)
          {


                  $departmentid = Department::Where('id',$userwith->section_id)->get();
                  foreach ($departmentid as $departmentised)
                  {
                    if ($departmentised->id == $departmentised->department_id )
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


//

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
                    $type = WorkOrder::select('problem_type')->distinct()->Where('status','2')->get();
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
                    $location = WorkOrder::select('location')->distinct()->Where('status','2')->get();
                    foreach ($location as $located) {
                        echo "<option value='".$located->location."'>".$located->location."</option>";
                    }

                     ?>
                </select>
            </div>
        </div>
      </div>
    <?php /*   <div class="modal-body">
        <div class="row">
            <div class="col">
                <select name="date" class="form-control mr-sm-2">
                    <option value="" selected="selected">Duration</option>
                    <?php
                    $loca = WorkOrder::Where('status','2')->get();
                    foreach ($loca as $local) {
                        $datetime1 = $local->created_at;
                            $datetime2 = $local->updated_at;

                            $interval = date_diff($datetime1, $datetime2);

                            echo "<option value='".$datetime1."&end=".$datetime2."'>".$interval->format('%a')." Week(s)</option>";
                    }

                     ?>
                </select>
            </div>
        </div>
      </div> */?>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Export</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
</form>
  </div>
</div>
          <!-- ---------------------- -->
        @if(count($wo) > 0)
            <table class="table table-responsive table-striped display" id="myTable" style="width:100%">
                <thead >
               <tr style="color: white;">

                    <th>WO ID</th>
                    <th>Details</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>Location</th>
                     <th>Duration</th>
                    <th id="exclude1">Actions</th>
                </tr>
                </thead>

                <tbody>
<?php $i = 0;  ?>
                @foreach($wo as $work)





                        <tr>

                            <td id="wo-details"> {{ $work->id }}</td>
                            <td>{{ str_limit($work->details, 10) }}  </td>
                            <td>{{ $work->problem_type }}  </td>




                            <td>{{ $work['user']->fname.' '.$work['user']->lname }}</td>
                             <td>

                                @if($work->location ==null)
                                    {{ $work['room']['block']->location_of_block }}</td>
                            @else

                                {{ $work->location }}  </td>
                            @endif
                         <?php
                            $datetime1 = $work->created_at;
                            $datetime2 = $work->updated_at;

                            $interval = date_diff($datetime1, $datetime2);


                         ?>
                         <td>{{ $interval->format('%a') }}  </td>


                            <td id="exclude2">

                                       <a style="color: black;" href="{{ route('workOrder.track', [$work->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i> Track</a>
                                                    </td>


                        </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h1 class="text-center" style="margin-top: 150px">You have no works oder</h1>
        @endif
    </div>
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
var headstr = "<html><head><title></title></head><body><h1> Work orders Duration list </h1>";
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


    @endSection
