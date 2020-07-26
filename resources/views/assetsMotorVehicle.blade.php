@extends('layouts.asset')

@section('title')
Motor Vehicle Assets
    @endSection

@section('body')
@php
    use App\assetsmotorvehicle;
use App\assetsassesmotorvehicle;
    $asses = assetsassesmotorvehicle::orderBy('assesmentYear','Desc') ->select('assetID')->distinct()->get();

@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5 ><b style="text-transform: capitalize;">Motor Vehicles Assets</b></h5>
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
        @if (($role['user_role']['role_id'] == 1)||(auth()->user()->type =='Assets Officer'))

        <div class="col-md-5">
            <a href="{{url('assetsNewMotorVehicle')}}" class="btn btn-primary text-light" type="button"><b>Add New Motor Vehicle Asset</b></a>
        </div>
        @endif

    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <p class="card-text">

                <table class="table table-striped display text-center">
                    <thead >
                        <tr style="color:white;">
                            <th>New</th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Poor</th>
                            <th>Very Poor</th>
                            <th>Obsolete</th>
                            <th>Disposed</th>
                            <th>Sold</th>
                            <th>Expiring Soon</th>
                            <th>Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @php
                                $motorvehicle = assetsmotorvehicle::where('_condition','New')->get();
                                $motorvehicle2 = assetsmotorvehicle::where('_condition','Good')->get();
                                $motorvehicle3 = assetsmotorvehicle::where('_condition','Fair')->get();
                                $motorvehicle4 = assetsmotorvehicle::where('_condition','Poor')->get();
                                $motorvehicle5 = assetsmotorvehicle::where('_condition','Very Poor')->get();
                                $motorvehicle6 = assetsmotorvehicle::where('_condition','Obsolete')->get();
                                $motorvehicle7 = assetsmotorvehicle::where('_condition','Disposed')->get();
                                $motorvehicle8 = assetsmotorvehicle::where('_condition','Sold')->get();
                            $motorvehicle10 = assetsmotorvehicle::select('assetEndingDepreciationDate')->whereYear('assetEndingDepreciationDate',date('Y'))->where('assetEndingDepreciationDate','>',date('Y-m-d'))->get();
                                $motorvehicle9 = assetsmotorvehicle::select('assetEndingDepreciationDate')->where('assetEndingDepreciationDate','<',date('Y-m-d'))->get();
                            @endphp
                                                                <td>
                                @if (count($motorvehicle)>0)
                                        {{count($motorvehicle)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=New&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle2)>0)
                                        {{count($motorvehicle2)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Good&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle2)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle3)>0)
                                        {{count($motorvehicle3)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Fair&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle3)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle4)>0)
                                        {{count($motorvehicle4)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle4)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle5)>0)
                                        {{count($motorvehicle5)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Very+Poor&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle5)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle6)>0)
                                        {{count($motorvehicle6)}}
                                        &nbsp;<a   title="View Details" href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Absolette&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle6)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle7)>0)
                                        {{count($motorvehicle7)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Disposed&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle7)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle8)>0)
                                        {{count($motorvehicle8)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=Sold&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity="> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle8)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle10)>0)
                                        {{count($motorvehicle10)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=aboutto"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle10)}}
                                @endif
                                </td>
                                <td>
                                    @if (count($motorvehicle9)>0)
                                        {{count($motorvehicle9)}}
                                        &nbsp;<a  title="View Details"  href="{{route('assetExcel/export/')}}?type=Excel&asset=motorvehicle&assetNumber=&AssetLocation=&cost=&condition=&DateofAcquisition=&assetDateinUse=&EndingDepreciationDate=&Quantity=&expired=expired"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
                                    @else
                                        {{count($motorvehicle9)}}
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
        <div class="col-md-3 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Export <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <i class="fa fa-file-excel-o" aria-hidden="true"></i> </button>
        </div>
        </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 style="color:#000;" class="modal-title" id="exampleModalLabel">Export Assets Information</h5>
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
              <INPUT type="radio" name="type" value="Excel"> Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i><BR>
                <INPUT type="radio" name="type" value="Pdf" checked> PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i><BR>
            <br>
            <!-- --->
                    <p>
                        <a class="btn btn-warning" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                          Filter &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </a>
                      </p>
                      <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <input type="text" hidden name="asset" value="motorvehicle">

                            <div class="form-group">
                                <label for="my-input">Asset Number</label>
                                <select class="form-control" name="assetNumber" id="">
                                    @php
    $assetNumber=assetsmotorvehicle::select('assetNumber')->distinct()->orderBy('assetNumber','ASC')->get();
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
    $assetLocation=assetsmotorvehicle::select('assetLocation')->distinct()->orderBy('assetLocation','ASC')->get();
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
    $Cost=assetsmotorvehicle::select('Cost')->distinct()->orderBy('Cost','ASC')->get();
                                    @endphp
                                        <option value="" selected>Not filtered</option>
                                    @foreach ($Cost as $cost)
                                        <option value="{{$cost->Cost}}">{{number_format($cost->Cost)}}  </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="my-input">Condition</label>
                                <select class="form-control" name="condition" id="">
                                    @php
    $Condition=assetsmotorvehicle::select('_condition')->distinct()->orderBy('_condition','ASC')->get();
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
    $assetAcquisitionDate=assetsmotorvehicle::select('assetAcquisitionDate')->distinct()->orderBy('assetAcquisitionDate','ASC')->get();
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
    $assetDateinUse=assetsmotorvehicle::select('assetDateinUse')->distinct()->orderBy('assetDateinUse','ASC')->get();
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
    $assetEndingDepreciationDate=assetsmotorvehicle::select('assetEndingDepreciationDate')->distinct()->orderBy('assetEndingDepreciationDate','ASC')->get();
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
    $assetsquantity=assetsmotorvehicle::select('assetQuantity')->distinct()->orderBy('assetQuantity','ASC')->get();
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
    </div>
    <br>
    @if (count($land)>0)
    <table class="table table-striped display text-center" id="myTable" style="width:100%">
        <thead >
            <tr style="color:white;">
                <th>#</th>
                <th>Asset#</th>
                <th>Description</th>
                <th>Type</th>
                <th style="text-align:right;">Cost (Tshs)</th>
                <th>condition</th>
                <th title="Date of Acqusition">DoA</th>
                <th title="Date in use">DiU</th>
                <th title="Ending Depreciation Date">EDD</th>
                <th>Quantity</th>
                <th>Action</th>
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
                    <td style="text-transform: uppercase;">{{$landinfo->assetLocation}}</td>
                    <td style="text-align:right;">{{number_format($landinfo->Cost)}}  </td>

                    @if ($landinfo->_condition=='Disposed')
                    <td class="text-danger">{{$landinfo->_condition}}</td>
                    @else
                    <td>{{$landinfo->_condition}}</td>
                    @endif


                    <td><?php  $time = strtotime($landinfo->assetAcquisitionDate)?>  {{date('d/m/Y',$time)  }}</td>
                    <td><?php  $time = strtotime($landinfo->assetDateinUse)?>  {{date('d/m/Y',$time)  }}</td>
                    <td><?php  $time = strtotime($landinfo->assetEndingDepreciationDate)?>  {{date('d/m/Y',$time)  }}</td>
                    <td>{{$landinfo->assetQuantity}}</td>
                    <td><a name="" id="" class="btn btn-primary" href="{{route('assetsMotorVehicleView',[$landinfo->id])}}" title="View More Details" role="button"> <i class='fa fa-eye'></i> </a></td>
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

<p>
    <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Latest Assets Assessment Summary</a>

  </p>
  <div class="row">
    <div class="col">
      <div class="collapse multi-collapse" id="multiCollapseExample1">
        <div class="card card-body">
  <div>
          <div class="row">

            <form class="col-md-8" action="{{route('assetsSummaryFiltered')}}" method="get">
                <div class="row">
              <div class="form-group  col">
                  <select  id="my-select" class="form-control" name="date">
                      <option selected value="">Date</option>
                      @php
                          $dates = assetsassesmotorvehicle::select(DB::raw('DAY(assesmentYear) as day'))->distinct()->orderBy('assesmentyear','Desc')->get();
                      @endphp
                      @foreach ($dates as $dated)
                  <option value="{{$dated->day}}">  {{$dated->day  }}</option>
                      @endforeach
                  </select>
              </div><div class="form-group  col">
                  <select  id="my-select" class="form-control" name="month">
                      <option selected value="">Month</option>
                      @php
                          $dates = assetsassesmotorvehicle::select(DB::raw('MONTH(assesmentYear) as month'))->distinct()->orderBy('assesmentyear','Desc')->get();
                      @endphp
                      @foreach ($dates as $dated)
                  <option value="{{$dated->month}}">  {{$dated->month  }}</option>
                      @endforeach
                  </select>
              </div><div class="form-group  col">
                  <select id="my-select" class="form-control" name="year">
                      <option selected value="">Year</option>
                      @php
                          $dates = assetsassesmotorvehicle::select(DB::raw('YEAR(assesmentYear) as year'))->distinct()->orderBy('assesmentyear','Desc')->get();
                      @endphp
                      @foreach ($dates as $dated)
                  <option value="{{$dated->year}}">  {{$dated->year  }}</option>
                      @endforeach
                  </select>
              </div>
              <input name="asset" type="text" value="MmotorVehicle" hidden>
              <div class="col">
                  <button class="btn btn-primary" type="submit">Filter</button>
              </div>
                </div>
            </form>
              <div class="col">

            </div>
            <div class="col-md-3 text-right">
                <form action="{{route('assetreportfromsummary')}}" method="get" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="asset" value="MotorVehicle" hidden>
                    <input type="text" name="date" value="latest" hidden>
                    <button class="btn btn-primary" type="submit"> Export <i class="fa fa-file-excel-o" aria-hidden="true"></i> </button>
                </form>
            </div>
          </div>
      </form>
  </div>
          <table class="table table-striped display text-center" id="myTableAssesment" style="width:100%">
              <thead>
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
              @php
                  $u = 1;
              @endphp
              <tbody>
                  @foreach ($asses as $asses)
                  <tr>
                      <td>{{$u}}</td>
                      @php
                          $assetid = assetsmotorvehicle::where('id',$asses->assetID)->first();
                          $asseted = assetsassesmotorvehicle::orderBy('assesmentYear','Desc') ->where('assetID',$asses->assetID)->first();

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
