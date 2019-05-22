<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
 <!-- code mpya -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" >
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" >
 
 <!-- code mpya -->

    <link rel="stylesheet" href="/css/main.css">

</head>
<body>

 
  <div >
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">ESMIS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
               <b> <a class="nav-link" style="color:white" href="{{ url('dashboard')}}">Dashboard <span class="sr-only">(current)</span></a> </b>
            </li>

            @if(auth()->user()->type == 'STORE')
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="">Materials needed <span
                                class="badge badge-light">10</span></a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" style="color:white" href="{{ url('work_order')}}">Work order</a>
            </li>

            @if($role['user_role']['role_id'] == 1)
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('viewusers')}}">Manage Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('manage_directorates')}}">Manage Directorates</a>
                </li>
            @endif

            @if(auth()->user()->type == 'STORE')
                <li class="nav-item">
                    <a class="nav-link" style="color:white" href="{{ url('stores')}}">Store</a>
                </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Notifications <span class="badge badge-light">{{ count($notifications) }}</span></a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach($notifications as $notification)
                        @if($notification->type == 'wo_rejected')
                            <a class="dropdown-item"
                               onclick="event.preventDefault();
                                       document.getElementById('{{ 'reject-'.$notification->id }}').submit();">
                                {{ $notification->message }}
                            </a>

                            <form id="{{ 'reject-'.$notification->id }}" action="{{ route('notify.read', [$notification->id, 'reject']) }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a class="dropdown-item"
                               onclick="event.preventDefault();
                                       document.getElementById('{{ 'accept-'.$notification->id }}').submit();">
                                {{ $notification->message }}
                            </a>

                            <form id="{{ 'accept-'.$notification->id }}" action="{{ route('notify.read', [$notification->id, 'accept']) }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Clear notifications</a>
                </div>
            </li>
        </ul>
        <span class="navbar-text">
      <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu top-dropdown" aria-labelledby="navbarDropdown">
           <!--SETTING AND CHANGE PASSWORD 
          <a class="dropdown-item" style="color:white" href="{{ url('settings')}}">Settings</a>-->
		  
		  <a class="dropdown-item" style="color:white" href="{{ url('myprofile')}}">My Profile</a>
          <a class="dropdown-item" href="{{ url('password')}}">Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>

        </div>
      </li>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
    </ul>
    </span>
        <!-- <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
    </div>
</nav>
<div class="container">
    @yield('body')
</div>
</div>
<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="{{ asset('/js/main.js') }}"></script>





<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" ></script>
    <script>
       
                $('#myTable').DataTable();
				 $('#myTablee').DataTable();
				  $('#myTableee').DataTable();
    </script>

</body>
</body>
</html>
