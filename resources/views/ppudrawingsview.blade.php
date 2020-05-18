@extends('layouts.ppu')

@section('title')
   Infrastructure Project Drawings & Plans
@endsection
@section('body')
@php
    use App\User;
@endphp
<br>
<div class="row container-fluid" >
    <div class="col-md-6">
        <h5 ><b style="text-transform: uppercase;">Infrastructure Project Drawings</b></h5>
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
    <div class="card">
        <div class="card-header">
            Project Summary
        </div>
        <div class="card-body">
            <h5 class="card-title">Name : {{$projectinfo['project_name']}}</h5>
            <p class="card-text">Description : {{$projectinfo['description']}}</p>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-4">
                    Created By : {{$userinfo['fname']}} {{$userinfo['lname']}}
                </div>
                <div class="col-md-4">
                    On : <?php  $time = strtotime($projectinfo['created_at'])?> {{ date('d/m/Y',$time)  }}
                </div>
                <div class="col">
                    Current status :

                            @if($projectinfo['status'] == 0)
                                <div class="badge badge-primary">New Project </div>
                            @endif
                            @if($projectinfo['status'] == 1)
                                <div class="badge badge-primary">Project Forwarded to DVC Admin </div>
                            @endif

                            @if($projectinfo['status'] == -1)
                                <div class="badge badge-danger">Project Rejected by DVC Admin </div>
                            @endif

                            @if($projectinfo['status'] == 2)
                                <div class="badge badge-primary">Project Forwarded to Director DES </div>
                            @endif
                            @if($projectinfo['status'] == 3)
                                <div class="badge badge-primary">Project Forwarded to Head PPU </div>
                            @endif
                            @if($projectinfo['status'] == 4)
                                <div class="badge badge-primary">Project Forwarded to Draftsman </div>
                            @endif
                            @if($projectinfo['status'] == 5)
                                <div class="badge badge-primary">Plans & Drawings Sent to Head PPU </div>
                            @endif
                            @if($projectinfo['status'] == 6)
                                <div class="badge badge-primary">Plans & Drawings Sent to DVC Admin </div>
                            @endif
                            @if($projectinfo['status'] == 7)
                                <div class="badge badge-primary"> Plans & Drawings Approved By DVC Admin </div>
                            @endif

                            @if($projectinfo['status'] == 8)
                                <div class="badge badge-primary">Plans & Drawings Forwarded to QS</div>
                            @endif

                            @if($projectinfo['status'] == 11)
                                <div class="badge badge-primary">Plans & Drawings Sent to Director DES for Approval </div>
                            @endif
                            @if($projectinfo['status'] == 12)
                                <div class="badge badge-primary">Approved Plans & Drawings sent to Head PPU  </div>
                            @endif
                            @if($projectinfo['status'] == 9)
                                <div class="badge badge-primary">Project Budget Forwarded to Head PPU </div>
                            @endif
                            @if($projectinfo['status'] == 10)
                                <div class="badge badge-primary">Project Budget Forwarded to Director DES for Approval</div>
                            @endif
                            @if($projectinfo['status'] == 13)
                                <div class="badge badge-primary">Project Budget Forwarded to DVC Admin for Approval </div>
                            @endif
                            @if($projectinfo['status'] == 14)
                                <div class="badge badge-primary">Project Budget approved by DVC Admin </div>
                            @endif

                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Message From Head PPU for Project Plan Drawing</h5>
        <p class="card-text">: {{ $status['remarks'] }}</p>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            Project Drawing plan details
        </div>
        <div class="card-body">
            <p class="card-text">Description : {{$projectdrawing['description']}} </p>
        </div>
        <div class="card-footer">
            <table class="table table-light">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>File type</th>
                        <th>Drawn by</th>
                        <th>Uploaded by</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i =1
                    @endphp
                    @foreach ($projectfile as $projectfile)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$projectfile->type}}</td>
                        <td>{{$projectdrawing['drawn_by']}}</td>
                        <td>
                            @php
                                $user = User::where('id',$projectfile->updated_by)->first();
                            @endphp
                            {{$user['fname']}} {{$user['lname']}}
                        </td>
                        <td><?php  $time = strtotime($projectfile->created_at)?> {{ date('d/m/Y',$time)  }}</td>
                        <td>
                            <a href="{{route('viewppudraws',[$projectdrawing['project_id'],$projectfile->type,$projectfile->doc_name])}}" class="btn btn-primary" type="button">View</a>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
