@extends('layouts.asset')

@section('title')
@php echo $_GET['asset']; @endphp Assets Generated on {{date('d-m-Y H-i')}}
    @endSection

@section('body')
@php
    use App\User;
@endphp
<div class="container"><br>
    <div class="row container-fluid" >
        <div class="col">
            <h5><b >@php


                if ($_GET['condition']=='New') {
                    $pr = 'With New Condition';
                    $df = '1';
                } else
                if ($_GET['condition']=='Good') {
                    $pr = 'With Good Condition';
                    $df = '1';
                } else
                if ($_GET['condition']=='Fair') {
                    $pr = 'With Fair Condition';
                    $df = '1';
                } else
                if ($_GET['condition']=='Poor') {
                    $pr = 'With Poor Condition';
                    $df = '1';
                } else
                if ($_GET['condition']=='Very Poor') {
                    $pr = 'With Very Poor Condition';
                    $df = '1';
                } else
                if ($_GET['condition']=='Obsolete') {
                    $pr = 'With Obsolete Condition';
                    $df = '1';
                } else
                if ($_GET['condition']=='Disposed') {
                    $pr = 'With Disposed Condition';
                    $df = '1';
                } else
                if ($_GET['condition']=='Sold') {
                    $pr = 'Sold';
                    $df = '2';
                } else
                if ($_GET['expired']=='aboutto') {
                    $pr = 'About to Expire';
                    $df = '1';
                } else
                if ($_GET['expired']=='expired') {
                    $pr = 'Expired';
                    $df = '2';
                } else {
                    $pr = '';
                    $df = '';
                }


    if ($df == '2') {
       echo $pr.'&nbsp; ';
    }
            if( $_GET['asset']=='plantandmachinery')
            {
echo 'Plant and Machinery';
            }else if( $_GET['asset']=='motorvehicle')
            {
echo 'Motor Vehicle';
            }else if( $_GET['asset']=='computerequipments')
            {
echo 'Computer Equipments';
            }else{
                echo $_GET['asset'];
            }
            @endphp


                Assets

                @php
                    if ($df == '1') {
                       echo $pr.'';
                    }
                @endphp

                Export Preview</b></h5>
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

    <table class="table table-responsive table-striped display text-center" id="myTable4" style="width:100%">
        <thead>
            <tr style="color:white;">
                <th><b >Sn</b></th>
                <th><b >Asset #</b></th>
                <th><b >Asset Description </b></th>
                <th><b >Site Location</b></th>
                <th><b>Date Of Acquisition </b></th>
                <th><b>Date In Use </b></th>
                <th><b  >Ending Depreciation Date </b></th>
                <th><b  >Quantity</b></th>
                <th style="text-align:right;"><b  >Cost/Repair Cost (Tshs)</b></th>
                <th><b  >Condition</b></th>
                <th><b   >Useful Life</b></th>
                <th><b >Depreciation Rate </b></th>
            </tr>
        </thead>
        <tbody>
            @php
                $X=1;
            @endphp
            @foreach ($assetdata as $user)
            <tr>
                <td>{{$X}}</td>
                <td>{{$user->assetNumber}}</td>
                <td>{{$user->assetDescription}}</td>
                <td>{{$user->assetLocation}}</td>

                <?php  $time = strtotime($user->assetAcquisitionDate)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <?php  $time = strtotime($user->assetDateinUse)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <?php  $time = strtotime($user->assetEndingDepreciationDate)?>
                <td>{{date('d/m/Y',$time)  }}</td>

                <td>{{$user->assetQuantity}}</td>
                <td style="text-align:right;">{{number_format($user->Cost)}}  </td>
                <td>{{$user->_condition}}</td>
                <td>{{$user->usefulLife}}</td>
                <td>{{number_format($user->depreciationRate,2)}}</td>
            </tr>
            @php
                $X++;
            @endphp

            @endforeach
        </tbody>
    </table>
</div>
@endsection
