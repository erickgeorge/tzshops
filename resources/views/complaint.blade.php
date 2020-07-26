@extends('layouts.master')

@section('title')
    Complaint
    @endSection

@section('body')

    <br>
    <div class="row container-fluid" style=" margin-left: 4%; margin-right: 4%;">
        <div class="col-lg-12">
           <h5 style="text-transform: capitalize;" ><b style="text-transform: capitalize;">Complaint </b></h5>
        </div>





    </div>
    <br>
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

    <?php use App\Compliant;
            use App\User;
            use App\WorkOrder;

     ?>
     @foreach($compliant as $compliment)
     <?php $user = user::where('id',$compliment->sender)->get(); ?>
     <?php $work = workorder::where('id',$compliment->work)->get(); ?>

        <div class="row">
            <div class="col">From:@foreach($user as $us) {{ $us->fname }} {{ $us->lname }} @endforeach</div>
            <div class="col">Date: <?php $time = strtotime($compliment->created_at); echo date('d/m/Y',$time);  ?></div>
            <div class="col"> Status : <b class="badge badge-warning">Waiting for acceptance</b></div>
        </div><br><hr>
        <div class="row">
            <div class="col">

  <div class="card-header">Message</div>
  <div class="card-body">
    <p class="card-text">{{ $compliment->message }}</p>
  </div>
</div>
<div class="col">
  <div class="card-header">Problem</div>
  <div class="card-body">
    <p class="card-text">@foreach($work as $wak) Problme type: {{ $wak->problem_type }}<br> Details: <b> {{ $wak->details }}<br></b> @if($wak->emergency == 1)<span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> Emergency</span>@endif @endforeach</p>
  </div>
</div>

</div>
</div>
@endforeach

