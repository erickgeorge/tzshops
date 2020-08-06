@extends('layouts.land')

@section('title')
Assessment form
@endSection

@section('body')


<div class="container" >
    <br>
     <div class="row">
      <div class="col">
            <h5 ><b style="text-transform: capitalize;">All Assessment forms </b></h5>

        </div>

        <div>
            <form method="GET" action="{{route('assessmentform.view')}}" class="form-inline my-2 my-lg-0">
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

                <a href="{{route('assessmentform.view')}}"><button style="max-height: 40px; " type="button" class="btn btn-primary" >
                  Curent assessments
                </button></a>



                 <button style="max-height: 40px; float:right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                   Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </button>



                <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('assessments')}}">
             @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export To   PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Filter your data</span>
        </button>
      </div>

  <div class="modal-body">



        <div class="row">


               <div class="col"> From <input name="start" value="<?php
                if (request()->has('start')) {
                    echo $_GET['start'];
                } ?>"  class="form-control mr-sm-2"type="month" placeholder="Start Month"
                               max="<?php echo date('Y-m'); ?>">
                </div>

                <div class="col">
                To <input value="<?php
                if (request()->has('end')) {
                    echo $_GET['end'];
                } ?>"
                             name="end"  class="form-control mr-sm-2" type="month" placeholder="End Month"
                             max="<?php echo date('Y-m'); ?>">
                </div>
       </div>
<br>


        <div class="row">
          <div class="col">
              <select name="tender" class="form-control mr-sm-2">
                <option value='' selected="selected">Select tender number</option>
                 @foreach($assessmmenttender as $assestender)

                    <option value='{{$assestender->company}}'>{{$assestender->company}}</option>

                 @endforeach
              </select>
          </div>
      </div>

      <br>

              <div class="row">
          <div class="col">
              <select name="company" class="form-control mr-sm-2">
                <option value='' selected="selected">Select company name</option>
                 @foreach($assessmmentcompanygr as $assescomp)

                    <option value='{{$assescomp->company_id}}'>{{$assescomp['companyname']['compantwo']->company_name}}</option>

                 @endforeach
              </select>
          </div>
      </div>

      <br>

              <div class="row">
          <div class="col">
              <select name="area" class="form-control mr-sm-2">
                <option value='' selected="selected">Select area name</option>
                 @foreach($assessmmentareass as $assesarea)

                    <option value='{{$assesarea->area_id}}'>{{$assesarea['areaname']->cleaning_name}}</option>

                 @endforeach
              </select>
          </div>
      </div>

      <br>

      <div class="row">
          <div class="col">
              <select name="statuses" class="form-control mr-sm-2">
                <option value='' selected="selected">Select status</option>
                 @foreach($assessmmentstatus as $assesment)
                  @if($assesment->status == 1)
                            <option value='1'><span class="badge badge-danger">No assessment form submitted yet</span></option>
                             @elseif($assesment->status == 2)
                           </option value='2'> <span class="badge badge-primary">Crosscheck assessment form</span> </option>
                             @elseif($assesment->status == 3)
                           <option value='3'>  <span class="badge badge-warning">Submitted to Estate Officer<br> for approval</span> </option>
                             @elseif($assesment->status == 4)
                            <option value='4'>  <span class="badge badge-primary">Approved by Estate Officer</span> </option>
                             @elseif($assesment->status == 5)
                            <option value='5' > <span class="badge badge-primary">Approved by Estate Director</span> </option>
                             @elseif($assesment->status == 6)
                           <option value='6'>  <span class="badge badge-primary">Submitted to Estate Officer<br> for approval</span> </option>
                             @elseif($assesment->status == 7)
                           <option value='7'> <span class="badge badge-danger">Closed</span> </option>
                             @elseif($assesment->status == 10)
                           <option value='10'> <span class="badge badge-danger">Rejected by Estate Officer</span> </option>
                             @elseif($assesment->status == 11)
                           <option value='11'> <span class="badge badge-danger">Rejected by Estate Director</span> </option>
                             @elseif($assesment->status == 12)
                          <option value='12'>  <span class="badge badge-danger">Rejected by DVC Admin</span> </option>                             @elseif($assesment->status == 13)
                          <option value='13'> <span class="badge badge-primary">Approved by DVC Admin</span> </option>
                             @elseif($assesment->status == 25)
                          <option value='25'> <span class="badge badge-success">Company paid </span> </option>
                             @endif
                 @endforeach
              </select>
          </div>
      </div>

<br>
  <div class="row">
          <div class="col">
              <select name="sheet" class="form-control mr-sm-2">
                <option value='' selected="selected">Select assessment sheet</option>
                 @foreach($assessmmentsheet as $assesment)

                    <option value='{{$assesment->assessment_name}}'>{{$assesment->assessment_name}}</option>

                 @endforeach
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






                <table id="myTablee" class="table table-striped">
                    <thead >
                    <tr style="color: white;">
                        <th scope="col">#</th>
                        <th scope="col">Tender Number</th>
                        <th scope="col">Assessment Area</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Assessment Month</th>
                        <th scope="col">Assessment Sheet</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>



<?php $i = 0;  $ii = 0;  $iii = 0;?>
 @if(auth()->user()->type == 'Supervisor Landscaping')
                    @foreach($assessmmentcompanylandscaping as $assesment)

                          <?php $i++; ?>
                         <tr>
                             <td>{{ $i }}</td>
                              <td>{{$assesment->company}}</td>
                             <td>{{$assesment['areaname']->cleaning_name}}</td>
                                <td>{{$assesment['companyname']['compantwo']->company_name}}</td>
                             <td>{{ date('F Y', strtotime($assesment->assessment_month))}}</td>
                              <td>{{$assesment->assessment_name}}</td>
                             @if($assesment->status == 1)
                             <td><span class="badge badge-danger">No assessment form submitted yet</span></td>
                             @elseif($assesment->status == 2)
                             <td><span class="badge badge-primary">Crosscheck assessment form</span></td>
                             @elseif($assesment->status == 3)
                             <td><span class="badge badge-warning">Submitted to Estate Officer<br> for approval</span></td>
                             @elseif($assesment->status == 4)
                             <td><span class="badge badge-primary">Approved by Estate Officer , <br>fowarded to Estate director for approval</span></td>
                             @elseif($assesment->status == 5)
                             <td><span class="badge badge-primary">Approved by Estate Director , <br>fowarded to DVC Accountant</span></td>
                             @elseif($assesment->status == 6)
                             <td><span class="badge badge-primary">Submitted to Estate Officer <br>for approval</span></td>
                             @elseif($assesment->status == 7)
                             <td><span class="badge badge-danger">Closed</span></td>
                             @elseif($assesment->status == 10)
                             <td><span class="badge badge-danger">Rejected by Estate Officer</span></td>
                             @elseif($assesment->status == 11)
                             <td><span class="badge badge-danger">Rejected by Estate Director</span></td>
                             @elseif($assesment->status == 12)
                             <td><span class="badge badge-danger">Rejected by DVC Admin</span></td>
                             @elseif($assesment->status == 13)
                             <td><span class="badge badge-primary">Approved by DVC Admin </span></td>
                             @elseif($assesment->status == 25)
                             <td><span class="badge badge-success">Company paid </span></td>
                             @endif
                               <?php $tender = Crypt::encrypt($assesment->company); ?>
                             <td align="center"> <a style="color: green;" href="{{ url('edit/assessmentform/landscaping', [$assesment->id  , $tender , $assesment->assessment_month ]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                           <!-- <a style="color: black;" href="{{ route('workOrder.track.landscaping', [$assesment->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>-->
                           </td>
                         </tr>

                      @endforeach
@endif



 @if(auth()->user()->type == 'USAB')
                    @foreach($assessmmentcompanyusab as $assesment)

                          <?php $ii++; ?>
                         <tr>
                             <td>{{ $ii }}</td>
                              <td>{{$assesment->company}}</td>
                             <td>{{$assesment['areaname']->cleaning_name}}</td>
                                <td>{{$assesment['companyname']['compantwo']->company_name}}</td>
                             <td>{{ date('F Y', strtotime($assesment->assessment_month))}}</td>
                              <td>{{$assesment->assessment_name}}</td>
                             @if($assesment->status == 1)
                             <td><span class="badge badge-danger">No assessment form submitted yet</span></td>
                             @elseif($assesment->status == 2)
                             <td><span class="badge badge-primary">Crosscheck assessment form</span></td>
                             @elseif($assesment->status == 3)
                             <td><span class="badge badge-warning">Submitted to Estate Officer<br> for approval</span></td>
                             @elseif($assesment->status == 4)
                             <td><span class="badge badge-primary">Approved by Estate Officer , <br>fowarded to Estate director for approval</span></td>
                             @elseif($assesment->status == 5)
                             <td><span class="badge badge-primary">Approved by Estate Director , <br>fowarded to DVC Accountant</span></td>
                             @elseif($assesment->status == 6)
                             <td><span class="badge badge-primary">Submitted to Estate Officer <br>for approval</span></td>
                             @elseif($assesment->status == 7)
                             <td><span class="badge badge-danger">Closed</span></td>
                             @elseif($assesment->status == 10)
                             <td><span class="badge badge-danger">Rejected by Estate Officer</span></td>
                             @elseif($assesment->status == 11)
                             <td><span class="badge badge-danger">Rejected by Estate Director</span></td>
                             @elseif($assesment->status == 12)
                             <td><span class="badge badge-danger">Rejected by DVC Admin</span></td>
                             @elseif($assesment->status == 13)
                             <td><span class="badge badge-primary">Approved by DVC Admin </span></td>
                             @elseif($assesment->status == 25)
                             <td><span class="badge badge-success">Company paid </span></td>
                             @endif
                               <?php $tender = Crypt::encrypt($assesment->company); ?>
                             <td align="center"> <a style="color: green;" href="{{ url('edit/assessmentform/landscaping', [$assesment->id  , $tender , $assesment->assessment_month ]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                           <!-- <a style="color: black;" href="{{ route('workOrder.track.landscaping', [$assesment->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>-->
                           </td>
                         </tr>

                      @endforeach
@endif





@if((auth()->user()->type != 'USAB') and (auth()->user()->type != 'Supervisor Landscaping') )
                    @foreach($assessmmentcompany as $assesment)

                          <?php $iii++; ?>
                         <tr>
                             <td>{{ $iii }}</td>
                              <td>{{$assesment->company}}</td>
                             <td>{{$assesment['areaname']->cleaning_name}}</td>
                                <td>{{$assesment['companyname']['compantwo']->company_name}}</td>
                             <td>{{ date('F Y', strtotime($assesment->assessment_month))}}</td>
                              <td>{{$assesment->assessment_name}}</td>
                             @if($assesment->status == 1)
                             <td><span class="badge badge-danger">No assessment form submitted yet</span></td>
                             @elseif($assesment->status == 2)
                             <td><span class="badge badge-primary">Crosscheck assessment form</span></td>
                             @elseif($assesment->status == 3)
                             <td><span class="badge badge-warning">Submitted to Estate Officer<br> for approval</span></td>
                             @elseif($assesment->status == 4)
                             <td><span class="badge badge-primary">Approved by Estate Officer , <br>fowarded to Estate director for approval</span></td>
                             @elseif($assesment->status == 5)
                             <td><span class="badge badge-primary">Approved by Estate Director , <br>fowarded to DVC Accountant</span></td>
                             @elseif($assesment->status == 6)
                             <td><span class="badge badge-primary">Submitted to Estate Officer <br>for approval</span></td>
                             @elseif($assesment->status == 7)
                             <td><span class="badge badge-danger">Closed</span></td>
                             @elseif($assesment->status == 10)
                             <td><span class="badge badge-danger">Rejected by Estate Officer</span></td>
                             @elseif($assesment->status == 11)
                             <td><span class="badge badge-danger">Rejected by Estate Director</span></td>
                             @elseif($assesment->status == 12)
                             <td><span class="badge badge-danger">Rejected by DVC Admin</span></td>
                             @elseif($assesment->status == 13)
                             <td><span class="badge badge-primary">Approved by DVC Admin </span></td>
                             @elseif($assesment->status == 25)
                             <td><span class="badge badge-success">Company paid </span></td>
                             @endif
                               <?php $tender = Crypt::encrypt($assesment->company); ?>
                             <td align="center"> <a style="color: green;" href="{{ url('edit/assessmentform/landscaping', [$assesment->id  , $tender , $assesment->assessment_month ]) }}"
                                           data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                           <!-- <a style="color: black;" href="{{ route('workOrder.track.landscaping', [$assesment->id]) }}" data-toggle="tooltip" title="Track"><i
                                                    class="fas fa-tasks"></i></a>-->
                           </td>
                         </tr>

                      @endforeach
@endif
                    </tbody>
                </table>


                <div class="text-center">

                </div>

            </div>


              <div class="modal fade" id="editDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Section</h5>


                </div>

                <form method="POST" action="edit/workordersection" class="col">
                    <div class="modal-body">


                        @csrf





                    <div class="form-group ">
                        <label for="dep_name">Section Name</label>
                        <input id="sname" style="color: black" type="text" required class="form-control" id="dep_name"   maxlength = "15"
                               name="sec_name" placeholder="Enter Section Name, Example: ELECTRICAL, MECANICAL etc." >
                                 <input id="esecid" name="esecid" hidden>
                    </div>


                        <button type="submit" class="btn btn-primary">save
                        </button>
                        <a href="/Manage/section" class="btn btn-danger">Cancel
                    </a>

                    </div>
                </form>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




                      <script>
        window.onload = function () {
            //write your function code here.

            document.getElementById("modal").click();
        };

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('#myTable').dataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });

            $('#myTablee').DataTable();
            $('#myTableee').DataTable();


        });





        function myfunc1(x,y) {


            document.getElementById("esecid").value = x;
            document.getElementById("sname").value = y;


        }







    </script>

@endSection
