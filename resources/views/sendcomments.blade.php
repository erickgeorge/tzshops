@extends('layouts.master')

@section('title')
Comments/ Feedback    @endSection
@section('body')
@php
    use App\User;
@endphp

<br>
<div class="container">
    <div class="row">
        <div class="col-lg-12" >
            <h4 style="text-transform: capitalize;" >Comments/Feedback</h4>
        </div>

    </div>

    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
             <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
    @endif
<div class="card">
    <div class="card-body"   style="max-height: 400px; overflow: scroll;">
        <p class="card-text ">
            @if(count($data)>0)
            @foreach ($data as $item)

            <div class="card">

                <div class="card-body">
                    <p class="card-text">
                        <b>{{$item->comment}}</b>
                    </p>
                </div>
            </div>
            <i class="text-left">{{ date('d/M/Y H:i', strtotime($item->created_at)) }}</i>,
              @if ($role['user_role']['role_id'] == 1)
               @php
$userf  = User::where('id',$item->sender)->first();
            @endphp <b> {{$userf['fname']}} {{$userf['mid_name']}} {{$userf['lname']}} </b> @endif

            <br>
            <br>
            @endforeach
            @else
            @if ($role['user_role']['role_id'] == 1)
            <h4>No Comments/Feedback Posted Yet!</h4>
            @else
            <h4>We Haven't Heard From You Yet!</h4>
            @endif
            @endif
        </p>
    </div>
    <div class="card-body">
        <p class="card-text">
            <form action="{{route('sendcomment')}}" enctype="multipart/form-data" method="post">
@csrf
                <div class="form-group">
                  <label for="">Type Your Comment/Feedback Here</label>
                  <textarea required type="text" name="message" id="" class="form-control" placeholder="" cols="10" aria-describedby="helpId"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Send</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
            </form>
        </p>
    </div>
</div>
</div>
@endsection

