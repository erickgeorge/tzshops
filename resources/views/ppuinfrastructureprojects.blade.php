@extends('layouts.ppu')

@section('title')
    PPU Infrastructure Projects
@endsection
<?php use App\ppuprojectprogress; ?>
@section('body')<br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5  ><b style="text-transform: capitalize;">PPU Infrastructure Projects </b></h5>
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
                <thead >
           <tr style="color: white;">
                <th>SN</th>
                <th>Project Name</th>
                <th>Created at</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1 ?>
            @foreach($projects  as $project)
            <?php $progress = ppuprojectprogress::orderBy('id','Desc')->where('project_id',$project->id)->first(); ?>
            @if(auth()->user()->type == 'Director DPI')

            <tr>
                <td>{{ $i }}</td>
                <td>{{substr($project->project_name,0,25).'...'  }}</td>
                <td><?php  $time = strtotime($project->created_at)?> {{ date('d/m/Y',$time)  }}</td>
                <td>

                    @if($progress->status == 0) <div class="badge badge-primary">New Project </div>@endif
                   @if($progress->status == 1) <div class="badge badge-primary">Project Forwarded to DVC Admin
                       @if(auth()->user()->type == 'DVC Admin')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif

                   @if($progress->status == -1) <div class="badge badge-danger">Project Rejected by DVC Admin
                       @if(auth()->user()->type == 'Director DPI')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif

                   @if($progress->status == 2) <div class="badge badge-primary">Project Forwarded to Director DES
                       @if(auth()->user()->type == 'Estates Director')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif
                    @if($progress->status == 3) <div class="badge badge-primary">Project Forwarded to Head PPU
                       @if(auth()->user()->type == 'Head PPU')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif
                    @if($progress->status == 4) <div class="badge badge-primary">Project Forwarded to Draftsman
                       @if(auth()->user()->type == 'Architect & Draftsman')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif
                   @if($progress->status == 5) <div class="badge badge-primary">Plans & Drawings Sent to Head PPU
                       @if(auth()->user()->type == 'Head PPU')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif
                   @if($progress->status == 11) <div class="badge badge-primary">Plans & Drawings Sent to Director DES for Approval
                    @if(auth()->user()->type == 'Estates Director')
                    <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                    @endif </div>
                @endif
                   @if($progress->status == 6) <div class="badge badge-primary">Plans & Drawings Sent to DVC Admin
                       @if(auth()->user()->type == 'DVC Admin')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif
                   @if($progress->status == 7) <div class="badge badge-primary">Plans & Drawings Approved By DVC Admin
                       @if(auth()->user()->type == 'Estates Director')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif
                   @if($progress->status == 12) <div class="badge badge-primary">Approved Plans & Drawings sent to Head PPU
                       @if(auth()->user()->type == 'Head PPU')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif

                   @if($progress->status == 8) <div class="badge badge-primary">Plans & Drawings Forwarded to QS
                       @if(auth()->user()->type == 'Quality Surveyor')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                   @endif
                   @if($progress->status == 9) <div class="badge badge-primary">Project Budget Forwarded to Head PPU
                     @if(auth()->user()->type == 'Head PPU')
                     <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                     @endif </div>
                     @endif
                     @if($progress->status == 10) <div class="badge badge-primary">Project Budget Forwarded to Director DES for Approval
                       @if(auth()->user()->type == 'Estates Director')
                       <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                       @endif </div>
                       @endif
                       @if($progress->status == 13) <div class="badge badge-primary">Project Budget Forwarded to DVC Admin for Approval
                         @if(auth()->user()->type == 'DVC Admin')
                         <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                         @endif </div>
                         @endif
                         @if($progress->status == 14) <div class="badge badge-primary">Project Budget Approved by DVC Admin
                          </div>
                           @endif


           </td>
                <td><a class="btn btn-primary" href="{{ route('ppuprojectview', [$project->id]) }}">View</a>
                    <a href="{{ route('pputrack', [$project->id]) }}" class="btn btn-dark" title="Track"> <i class=" fa fa-tasks"></i> </a>
                </td>
            </tr>

                @else
                @if($progress->status == 0)
                @else
            <tr>
                <td>{{ $i }}</td>
                <td>{{substr($project->project_name,0,25).'...'  }}</td>
                <td><?php  $time = strtotime($project->created_at)?> {{ date('d/m/Y',$time)  }}</td>
                <td>

                         @if($progress->status == 0) <div class="badge badge-primary">New Project </div>@endif
                        @if($progress->status == 1) <div class="badge badge-primary">Project Forwarded to DVC Admin
                            @if(auth()->user()->type == 'DVC Admin')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif

                        @if($progress->status == -1) <div class="badge badge-danger">Project Rejected by DVC Admin
                            @if(auth()->user()->type == 'Director DPI')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif

                        @if($progress->status == 2) <div class="badge badge-primary">Project Forwarded to Director DES
                            @if(auth()->user()->type == 'Estates Director')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                         @if($progress->status == 3) <div class="badge badge-primary">Project Forwarded to Head PPU
                            @if(auth()->user()->type == 'Head PPU')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                         @if($progress->status == 4) <div class="badge badge-primary">Project Forwarded to Draftsman
                            @if(auth()->user()->type == 'Architect & Draftsman')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                        @if($progress->status == 5) <div class="badge badge-primary">Plans & Drawings Sent to Head PPU
                            @if(auth()->user()->type == 'Head PPU')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                        @if($progress->status == 11) <div class="badge badge-primary">Plans & Drawings Sent to Director DES for Approval
                         @if(auth()->user()->type == 'Estates Director')
                         <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                         @endif </div>
                     @endif
                        @if($progress->status == 6) <div class="badge badge-primary">Plans & Drawings Sent to DVC Admin
                            @if(auth()->user()->type == 'DVC Admin')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                        @if($progress->status == 7) <div class="badge badge-primary">Plans & Drawings Approved By DVC Admin
                            @if(auth()->user()->type == 'Estates Director')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                        @if($progress->status == 12) <div class="badge badge-primary">Approved Plans & Drawings sent to Head PPU
                            @if(auth()->user()->type == 'Head PPU')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif

                        @if($progress->status == 8) <div class="badge badge-primary">Plans & Drawings Forwarded to QS
                            @if(auth()->user()->type == 'Quality Surveyor')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                        @endif
                        @if($progress->status == 9) <div class="badge badge-primary">Project Budget Forwarded to Head PPU
                          @if(auth()->user()->type == 'Head PPU')
                          <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                          @endif </div>
                          @endif
                          @if($progress->status == 10) <div class="badge badge-primary">Project Budget Forwarded to Director DES for Approval
                            @if(auth()->user()->type == 'Estates Director')
                            <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                            @endif </div>
                            @endif
                            @if($progress->status == 13) <div class="badge badge-primary">Project Budget Forwarded to DVC Admin for Approval
                              @if(auth()->user()->type == 'DVC Admin')
                              <b class="badge badge-warning"><i class="fa fa-exclamation"></i></b>
                              @endif </div>
                              @endif
                              @if($progress->status == 14) <div class="badge badge-primary">Project Budget Approved by DVC Admin
                               </div>
                                @endif


                </td>
                <td>
                    <a class="btn btn-primary" href="{{ route('ppuprojectview', [$project->id]) }}">View</a>
                    <a href="{{ route('pputrack', [$project->id]) }}" class="btn btn-dark" title="Track"> <i class=" fa fa-tasks"></i> </a>
                </td>
            </tr>
            @endif
            @endif

                <?php $i++ ?>
            @endforeach
        </tbody>
    </table>
    @else
    <center><h1 style="margin-top: 5%;">No Infrastructure Projects Available</h1></center>
    @endif
</div>
@endsection
