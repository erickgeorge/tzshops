@extends('layouts.ppu')

@section('title')
    New Infrastructure Projects
@endSection

@section('body')
<br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h3 style="padding-left: 90px;"><b>Edit Infrastructure Project </b></h3>
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
    <div class="container">
    	<form method="post" action="{{ url('saveeditedproject') }}" enctype="multipart/form-data">
    		<b style="color: red;">All fields are compulsory</b>
    		@csrf
            @foreach($projects as $project)
    		<div class="input-group mb-3">
           <div class="input-group-prepend">
               <span class="input-group-text" id="basic-addon1" style="width: 180px;">Project Name</span>
           </div>
              <input style="color: black" type="text" required class="form-control" id="projectname" aria-describedby="emailHelp" value="{{ $project->project_name }}" name="projectname" placeholder="Enter project idea name"  >
           </div>
			<div class="row">
				<div class="col">
					<div class="form-group ">
				    <label for="fname">Description</label>
				    <textarea style="color: black" type="text" required class="form-control" id="projectdescription" aria-describedby="emailHelp" name="projectdescription" placeholder="Enter project idea description"  >{{ $project->description }}</textarea>
				 </div>
				</div>
			</div>
            <input type="text" name="projectid" value="{{ $project->id }}" hidden>
            @endforeach
			<div class="col">
				<button type="submit" class="btn btn-primary">Send</button>
				<a class="btn btn-danger" href="{{ route('ppuprojectview', [$project->id]) }}">Cancel</a>
			</div>
    	</form>
    </div>
@endsection
