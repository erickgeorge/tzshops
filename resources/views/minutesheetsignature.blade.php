@extends('layouts.master')

@section('title')
    signature
    @endSection
@section('body')
    <style type="text/css">
    	.wrapper {
  position: relative;
  width: 400px;
  height: 200px;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.signature-pad {
  position: absolute;
  left: 0;
  top: 0;
  width:400px;
  height:200px;
  background-color: white;
}
    </style>
       <br>
    <div class="row container-fluid" style="margin-top: 6%;">
        <div class="col-lg-12">
            <h3 align="center"><b>Account settings - Signature</b></h3>
        </div>
        {{--<div class="col-md-4">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search by type, status and name" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>--}}
    </div>
    <hr>
<div class="container">
	<center>
    <div class="all-content-wrapper" style="margin-top: 100px;">
    	<h1>Sign below</h1>
    	<div class="row">
    		<div class="col">
<div class="wrapper">
  <canvas id="signature-pad" class="signature-pad" style="border:1px #000 solid; " width=400 height=200></canvas>
</div>
</div>
</div>
<br>
<div class="row">
	<div class="col">
<button id="save-png" class="btn btn-primary">Save Signature </button><!--
<button id="save-jpeg">Save as JPEG</button>
<button id="save-svg">Save as SVG</button> -->
<button id="draw" class="btn btn-info">Sign</button>
<!-- <button id="erase">Erase</button> -->
<button id="clear" class="btn btn-danger">Clear</button>
</div>
</div>
</div>
</center>
</div>
 

<script src="https://szimek.github.io/signature_pad/js/signature_pad.umd.js"></script>
<script type="text/javascript">
var canvas = document.getElementById('signature-pad');

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});

document.getElementById('save-png').addEventListener('click', function () {
  if (signaturePad.isEmpty()) {
    return alert("Please provide a signature first.");
  }
 var data = signaturePad.toDataURL('image/jpeg'); 
 window.location.href = "{{ url('savesign') }}?img=" + data;
});

/*document.getElementById('save-jpeg').addEventListener('click', function () {
  if (signaturePad.isEmpty()) {
    return alert("Please provide a signature first.");
  }

  var data = signaturePad.toDataURL('image/jpeg');
  console.log(data);
  window.open(data);
}); 

document.getElementById('save-svg').addEventListener('click', function () {
  if (signaturePad.isEmpty()) {
    return alert("Please provide a signature first.");
  }

  var data = signaturePad.toDataURL('image/svg+xml');
  console.log(data);
  console.log(atob(data.split(',')[1]));
  window.open(data);
}); */

document.getElementById('clear').addEventListener('click', function () {
  signaturePad.clear();
});

document.getElementById('draw').addEventListener('click', function () {
  var ctx = canvas.getContext('2d');
  console.log(ctx.globalCompositeOperation);
  ctx.globalCompositeOperation = 'source-over'; // default value
});

/*document.getElementById('erase').addEventListener('click', function () {
  var ctx = canvas.getContext('2d');
  ctx.globalCompositeOperation = 'destination-out';
}); */
</script>

@endsection