@extends('layouts.ppu')

@section('title')
    PPU Infrastructure Project Progress
@endsection
@section('body')
<?php
use App\ppuprojectprogress;
use App\ppuprojectbudget;
use App\User;
?><br>
<div class="row container-fluid" >
    <div class="col-md-6">
        <h5 ><b style="text-transform: capitalize;">PPU Infrastructure Project Progress </b></h5>
    </div>
</div>
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
        @if(count($progress)>0)
        <div class="card">
            <div class="card-header">
                Project Name : {{$project['project_name']}}
            </div>
            <div class="card-body">
                <h5 class="card-title">Details</h5>
                <p class="card-text">
                    <div class="row">
                        <div class="col">
                            Description : {{ $project['description'] }}
                        </div>
                    </div>
                    <br>
                    <div class="row" style=" text-decoration:underline;">
                        <div class="col-lg-3">
                            <?php $creator = User::where('id',$project['Created_by'])->first(); ?>
                            Created By : {{$creator['fname'] }} {{$creator['lname']}}
                        </div>
                        <div class="col-lg-3">
                            Created on : <?php  $time = strtotime($project['created_at'])?> {{ date('d/m/Y',$time)  }}
                        </div>
                        <div class="col">
                            Current Status :
                        <?php $prog = ppuprojectprogress::orderBy('id','Desc')->where('project_id',$project['id'])->first();?>

                            @if($prog['status'] == 0)
                                <div class="badge badge-primary">New Project </div>
                            @endif
                            @if($prog['status'] == 1)
                                <div class="badge badge-primary">Project Forwarded to DVC Admin </div>
                            @endif

                            @if($prog['status'] == -1)
                                <div class="badge badge-danger">Project Rejected by DVC Admin </div>
                            @endif

                            @if($prog['status'] == 2)
                                <div class="badge badge-primary">Project Forwarded to Director DES </div>
                            @endif
                            @if($prog['status'] == 3)
                                <div class="badge badge-primary">Project Forwarded to Head PPU </div>
                            @endif
                            @if($prog['status'] == 4)
                                <div class="badge badge-primary">Project Forwarded to Draftsman </div>
                            @endif
                            @if($prog['status'] == 5)
                                <div class="badge badge-primary">Plans & Drawings Sent to Head PPU </div>
                            @endif
                            @if($prog['status'] == 6)
                                <div class="badge badge-primary">Plans & Drawings Sent to DVC Admin </div>
                            @endif
                            @if($prog['status'] == 7)
                                <div class="badge badge-primary"> Plans & Drawings Approved By DVC Admin </div>
                            @endif

                            @if($prog['status'] == 8)
                                <div class="badge badge-primary">Plans & Drawings Forwarded to QS</div>
                            @endif

                            @if($prog['status'] == 11)
                                <div class="badge badge-primary">Plans & Drawings Sent to Director DES for Approval </div>
                            @endif
                            @if($prog['status'] == 12)
                                <div class="badge badge-primary">Approved Plans & Drawings sent to Head PPU  </div>
                            @endif
                            @if($prog['status'] == 9)
                                <div class="badge badge-primary">Project Budget Forwarded to Head PPU </div>
                            @endif
                            @if($prog['status'] == 10)
                                <div class="badge badge-primary">Project Budget Forwarded to Director DES for Approval</div>
                            @endif
                            @if($prog['status'] == 13)
                                <div class="badge badge-primary">Project Budget Forwarded to DVC Admin for Approval </div>
                            @endif
                            @if($prog['status'] == 14)
                                <div class="badge badge-primary">Project Budget approved by DVC Admin </div>
                            @endif

                        </div>
                    </div>
                </p>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header text-center" style="text-transform:uppercase;">
                Progress
            </div>
        </div>

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Activity</th>
                                <th>Performed By</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach ($progress as $progress)
                                @if(($progress->status>=0)&&($progress->status<5))

                                    <tr>
                                    <td>{{$i}}</td>
                                    <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                                    <td>
                                        @if($progress->status == 0) <div class="text-primary">Project Initiated </div>@endif
                                        @if($progress->status == 1) <div class="text-primary">Project Forwarded to DVC Admin For Approval</div>
                                        @endif
                                        @if($progress->status == 2)
                                        <div class="text-primary">Project Approved and Forwarded to Director DES </div>
                                        @endif
                                         @if($progress->status == 3)
                                         <div class="text-primary">Project Forwarded to Head PPU </div>
                                        @endif
                                         @if($progress->status == 4)
                                         <div class="text-primary">Project Forwarded to Draftsman For Drawing Plans </div>
                                        @endif

                                    </td>
                                    <td>
                                        <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                                        {{$creator['fname']}} {{$creator['fname']}}
                                    </td>
                                    <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                                    <?php $i++; ?>
                                    </tr>
                                @endif
                                @if ($progress->status == 4)
                                <tr>
                                    <td colspan="5">
                                        <div class="card" style="background-color:#343a4017 !important">
                                            <div class="card-body">
                                                <h5 class="card-title">Message Sent To Draftsman</h5>
                                                <p class="card-text"> {{$progress->remarks}} </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if ($progress->status == 5)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                                        <td>
                                            <div class="text-primary">Plans & Drawings Sent to Head PPU </div>
                                        </td>
                                        <td>
                                            <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                                            {{$creator['fname']}} {{$creator['fname']}}
                                        </td>
                                        <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                                        <?php $i++; ?>
                                    </tr>
                                @endif
                                @if ($progress->status == 5)
                                <tr>
                                    <td colspan="5">
                                        <div class="card" style="background-color:#343a4017 !important;">
                                            <div class=" card-body ">
                                                Descriprion:  {{$document['description']}}
                                            </div>
                                            @foreach($file as $file)
                                            <div class="card-footer">
                                            <div class="row"> <div class="col">Drawn By : {{$document['drawn_by']}}</div><div class="col"> Uploaded on : <?php $time = strtotime($document['created_at']); echo date('d/m/Y',$time);  ?> </div><div class='col'>Document Type : {{$file->type}}
                                                </div><div class='col'><a href=" {{route('viewppudraws',[$project->id,$file->type,$file->doc_name])}} " class='btn btn-success'>View Plan Documents</a></div></div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if ((($progress->status > 5)&&($progress->status <9))||(($progress->status == 11)||($progress->status == 12)))
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                                        <td>
                                            @if($progress->status == 6)
                                            <div class="text-primary">Plans & Drawings Sent to DVC Admin For Approval </div>
                                            @endif
                                            @if($progress->status == 7)
                                            <div class="text-primary"> Plans & Drawings Approved By DVC Admin </div>
                                            @endif
                                            @if($progress->status == 11)
                                            <div class="text-primary"> Plans & Drawings Sent to Director DES for Approval  </div>
                                            @endif
                                            @if($progress->status == 12)
                                            <div class="text-primary"> Approved Plans & Drawings sent to Head PPU</div>
                                            @endif
                                            @if($progress->status == 8)
                                            <div class="text-primary">Approved Plans & Drawings Forwarded to QS For Budget Preparation</div>
                                            @endif

                                        </td>
                                        <td>
                                            <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                                            {{$creator['fname']}} {{$creator['fname']}}
                                        </td>
                                        <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                                        <?php $i++; ?>
                                    </tr>
                                @endif
                                @if($progress->status == -1)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                                        <td>
                                            <div class="text-primary">Project Rejected by DVC </div> </td>
                                        <td>
                                            <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                                            {{$creator['fname']}} {{$creator['fname']}}
                                        </td>
                                        <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                                        <?php $i++; ?>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <div class="card" style="background-color:#343a4017 !important">
                                                <div class="card-body">
                                                    <p class="card-text"> Reason of Rejection : {{$progress->remarks}} </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($progress->status == 8)
                                <tr>
                                    <td colspan="5">
                                        <div class="card" style="background-color:#343a4017 !important;">
                                            <div class=" card-body ">
                                                <h5 class="card-title">Note Sent To Quality Surveyor</h5>
                                                <p class="card-text"> {{$progress->remarks}} </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if($progress->status == 9)
                            <tr>
                                <td>{{$i}}</td>
                                <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                                <td>
                                    <div class="text-primary">Project Budget Forwarded to Head PPU </div> </td>
                                <td>
                                    <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                                    {{$creator['fname']}} {{$creator['fname']}}
                                </td>
                                <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                                <?php $i++; ?>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="card">
                                        @php
                                            $budget = ppuprojectbudget::where('project_id',$project->id)->orderBy('budget_item','ASC')->get(); $x=1;
                                        @endphp
                                        <div class="card-body"  style="background-color:#343a4017 !important">
                                            <p class="card-text"> Description : {{$progress->remarks}} </p>
                                        </div>
                                        <div class="card-body">
                                                <table class="table display" id="myTable" style="width:100%">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Budget Item</th>
                                                            <th class='text-right'>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $c = 0;
                                                        @endphp
                                                        @foreach ($budget as $item)
                                                            @php
                                                                $c = +$item->amount;
                                                            @endphp
                                                        @endforeach
                                                        @foreach ($budget as $budget)
                                                        <tr>
                                                            <td>{{$x}}</td>
                                                            <td>{{$budget->budget_item}}</td>
                                                            <td class='text-right'>{{number_format($budget->amount)}}</td>
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
                                </td>
                            </tr>
                        @endif

                        @if($progress->status == 10)
                        <tr>
                            <td>{{$i}}</td>
                            <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                            <td>
                                <div class="text-primary">Project Budget Forwarded to Director DES for Approval  </div> </td>
                            <td>
                                <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                                {{$creator['fname']}} {{$creator['fname']}}
                            </td>
                            <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                            <?php $i++; ?>
                        </tr>
                    @endif

                    @if($progress->status == 13)
                    <tr>
                        <td>{{$i}}</td>
                        <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                        <td>
                            <div class="text-primary">Project Budget Forwarded to DVC Admin for Approval </div> </td>
                        <td>
                            <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                            {{$creator['fname']}} {{$creator['fname']}}
                        </td>
                        <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                        <?php $i++; ?>
                    </tr>
                @endif

                @if($progress->status == 14)
                <tr>
                    <td>{{$i}}</td>
                    <td><?php  $time = strtotime($progress->created_at)?>{{date('d/m/Y',$time)}}</td>
                    <td>
                        <div class="text-primary">Project Budget Approved by DVC Admin </div> </td>
                    <td>
                        <?php $creator = User::where('id',$progress->updated_by)->first(); ?>
                        {{$creator['fname']}} {{$creator['fname']}}
                    </td>
                    <td><div class="badge badge-success">{{ $creator['type'] }}</div></td>
                    <?php $i++; ?>
                </tr>
            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <br>
        </div>
        @else
        <div class=" center-block">
            <h5>
                No  Progress For this project
            </h5>
        </div>
        @endif
    </div>
@endsection
