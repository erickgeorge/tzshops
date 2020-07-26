@extends('layouts.ppu')

@section('title')
    PPU Infrastructure Project Drawings & Plans
@endsection
@section('body')
@php
    use App\ppudocument;
@endphp
<br>
<div class="row container-fluid" >
    <div class="col-md-6">
        <h5  ><b style="text-transform: capitalize;">PPU Infrastructure Project Drawings Library</b></h5>
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
    @php
        $i=1;
    @endphp
@if (count($drawingdetails)>0)
    <table class="table table-striped display" id="myTable" style="width:100%">
        <thead >
        <tr style="color: white;">
            <th>SN</th>
            <th>Project ID</th>
            <th>Total Drawings</th>
            <th>Drawn by</th>
            <th>Date</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($drawingdetails as $draw)
                <tr>
                    <td>{{$i}}</td>
                    <td>PID_{{$draw->project_id}}</td>
                    <td>@php
                        $documents = ppudocument::where('document_identifier',$draw->document_identifier)->get(); echo count($documents).' file(s)';
                    @endphp</td>
                    <td>{{$draw->drawn_by}}</td>
                    <td><?php  $time = strtotime($draw->created_at)?> {{ date('d/m/Y',$time)  }}</td>
                    <td><a href="{{route('ppudrawingsview',[$draw->id])}}" class="btn btn-primary">View</a></td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
@else
<br></b><br><br><br>
<h5>
    No Infrastructure Project Drawings Found
</h5>
@endif
</div>
@endsection
