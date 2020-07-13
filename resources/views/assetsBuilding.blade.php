@extends('layouts.asset')

@section('title')
Building Assets
    @endSection

@section('body')
@php
use Illuminate\Support\Facades\DB;
    use App\assetsbuilding;
    use App\assetsassesbuilding;
    $asses = assetsassesbuilding::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();

@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Building Assets</b></h5>
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
        @if ((auth()->user()->type =='Maintenance coordinator')||(auth()->user()->type =='Housing Officer')||(auth()->user()->type =='USAB')||(auth()->user()->type =='DVC Admin')||(auth()->user()->type =='Bursar'))
        @else
        <div class="col-md-5">
            <a href="{{url('assetsNewBuilding')}}" class="btn btn-primary text-light" type="button"><b>Add new Building asset</b></a>
        </div>
        @endif
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <p class="card-text">
                <table class="table table-striped display">
                    <thead style="text-transform: uppercase;">
                        <tr style="color:white;">
                            <th>New</th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Poor</th>
                            <th>Very Poor</th>
                            <th>Obsolete</th>
                            <th>Disposed</th>
                            <th>Sold</th>
                            <th>Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @php
                            $build = assetsbuilding::where('_condition','New')->get();
                            $build2 = assetsbuilding::where('_condition','Good')->get();
                            $build3 = assetsbuilding::where('_condition','Fair')->get();
                            $build4 = assetsbuilding::where('_condition','Poor')->get();
                            $build5 = assetsbuilding::where('_condition','Very Poor')->get();
                            $build6 = assetsbuilding::where('_condition','Obsolete')->get();
                            $build7 = assetsbuilding::where('_condition','Disposed')->get();
                            $build8 = assetsbuilding::where('_condition','Sold')->get();
                            $build9 = assetsbuilding::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                        @endphp
                        <td>
                        @if (count($build)>0)
                                {{count($build)}}
                                &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build2)>0)
                                {{count($build2)}}
                                &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build2)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build3)>0)
                                {{count($build3)}}
                                &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build3)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build4)>0)
                                {{count($build4)}}
                                &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build4)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build5)>0)
                                {{count($build5)}}
                                &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build5)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build6)>0)
                                {{count($build6)}}
                                &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build6)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build7)>0)
                                {{count($build7)}}
                                &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build7)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build8)>0)
                                {{count($build8)}}
                                &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build8)}}
                        @endif
                        </td>
                        <td>
                            @if (count($build9)>0)
                                {{count($build9)}}
                                &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=building&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                            @else
                                {{count($build9)}}
                        @endif
                        </td>
                        </tr>
                    </tbody>
                </table>
            </p>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">

        </div>
        <div class="col-md-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Export </button>
        </div>
    </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 style="color:#000;" class="modal-title" id="exampleModalLabel">Export Building assets Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color: #000;">&times;</span>
          </button>
        </div>
        <form method="GET" enctype="multipart/form-data" action="{{route('assetExcel/export/')}}">
        <div class="modal-body">
          <div class="row">
              <div class="col">
                <h5>Click Export to print all Assets Information <br> or Filter before Exporting</h5>
              </div>
          </div>
          <!-- --->
          <br>
          <INPUT type="radio" name="type" value="Excel" checked> Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i><BR>
            <INPUT type="radio" name="type" value="Pdf"> PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i><BR>
        <br>
        <!-- --->
                <p>
                    <a class="btn btn-warning" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Filter &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                  </p>



                  <div class="collapse" id="collapseExample">
                    <div class="card card-body">

                        <input type="text" hidden name="asset" value="building">

                        <div class="form-group">
                            <label for="my-input">Asset Number</label>
                            <select class="form-control" name="assetNumber" id="">
                                @php
$assetNumber=assetsbuilding::select('assetNumber')->distinct()->orderBy('assetNumber','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($assetNumber as $number)
                                    <option value="{{$number->assetNumber}}">{{$number->assetNumber}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="my-input">Asset Location</label>
                            <select class="form-control" name="AssetLocation" id="">
                                @php
$assetLocation=assetsbuilding::select('assetLocation')->distinct()->orderBy('assetLocation','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($assetLocation as $location)
                                    <option value="{{$location->assetLocation}}">{{$location->assetLocation}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="my-input">Cost</label>
                            <select class="form-control" name="cost" id="">
                                @php
$Cost=assetsbuilding::select('Cost')->distinct()->orderBy('Cost','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($Cost as $cost)
                                    <option value="{{$cost->Cost}}">{{number_format($cost->Cost)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="my-input">Condition</label>
                            <select class="form-control" name="condition" id="">
                                @php
$Condition=assetsbuilding::select('_condition')->distinct()->orderBy('_condition','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($Condition as $condition)
                                    <option value="{{$condition->_condition}}">{{$condition->_condition}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="my-input">Date of Acquisition</label>
                            <select class="form-control" name="DateofAcquisition" id="">
                               @php
$assetAcquisitionDate=assetsbuilding::select('assetAcquisitionDate')->distinct()->orderBy('assetAcquisitionDate','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($assetAcquisitionDate as $assetAcquisitionDate)
                                    <option value="{{$assetAcquisitionDate->assetAcquisitionDate}}"><?php  $time = strtotime($assetAcquisitionDate->assetAcquisitionDate)?>  {{date('d/m/Y',$time)  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="my-input">Date in Use</label>
                            <select class="form-control" name="assetDateinUse" id="">
                               @php
$assetDateinUse=assetsbuilding::select('assetDateinUse')->distinct()->orderBy('assetDateinUse','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($assetDateinUse as $assetDateinUse)
                                    <option value="{{$assetDateinUse->assetDateinUse}}"><?php  $time = strtotime($assetDateinUse->assetDateinUse)?>  {{date('d/m/Y',$time)  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="my-input">Ending Depreciation Date</label>
                            <select class="form-control" name="EndingDepreciationDate" id="">
                               @php
$assetEndingDepreciationDate=assetsbuilding::select('assetEndingDepreciationDate')->distinct()->orderBy('assetEndingDepreciationDate','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($assetEndingDepreciationDate as $assetEndingDepreciationDate)
                                    <option value="{{$assetEndingDepreciationDate->assetEndingDepreciationDate}}"><?php  $time = strtotime($assetEndingDepreciationDate->assetEndingDepreciationDate)?>  {{date('d/m/Y',$time)  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="my-input">Quantity</label>
                            <select class="form-control" name="Quantity" id="">
                               @php
$assetsquantity=assetsbuilding::select('assetQuantity')->distinct()->orderBy('assetQuantity','ASC')->get();
                                @endphp
                                    <option value="" selected>Not filtered</option>
                                @foreach ($assetsquantity as $quantity)
                                    <option value="{{$quantity->assetQuantity}}">{{$quantity->assetQuantity}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="expired" value="" hidden>
                        </div>
                    </div>
                  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Export</button>
        </div>
        </form>
      </div>
    </div>
  </div>
    <br>
    <div id="accordion">
        @if (count($land)>0)
        <table class="table table-striped display" id="myTable" style="width:100%">
            <thead style="text-transform: uppercase;">
                <tr style="color:white;">
                    <th>#</th>
                    <th>ASSET #</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Cost</th>
                    <th>Condition</th>
                    <th title="Date of Acqusition">DoA</th>
                    <th title="Date in use">DiU</th>
                    <th title="Ending Depreciation Date">EDD</th>
                    <th>Quantity</th>
                    <th></th>
                </tr>
                @php
                    $d=1;
                @endphp
            </thead>
            <tbody>
                @foreach ($land as $landinfo)
                    <tr>
                        <td>{{$d}}</td>
                        <td>{{$landinfo->assetNumber}}</td>
                        <td>{{substr($landinfo->assetDescription,0,25).'...'}}</td>
                        <td>{{$landinfo->assetLocation}}</td>
                        <td style="text-align:right;">{{number_format($landinfo->Cost)}}</td>

                        @if ($landinfo->_condition=='Disposed')
                        <td class="text-danger">{{$landinfo->_condition}}</td>
                        @else
                        <td>{{$landinfo->_condition}}</td>
                        @endif


                        <td>{{$landinfo->_condition}}</td>
                        <td><?php  $time = strtotime($landinfo->assetAcquisitionDate)?>  {{date('d/m/Y',$time)  }}</td>
                        <td><?php  $time = strtotime($landinfo->assetDateinUse)?>  {{date('d/m/Y',$time)  }}</td>
                        <td><?php  $time = strtotime($landinfo->assetEndingDepreciationDate)?>  {{date('d/m/Y',$time)  }}</td>
                        <td>{{$landinfo->assetQuantity}}</td>
                        <td><a name="" id="" class="btn btn-primary" href="{{route('assetsBuildingView',[$landinfo->id])}}" title="View More Details" role="button"> <i class='fa fa-eye'></i> </a></td>
                    </tr>
                    @php
                        $d++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading">No Assets Found!</h4>
        </div>
        @endif
    </div>



<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Latest Assets Assesment Summary</a>

</p>
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample1">
      <div class="card card-body">
<div>
        <div class="row">

    <form class="col-md-8" action="assetsSummaryFiltered" method="get">
        <div class="row">
            <div class="form-group  col">
                <select name="filter" id="my-select" class="form-control" name="">
                    <option selected value="">Filter Assessment According to Date</option>
                    @php
                        $dates = assetsassesbuilding::select('assesmentYear')->distinct()->orderBy('assesmentyear','Desc')->get();
                    @endphp
                    @foreach ($dates as $dated)
                <option value="{{$dated->assesmentYear}}"><?php  $time = strtotime($dated->assesmentYear)?>  {{date('d/m/Y',$time)  }}</option>
                    @endforeach
                </select>
            </div>
            <input name="asset" type="text" value="Building" hidden>
            <div class="col">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>


        </div>
    </form>
            <div class="col">

            </div>
            <div class="col-md-3">
                <form action="{{route('assetreportfromsummary')}}" method="get" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="asset" value="Building" hidden>
                    <input type="text" name="date" value="latest" hidden>
                    <button class="btn btn-primary" type="submit"> Export <i class="fa fa-file-excel-o" aria-hidden="true"></i> </button>
                </form>
            </div>
        </div>
</div>
        <table class="table table-striped display" id="myTableAssesment" style="width:100%">
            <thead style="text-transform: uppercase;">
                <tr style="color:white;">
                    <th>#</th>
                    <th>Asset Number</th>
                    <th>Assesment date</th>
                    <th>Total Depreciated Years</th>
                    <th>Accumulated Depreciation</th>
                    <th>Impairment Loss</th>
                    <th>Disposal Cost</th>
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
                        $assetid = assetsbuilding::where('id',$asses->assetID)->first();
                        $asseted = assetsassesbuilding::orderBy('assesmentYear','Desc') ->where('assetID',$asses->assetID)->first();

                    @endphp
                    <td>{{$assetid['assetNumber']}}</td>
                    <td><?php  $time = strtotime($asseted['assesmentYear'])?>  {{date('d/m/Y',$time)  }}</td>
                    <td>{{$asseted['totalDepreciatedYears']}}</td>
                    <td style="text-align:right;">{{number_format($asseted['accumulatedDepreciation'])}}  </td>
                    <td style="text-align:right;">{{number_format($asseted['impairmentLoss'])}}  </td>
                    <td style="text-align:right;">{{number_format($asseted['disposalCost'])}}  </td>

                </tr>
                @php
                    $u++;
                @endphp
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endSection
