@extends('layouts.ppu')

@section('title')
    Infrastructure Project
@endsection
<?php use App\ppuprojectprogress; ?>
@section('body')<br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h3 style="padding-left: 90px;"><b>PPU Infrastructure Project Details</b></h3>
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
    

<div class="container">
    @if(count($projects)>0)
    
            @foreach($projects  as $project)
                <div class="row">
                    <div class="col">
                        <h4>Project Name: {{ $project->project_name }}</h4>
                    </div>
                </div>
                 <div class="row" style="font-weight: bold;">
                    <div class="col">
                        <p>Description: {{ $project->description }}</p>
                    </div>
                </div>
                <br>
                <div class="row" style="font-weight: bold;">
                    <div class="col">Created on: 
                        <?php  $time = strtotime($project->created_at)?> {{ date('d/m/Y',$time)  }}
                    </div>
                    <div class="col"> Status:
                        <div class="badge badge-primary">
                            <?php $progress = ppuprojectprogress::orderBy('id','Desc')->where('project_id',$project->id)->first(); ?> 
                         @if($progress->status == 0) New Project @endif
                        @if($progress->status == 1) Forwarded to DVC Admin 
                        @if(auth()->user()->type == 'DVC Admin') 
                        <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b> 
                        @endif 
                        @endif
                        </div>
                    </div>
                </div>
                    @if(auth()->user()->type == 'Director DPI')
                    @if($progress->status == 0)

                    @endif
                    @endif
                    @if(auth()->user()->type == 'Director DPI')
                    @if($progress->status == 0)
                    <br>
                    <div class="row"><div class="col"></div>
                        <div class="col">
                            <a class="btn btn-warning" href="{{ route('ppueditproject', [$project->id]) }}">Edit</a>
                            <a href="{{ route('ppuprojectforwarddvc', [$project->id]) }}" class="btn btn-primary">Forward To DVC Admin</a>
                        </div>
                        <div class="col"></div>
                    </div>
                    @endif
                    @endif

                    @if(auth()->user()->type == 'DVC Admin')
                    @if($progress->status == 1)
                    <br>
                    <div class="row"><div class="col"></div>
                        <div class="col">
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                            Reject
                          </button>
                            <a href="{{ route('ppuprojectforwarddes', [$project->id]) }}" class="btn btn-primary">Accept & Forward To Director DES</a>
                        </div>
                        <div class="col"></div>
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
                
            @endforeach
    @else
    <center><h1 style="margin-top: 5%;">No Infrastructure Projects Found</h1></center>
    @endif


</div>
@endsection