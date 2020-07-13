@extends('layouts.asset')

@section('title')
Work in Progress
    @endSection

@section('body')
@php
    use App\assetsworkinprogress;
@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Works in Progress</b></h5>
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
        @if ((auth()->user()->type =='Maintenance coordinator')||(auth()->user()->type =='Bursar')||(auth()->user()->type =='Housing Officer')||(auth()->user()->type =='USAB')||(auth()->user()->type =='DVC Admin'))
        @else
        <div class="col-md-5">
            <a href="{{url('assetsNewWorkinProgress')}}" class="btn btn-primary text-light" type="button"><b>Add new Work in Progress</b></a>
        </div>
        @endif
        <div class="col-md-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Export </button>
        </div>
        </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 style="color:#000;" class="modal-title" id="exampleModalLabel">Export Assets Information </h5>
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
                            <input type="text" hidden name="asset" value="workinprogress">

                            <div class="form-group">
                                <label for="my-input">Asset Number</label>
                                <select class="form-control" name="assetNumber" id="">
                                    @php
    $assetNumber=assetsworkinprogress::select('assetNumber')->distinct()->orderBy('assetNumber','ASC')->get();
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
    $assetLocation=assetsworkinprogress::select('assetLocation')->distinct()->orderBy('assetLocation','ASC')->get();
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
    $Cost=assetsworkinprogress::select('Cost')->distinct()->orderBy('Cost','ASC')->get();
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
    $Condition=assetsworkinprogress::select('_condition')->distinct()->orderBy('_condition','ASC')->get();
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
    $assetAcquisitionDate=assetsworkinprogress::select('assetAcquisitionDate')->distinct()->orderBy('assetAcquisitionDate','ASC')->get();
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
    $assetDateinUse=assetsworkinprogress::select('assetDateinUse')->distinct()->orderBy('assetDateinUse','ASC')->get();
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
    $assetEndingDepreciationDate=assetsworkinprogress::select('assetEndingDepreciationDate')->distinct()->orderBy('assetEndingDepreciationDate','ASC')->get();
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
    $assetsquantity=assetsworkinprogress::select('assetQuantity')->distinct()->orderBy('assetQuantity','ASC')->get();
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
    <table class="table table-striped display" id="myTable" style="width:100%">
        <thead >
            <tr style="color:white;">
                <th>#</th>
                <th>Asset#</th>
                <th>Description</th>
                <th>Location</th>
                <th style="text-align: right;">Cost (Tsh)</th>
                <th>condition</th>
                <th>Created at</th>
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
                    <td>{{$landinfo->assetLocation}}</td>
                    <td style="text-align:right;">{{number_format($landinfo->Cost)}}</td>
                    <td>{{$landinfo->_condition}}</td>
                    <td><?php  $time = strtotime($landinfo->created_at)?>  {{date('d/m/Y',$time)  }}</td>
                    <td>{{$landinfo->assetQuantity}}</td>
                    <td><a name="" id="" class="btn btn-primary" href="{{route('assetsWorkinProgressView',[$landinfo->id])}}" title="View More Details" role="button"> <i class='fa fa-eye'></i> </a></td>
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
@endSection
