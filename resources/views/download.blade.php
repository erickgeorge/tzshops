@extends('layouts.master')

@section('title')
    Documents
    @endSection
@section('body')

<div class="container">
    <br>
    <div class="row">
        <div class="col-lg-12" >
            <h4 style="text-transform: capitalize;" >Documents</h4>
        </div>

    </div>

    <hr>
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
    @if($role['user_role']['role_id'] == 1)
    <div class="col-md-4">
        <a href="{{route('newdownloads')}}" class="btn btn-primary">Add New Document</a>
    </div>
    @endif
</div>
<br>
<div class="card">
    <div class="card-body">
        <p class="card-text">
            @if(count($data)>0)
            <table id="myTable" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $f = 1;
                    @endphp
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$f}}</td>
                        <td> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> {{$item->name}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{route('viewdownloads',[$item->id])}}" role="button"> <i class="fa fa-eye" aria-hidden="true"></i> View </a>
                            @if($role['user_role']['role_id'] == 1)
                            &nbsp;
                            <a href="{{route('editdownloads',[$item->id])  }}" class="btn btn-info"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this document?')" href="{{route('deletedownload',[$item->id])}}" role="button"> <i class="fa fa-trash" aria-hidden="true"></i> Delete </a>
                            @endif
                        </td>
                    </tr>
                    @php
                        $f++;
                    @endphp
                    @endforeach


                </tbody>
            </table>
            @else
            <h4>No Documents Currently Available</h4>
            @endif
        </p>
    </div>
</div>
</div>
@endsection

