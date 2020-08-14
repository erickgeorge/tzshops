<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="icon" type="image/png" href="{{ url('/images/index.jpg') }}"/>
        <title>ESMIS - Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/fontawesome/css/all.css') }}">
<link rel="stylesheet" href="/css/main.css">
    </head>
    <style>
        body{
            background-position:center;
    /* background-image:url(../images/images2.jpg) no-repeat; */
            background-image: linear-gradient(#376bd39d,#376bd39d), url("/images/UDSM.jpg") !important;
        }
    </style>
    <body>

<style>

    .jumbotron{

    background-color:  #376ad3;

        color: white;


     }
     /* Split the screen in half */
    .split1,.split2 {
    height: 100%;
    position: fixed;
    z-index: 1;
    top: 0;
    overflow-x: hidden;
    padding-top: 20px;
    }
    .split1{

    width: 60%;
    }
    .split2{

    width: 40%;
    }

    /* Control the left side */
    .left {
    left: 0;
    }

    /* Control the right side */
    .right {
    right: 0;
    background-color: #376ad3;
    }

    </style>
    <div style="padding-top:10%;">

     <div class="split1 left">
        <div class="centered">
            <div class="container"  style="padding-top:13%;">
                <div class="row">
                    <div class="col" align="center">
                        <div class="row">
                            <h1 class="col">
                                <b style="color: #fff;">University of Dar es salaam</b>
                            </h1>
                        </div>
                        <br>
                        <div class="row" >
                            <div class="col">
                                <img src="{{ url('/images/logo_ud.png') }}" alt="udsm logo" style="height: 150px; width: 150px;">

                            </div>

                        </div>
                        <div class="row">
                            <h3 class="col">
                                <b style="color: #fff;">Direcorate of Estates Services</b>
                                </h3>

                        </div>
                        <div class="row">
                            <h4 class="col">
                                <b style="color: #fff;">Estates Services Management Information System</b>
                                </h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="split2 right">
        <div class="centered">
            <div class="container">
                <div class="row">
            <div class="col"  style="padding-top:13%;">
                <div class=" container col-md-9 jumbotron ">
                    <div align="center" style="font-size: 18px;">LOGIN<hr></div>
                <div>
                     @guest
                    <form method="POST" action="{{ route('login')}}" class="" autocomplete="off">
                         @csrf


                     <div >

                         <i class="fa fa-user icon"></i>
                            <label for="email" ><strong  > {{ __('
                             User Name') }}</strong></label>


                                <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus placeholder="Enter User Name">
                                 <!-- <small id="emailHelp" class="form-text text-muted">Your Name is Handled Privately.</small>-->

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                         </div>

                        <br>
                        <div class="form-group">
                            <i class="fa fa-key icon"></i>
                            <label for="password" ><strong>{{ __('Password') }}</label></strong>

                            <div>

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Enter Password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <br>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            @else
                           <a  href="{{ route('login') }}" ><h1 class="text-center" style="color: blanchedalmond;">HOME</h1></a>
                         @endguest

                        </div>
                    </form>
                    </div>
            </div>
        </div>
        </div>
      </div>
    </div>
<div class="container" >

</div>



        </div>





<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

</body>

</html>
