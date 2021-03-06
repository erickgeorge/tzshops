@extends('layouts.asset')

@section('title')
Assets Assestment Report
    @endSection

@section('body')
@php
use App\assetsland;
use App\assetsbuilding;
use App\assetscomputerequipment;
use App\assetsequipment;
use App\assetsfurniture;
use App\assetsintangible;
use App\assetsmotorvehicle;
use App\assetsplantandmachinery;
@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col">
            <h4 >
                All @php

            if( $_GET['asset']=='PlantMachinery')
            {
echo 'Plant and Machinery';
            }else if( $_GET['asset']=='MotorVehicle')
            {
echo 'Motor Vehicle';
            }else if( $_GET['asset']=='ComputerEquipment')
            {
echo 'Computer Equipment';
            }else{
                echo $_GET['asset'];
            }



                    @endphp  Assessment Records : <?php  $time = strtotime($year)?>  {{date('d/m/Y',$time)  }}
            </h4>
        </div>
    </div>
    <hr class="container">
    <div class="row">
        <div class="col">

        </div>
        <div class="col-md-3">
            <form action="{{route('assetreportfromsummary')}}" method="get" enctype="multipart/form-data">
                @csrf
                <input type="text" name="asset" value="{{$_GET['asset']}}" hidden>
                <input type="text" name="date" value="{{$year}}" hidden>
                <button class="btn btn-primary" type="submit"> Export <i class="fa fa-file-excel-o" aria-hidden="true"></i> </button>
            </form>
        </div>
    </div>
    <br>
    <table class="table table-responsive  table-striped display text-center" id="myTable" style="width:100%">
        <thead >
            <tr style="color:white;">
                <th>#</th>
                <th>Asset Number</th>
                <th>Assessment date</th>
                <th>Total Depreciated Years</th>
                <th style="text-align:right;">Accumulated Depreciation (Tshs)</th>
                <th style="text-align:right;">Impairment Loss (Tshs)</th>
                <th style="text-align:right;">Disposal Cost (Tshs)</th>
                <th>Action</th>
            </tr>
        </thead>
        @php
            $u = 1;
        @endphp
        <tbody>
            @foreach ($asses as $asses)
            <tr>
                <td>{{$u}}</td>
                @php
                if ($_GET['asset']=='Intangible') {
                    $assetid = assetsintangible::where('id',$asses->assetID)->first();

                }else if ($_GET['asset']=='Furniture') {
                    $assetid = assetsfurniture::where('id',$asses->assetID)->first();

                }else if ($_GET['asset']=='Equipment') {
                    $assetid = assetsequipment::where('id',$asses->assetID)->first();

                }else if ($_GET['asset']=='ComputerEquipment') {
                    $assetid = assetscomputerequipment::where('id',$asses->assetID)->first();

                }else if ($_GET['asset']=='MotorVehicle') {
                    $assetid = assetsmotorvehicle::where('id',$asses->assetID)->first();

                }else if ($_GET['asset']=='PlantMachinery') {
                    $assetid = assetsplantandmachinery::where('id',$asses->assetID)->first();

                }else if ($_GET['asset']=='Building') {
                    $assetid = assetsbuilding::where('id',$asses->assetID)->where('woip',0)->first();

                }else if ($_GET['asset']=='Land') {
                    $assetid = assetsland::where('id',$asses->assetID)->first();

                }
                @endphp
                <td>{{$assetid['assetNumber']}}</td>
                <td><?php  $time = strtotime($asses->assesmentYear)?>  {{date('d/m/Y',$time)  }}</td>
                <td>{{$asses->totalDepreciatedYears}}</td>
                <td style="text-align:right;">{{number_format($asses->accumulatedDepreciation)}}  </td>
                <td style="text-align:right;">{{number_format($asses->impairmentLoss)}}  </td>
                <td style="text-align:right;">{{number_format($asses->DisposalCost)}}   </td>
                <td> <a class="btn btn-primary" href="{{route('assets'.$_GET['asset'].'View',[$asses->assetID])}}"> <i class="fa fa-eye" aria-hidden="true"></i> </a>  </td>

            </tr>
            @php
                $u++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection
