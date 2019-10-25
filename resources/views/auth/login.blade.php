<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="/css/main.css">
    </head>
    <body style="background-color: #e1e8f0">

<style>
    
.jumbotron{
 
background-color: #423e3e;

    color: white;
    
    
    border-radius: 10px;

 }


</style>


<br>
<br>
<br>
  
  <h1 style="text-align: center"><b>Estates Services Management Information System</b></h1>
  <br>
 

                <div class=" container col-md-4 jumbotron ">
                <div  >
                     @guest
                    <form method="POST" action="{{ route('login')}}" class="">
                         @csrf


                     <div >
                    
                         <i class="fa fa-user icon"></i>
                            <label for="email" ><strong  > {{ __('
                             User Name') }}</strong></label>

                           
                                <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('email') }}" required autofocus placeholder="Enter User Name">
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

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

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
                           <a href="{{ route('login') }}"><h1 class="text-center">HOME</h1></a>
                         @endguest

                        </div>
                    </form>
                    </div>
                  
           



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

</body>
    </body>
</html>