@extends('layouts.master')

@section('title')
    works orders
    @endSection

@section('body')



<style type="text/css">
  
 body {
                
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                 
            
            }

hr {
  margin-top: 0rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 5px solid rgb(333,333,559);
}

body {
  background-color: #EBE8E4;
  color: #222;
  font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  font-weight: 300;
  font-size: 15px;
}



u li a {

  
  text-decoration: none;
  padding: 5px;
    
    border: 1px solid blue;
    background-color: #cccccc;
     margin: 5px;
     font-family: verdana, helvetica, sans-serif;
    font-size: 10pt;
    line-height: 12pt;
}
}
/* Change the link color on hover */





body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Style the header */
header {
  background-color: #666;
  padding: 30px;
  text-align: center;
  font-size: 35px;
  color: white;
}

/* Create two columns/boxes that floats next to each other */
u {
  float: left;
  width: 28%;
  height: 300px; /* only for demonstration, should be removed */
  margin: 1px;
  padding: 79px;
}

/* Style the list inside the menu */
u ul {
  list-style-type: none;
  padding: 0;
}

article {
  float: left;
  padding: 10px;
  width: 70%;
  background-color: white;
  /* only for demonstration, should be removed */
}

/* Clear floats after the columns */
section:after {
  content: "";
  display: table;
  clear: both;

}

/* Style the footer */
footer {
  background-color: rgb(238, 238, 238);
  padding: 10px;
  text-align: right;
  font-style: italic;
}

/* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
@media (max-width: 600px) {
  nav, article {
    width: 100%;
    height: auto;
  }
}


</style>
  <title>login</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<br>
<br>
<br>




<footer>
  <p></p>
</footer>



<u>
    <ul>
                       <LI><a  href="{{ url('unattended_work_orders')}}">Unatttended Works orders</a></LI>
                    </ul>

      <ul>
        <li><a  href="{{ url('completed_work_orders')}}">Completed Works Orders</a></li>
     </ul>
    
     <ul>
        <li><a  href="{{ url('work_order')}}">Works Orders</a></li>
     </ul>
     <ul>
        <li><a  href="{{ url('woduration')}}">Works Order Duration</a></li>
     </ul>
     
</u>



<body style="background-color: white" >

  

<article style="height: 1500px">

 
  
  <h1 >List of available works order reports to be downloaded</h1>
  <hr>


              

<ul>
        <li>Unattended Works Orders</li>
     </ul>

      <ul>
        <li>Completed Works Orders</li>
     </ul>
    
     <ul>
        <li>Works Orders</li>
     </ul>
     <ul>
        <li>Works Order Duration</li>
     </ul>






</article>
  
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>


<footer>
  <p style="text-align: center">Workorder reports</p>
</footer>

</body>
@endsection
