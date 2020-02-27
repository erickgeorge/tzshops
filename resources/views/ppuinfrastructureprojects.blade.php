@extends('layouts.ppu')

@section('title')
    PPU Infrastructure Projects
@endsection
<?php use App\ppuprojectprogress; ?>
@section('body')<br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h3 style="padding-left: 90px;"><b>PPU Infrastructure Projects </b></h3>
        </div>
@if(count($projects)>0)
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
    
 @if(auth()->user()->type == 'Director DPI')
    <div id="div_print" class="container">
        <div class="row ">
        <div class="col">
            <a href="{{url('newinfrastructureproject')}} ">
                <button style="margin-bottom: 20px" type="button" class="btn btn-success">Create new Infrastructure Project</button>
            </a>
        </div>
</div>
</div>
@endif
<div class="container">
    @if(count($projects)>0)
    <table class="table table-striped display" id="myTable" style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th>SN</th>
                <th>Project Name</th>
                <th>Created at</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{ $i=1 }}
            @foreach($projects  as $project)
            
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $project->project_name }}</td>
                <td><?php  $time = strtotime($project->created_at)?> {{ date('d/m/Y',$time)  }}</td>
                <td>
                    <div class="badge badge-primary">
                         <?php $progress = ppuprojectprogress::orderBy('id','Desc')->where('project_id',$project->id)->first(); ?> 
                        @if($progress->status == 0) New Project @endif
                        @if($progress->status == 1) Forwarded to DVC Admin  
                        @if(auth()->user()->type == 'DVC Admin') 
                        <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b> 
                        @endif 
                        @endif
                    </div>
                </td>
                <td><a class="btn btn-primary" href="{{ route('ppuprojectview', [$project->id]) }}">View</a></td>
                {{ $i++ }}
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <center><h1 style="margin-top: 5%;">No Infrastructure Projects Available</h1></center>
    @endif
</div>
@endsection