@extends('layouts.asset')

@section('title')
Work in Progress
@endSection

@section('body')
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Work in Progress</b></h5>
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

</div>
<div class="container">
    @if (count($land)>0)
        <div class="card">
            @foreach ($land as $landinfo)
                <div class="card-header">
                    Asset Summary
                </div>
                <div class="card-body" style="background-color: #6c757d33 !important;">
                    <p class="card-text">
                            <div class="row">
                                <div class="col">
                                    <b style="color: black;">  Description: </b><br>{{$landinfo->assetDescription}}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <b style="color: black;">Asset Number:</b> <br>{{$landinfo->assetNumber}}
                                </div>
                                <div class="col">
                                    <b style="color: black;"> Asset Location:</b> <br> {{$landinfo->assetLocation}}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <b style="color: black;">Asset Quantity: </b><br>  {{$landinfo->assetQuantity}}
                                </div>
                                <div class="col">
                                    <b style="color: black;"> Cost/Rep.Cost :</b> <br> {{number_format($landinfo->Cost)}}
                                </div>
                            </div>
                    </p>
                </div>
                @if (($role['user_role']['role_id'] == 1)||(auth()->user()->type =='Assets Officer'))
                <div class="card-footer text-right">
                    <a href="{{route('assetsWorkinProgressReallocate',[$landinfo->id])}}" class="btn btn-primary text-light" type="button"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Reallocate</a>

                    <a href="{{route('assetsWorkinProgressEdit',[$landinfo->id])}}" class="btn btn-primary" type="button"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                </div>

@endif
            @endforeach
        </div>
    @else
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">No Assets Found!</h4>
    </div>
    @endif
</div>
@endSection
