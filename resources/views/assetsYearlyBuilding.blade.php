@extends('layouts.asset')

@section('title')
Building Assets Yearly Assessment
@endSection

@section('body')
@php
    use App\assetsassesbuilding;
    use App\assetsbuilding;
@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col-md-8 ">
            <h5><b style="text-transform: capitalize;">Building Assets Yearly Assessment</b></h5>
        </div>
        <div class="col">


            <form action="{{route('yearlybuilding')}}" method="get">
                <div class="row">
                    <div class="form-group  col">
                        <select id="my-select" class="form-control" name="year">
                            <option selected value=""> Year...</option>
                            @php
                                $dates = assetsassesbuilding::select(DB::raw('YEAR(assesmentYear) as year'))->distinct()->orderBy('assesmentyear','Desc')->get();
                            @endphp
                            @foreach ($dates as $dated)
                        <option value="{{$dated->year}}">  {{$dated->year  }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>

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
    <div class="row">

        <div class="col  text-right">
            <form action="{{route('yearlyexport')}}" method="get">
                <input type="text" value="{{$year}}" name="year" hidden>
                <input type="text" value="Building" name="asset" hidden>

                <button type="submit" class="btn btn-primary">Export <i class="fa fa-file-excel-o" aria-hidden="true"></i> </button>

            </form>

        </div>
    </div>
    <br>
    <table class="table table-responsive  table-striped display text-center" id="myTable" style="width:100%">
        <thead  >
            <tr style="color:white;">
                <th>#</th>
                <th>Asset Number</th>
                <th>Assessment date</th>
                <th>Total Depreciated Years</th>
                <th style="text-align:right;">Accumulated Depreciation (Tshs)</th>
                <th style="text-align:right;">Impairment Loss (Tshs)</th>
                <th style="text-align:right;">Disposal Cost (Tshs)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $d = 1;
            @endphp
            @foreach ($asset as $asses)
                <tr>
                    <td>{{$d}}</td>
                    @php
                    $assetid = assetsbuilding::where('id',$asses->assetID)->first();
                    $asseted = assetsassesbuilding::orderBy('assesmentYear','Desc') ->where('assetID',$asses->assetID)->first();

                @endphp
                <td>{{$assetid['assetNumber']}}</td>
                <td><?php  $time = strtotime($asseted['assesmentYear'])?>  {{date('d/m/Y',$time)  }}</td>
                <td>{{$asseted['totalDepreciatedYears']}}</td>
                <td style="text-align:right;">{{number_format($asseted['accumulatedDepreciation'])}}  </td>
                <td style="text-align:right;">{{number_format($asseted['impairmentLoss'])}}  </td>
                <td style="text-align:right;">{{number_format($asseted['DisposalCost'])}}  </td>

                </tr>
                @php
                    $d++;
                @endphp
            @endforeach

        </tbody>
    </table>
</div>
@endSection
