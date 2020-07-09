@extends('layouts.asset')

@section('title')
ComputerEquipment Asset
    @endSection

@section('body')
@php
    use App\User;
@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col-md-6">
            <h5 style="padding-left: 90px;"><b style="text-transform: uppercase;">Computer Equipment Asset</b></h5>
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
                                <b style="color: black;">Description : </b>{{$landinfo->assetDescription}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <b style="color: black;">Asset Number :</b> {{$landinfo->assetNumber}}
                            </div>
                            <div class="col">
                                <b style="color: black;"> Asset Location : </b> <br> {{$landinfo->assetLocation}}, <br>  	{{$landinfo->location}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <b style="color: black;"> Asset Quantity : </b>  {{$landinfo->assetQuantity}}
                            </div>
                            <div class="col">
                                <b style="color: black;"> Cost/Rep.Cost : </b> {{number_format($landinfo->Cost)}}  
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <b style="color: black;">Asset Condition : </b> {{$landinfo->_condition}}
                            </div>
                            <div class="col">
                                <b style="color: black;">Assets Useful Life : </b> {{$landinfo->usefulLife}} Years
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <b style="color: black;">Depreciation Rate : </b> {{number_format($landinfo->depreciationRate,2)}}%
                            </div>
                            <div class="col">
                                <b style="color: black;"> Asset Acquisition Date : </b>  <?php  $time = strtotime($landinfo->assetAcquisitionDate)?>  {{date('d/m/Y',$time)  }}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <b style="color: black;"> Asset in Use Date : </b>  <?php  $time = strtotime($landinfo->assetDateinUse)?>  {{date('d/m/Y',$time)  }}
                            </div>
                            <div class="col">
                                <b style="color: black;"> Asset Ending Depreciation Date :</b>   <?php  $time = strtotime($landinfo->assetEndingDepreciationDate)?>  {{date('d/m/Y',$time)  }}
                            </div>
                        </div>
                </p>
            </div>
            <div class="card-footer text-right">
                <!-- Button trigger modal -->
                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                   <i class="fa fa-calendar-check-o" aria-hidden="true"></i>  Asses
                 </button>
                 <a href="{{route('assetinfo/export/',[$landinfo->id,'computerequipment'])}}" class="btn btn-primary" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export</a>
                 @if ((auth()->user()->type =='Maintenance coordinator')||(auth()->user()->type =='Housing Officer')||(auth()->user()->type =='USAB')||(auth()->user()->type =='DVC Admin'))
                 @else
                <a href="{{route('assetsComputerEquipmentEdit',[$landinfo->id])}}" class="btn btn-primary" type="button"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
            @endif
            </div>



            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog " role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asses Building Asset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span title="Close" style="color: red;" aria-hidden="true">X</span>
                    </button>
                  </div>
                  <form enctype="multipart/form-data" action="{{route('assetsAssesComputerEquipmentSave')}}" method="post">
                      @csrf
                  <div class="modal-body">
                    <div class="row">
                        <div class="col">
                          <div class="form-group">
                              <label for="my-input">Asset Condition</label>
                              <select id="assetnumber" required class="form-control" name="AssetCondition">
                                  <option selected value="{{$landinfo->_condition}}">{{$landinfo->_condition}}</option>
                                  <option  value="New">New</option>
                                  <option value="Good">Good</option>
                                  <option value="Fair">Fair</option>
                                  <option value="Poor">Poor</option>
                                  <option value="Very Poor">Very Poor</option>
                                  <option value="Absolute">Absolette</option>
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col">
                              <div class="form-group">
                                <label for="my-input">Depreciation Date</label>
                                  <input id="depreciationDate" value="<?php echo date('Y-m-d'); ?>" class="form-control" type="date" name="depreciationDate">
                              </div>
                          </div>
                      </div>
                      <div class="row" hidden>
                          <div class="col">
                            Total  Depreciated Years as at <b id="upDate"> <?php  $time = strtotime(Now())?>  {{date('d/m/Y',$time)  }} </b> : <input class="col" type="number" value="13" name="totYears" id="totYears" readonly>
                          </div>
                      </div>
                      <div class="row" hidden>
                          <div class="col">
                            <div class="form-group">
                                <label for="my-input">Accumulated Depreciation</label>
                                <input id="accumulatedDeprection" class="form-control" value="" type="text" name="accumulatedDepreciation" readonly>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col">
                              <div class="form-group">
                                  <label for="my-input">Depreciation Rate (%)</label>
                                  <input id="my-input" value="{{number_format($landinfo->depreciationRate,2)}}" readonly class="form-control" type="text" name="rate">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col">
                            <div class="form-group">
                                <label for="my-input">Impairment Loss</label>
                                <input class="form-control" value="0" type="number" name="impairmentLoss">
                            </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col">
                            <div class="form-group">
                                <label for="my-input">Disposal Cost</label>
                                <input class="form-control" value="0" type="number" name="disposalCost">
                            </div>
                          </div>
                      </div>
                        <input type="text" name="id" value="{{$landinfo->id}}" hidden>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Assesment</button>
                  </div>
              </form>
                </div>
              </div>
            </div>

            @php
            $type = $landinfo->id;
        @endphp
        @endforeach
    </div><br>
    <div class="container">
        <h4>Assesmet Records</h4><hr>
        <div class="row text-right">
            <div class="col">
                <a href="{{route('asset/assesment/export/',[$type])}}?type=computerequipment" class="btn btn-primary" id="btnExport" > Export </a>
            </div>
        </div><b></b>
        <table class="table table-striped display" id="myTable" style="width:100%">
            <thead style="text-transform: uppercase;">
                <tr style="color:white;">
                    <th>#</th>
                    <th>Assesment date</th>
                    <th>Total Depreciated Years</th>
                    <th>Accumulated Depreciation</th>
                    <th>Impairment Loss</th>
                    <th>Disposal Cost</th>
                    <th>Assesed By</th>
                </tr>
            </thead>
            @php
                $u = 1;
            @endphp
            <tbody>
                @foreach ($asses as $asses)
                <tr>
                    <td>{{$u}}</td>
                    <td><?php  $time = strtotime($asses->assesmentYear)?>  {{date('d/m/Y',$time)  }}</td>
                    <td>{{$asses->totalDepreciatedYears}}</td>
                    <td style="text-align:right;">{{number_format($asses->accumulatedDepreciation)}}  </td>
                    <td style="text-align:right;">{{number_format($asses->impairmentLoss)}}  </td>
                    <td style="text-align:right;">{{number_format($asses->disposalCost)}}  </td>
                    @php
                        $user = User::where('id',$asses->assesedBy)->first();
                    @endphp
                    <td>
                        {{$user['fname']}} {{$user['lname']}}
                    </td>
                </tr>
                @php
                    $u++;
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">No Assets Found!</h4>
    </div>
    @endif
</div>
@endSection