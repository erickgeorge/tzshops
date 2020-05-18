@extends('layouts.ppu')

@section('title')
     Infrastructure Project Budget Library
@endsection
@section('body')
@php
    use App\ppuprojectbudget;
    use App\ppuprojectprogress;
    use App\User;
@endphp
<br>
<div class="row container-fluid" >
    <div class="col-md-6">
        <h5  text-transform: uppercase;" ><b style="text-transform: uppercase;">Infrastructure Project Budget Library</b></h5>
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
     <table class="table table-striped display" id="myTable" style="width:100%">
        <thead >
            <tr style="color: white;">
                <th>SN</th>
                <th>Total Items</th>
                <th>Total Budget Amount</th>
                <th>Written by</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($budgetdetails as $budgetdetails)
                <tr>
                    <td>{{$i}}</td>
                    <td>
                        @php
                           $these = ppuprojectbudget::select(DB::raw("count('project_id') as counted"))->where('project_id',$budgetdetails->project_id)->groupby('project_id')->first();
                        @endphp
                       {{$these['counted']}} Items
                    </td>
                    <td>
                        @php
                            $amount = ppuprojectbudget::select('amount')->where('project_id',$budgetdetails->project_id)->get();
                            $total = 0;
                        @endphp
                        @foreach ($amount as $amount)
                            @php
                                $total = + $amount->amount;
                            @endphp
                        @endforeach
                        {{number_format($total)}}
                    </td>
                    <td>
                        @php
                            $user = ppuprojectprogress::where('project_id',$budgetdetails->project_id)->where('status',9)->first();
                            $details = User::where('id',$user['updated_by'])->first();
                        @endphp
                        {{$details['fname']}} {{$details['lname']}}
                    </td>
                    <td>
                        <?php  $time = strtotime($user->created_at)?>{{date('d/m/Y',$time)}}
                    </td>
                    <td>
                        <a href="{{route('ppubudgetview',[$budgetdetails->project_id])}}" class="btn btn-primary" type="button">View</a>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection
