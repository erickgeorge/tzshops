@extends('layouts.master')

@section('title')
User Registration
@endSection

@section('body')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src=
"https://code.jquery.com/jquery-1.12.4.min.js">
	</script>
 <style type="text/css">
 	#Div2 {
  display: none;
}

.selectt {


			display: none;

		}

 </style>
<br>
@php
    use App\Directorate;
    $data = Directorate::orderBy('name','asc')->get();
@endphp
<div class="container">

		<h4 style="text-transform: capitalize;" >Available User Types</h4>

</div>

<hr class="container">
<div class="container" >
@if ($errors->any())
<div class="alert alert-danger">
	 <ul class="alert alert-danger">
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
@if(Session::has('message'))
<div class="alert alert-success">
	<ul>
		<li>{{ Session::get('message') }}</li>
	</ul>
</div>
@endif
<div class="row">
    <div class="col">
        <a href="" data-toggle="modal" class="btn btn-primary mb-2" data-target="#exampleModal"> Add New User Type</a>

    </div>
    <div class="col">

    </div>
</div>
<div class="col-lg-12">
    @if (count($usertype)>0)
    <table class="table table-light table-striped" id="myTablee" >
        <thead class="text-light" style="background-color: #376ad3" >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Group</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $r = 1;
            @endphp
            @foreach ($usertype as $fetched)
                <tr>
                <td>{{$r}}</td>
                    <td> {{$fetched->type}} </td>
                    <td> {{$fetched->directorate}} </td>
                    <td>
                        <a href="" data-toggle="modal" class="btn btn-primary mb-2" data-target="#exampleModald"> Edit </a>
                        <a href="" class="btn btn-danger"> Delete</a>

{{--
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <form method="POST" enctype="multipart/form-data" action="{{route('editsaveusertype')}}">
                            @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">Edit User Type</span>
                            </button>
                            </div>
                    <input type="text" hidden value="{{$fetched->id}}" name="hidden">
                            <div class="modal-body">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name <sup class="text-danger">*</sup></span>
                                    </div>
                                    <input class="form-control" value="{{$fetched->type}}" type="text" name="type" placeholder="Enter User type" aria-label="Recipient's ">

                                </div>
                            </div>

                            <div class="modal-body">
                                <div class="input-group" >
                                    <div class="input-group-prepend" title="User type group: will be used to define which group where type of user belongs">
                                        <span class="input-group-text">Group  <sup class="text-danger">*</sup></span>
                                    </div>
                                    <select  style="color: black; width: 390px;" required class="form-control custom-select" name="group" id="type">
                                        <option value="{{$fetched->directorate}}" selected>{{$fetched->directorate}}</option>
                                        <option value="All">All</option>
                                        <option value="School">School</option>
                                        <option value="College">College</option>
                                        <option value="Directorate">Directorate</option>
                                            @foreach ($data as $item)
                                    <option value="({{$item->name}}) {{$item->directorate_description}}">({{$item->name}}) {{$item->directorate_description}}</option>
                                            @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                        </div>
                    </div> --}}
                    {{--  --}}
                    </td>
                </tr>

                @php
                    $r++;
                @endphp
            @endforeach


        </tbody>
    </table>
    @else
    <div class="justify-content-center text-center">
        <br>
        <h3>No User Types Found!</h3> <br><br>

    </div>
    @endif


{{--  --}}
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      {{-- <form method="POST" enctype="multipart/form-data" action="{{route('saveusertype')}}"> --}}
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">Add New User Type</span>
          </button>
        </div>

        <div class="modal-body">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name <sup class="text-danger">*</sup></span>
                </div>
                <input class="form-control" type="text" name="type" placeholder="Enter User type" aria-label="Recipient's ">

            </div>
        </div>

        <div class="modal-body">
            <div class="input-group" >
                <div class="input-group-prepend" title="User type group: will be used to define which group where type of user belongs">
                    <span class="input-group-text">Group  <sup class="text-danger">*</sup></span>
                </div>
                <select  style="color: black; width: 390px;" required class="form-control custom-select" name="group" id="type">

                    <option value="All">All</option>
                    <option value="School">School</option>
                    <option value="College">College</option>
                    <option value="Directorate">Directorate</option>
                        @foreach ($data as $item)
                <option value="({{$item->name}}) {{$item->directorate_description}}">({{$item->name}}) {{$item->directorate_description}}</option>
                        @endforeach
                  </select>

            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
  </form>
    </div>
  </div>
{{--  --}}
</div>
</div>
@endSection
