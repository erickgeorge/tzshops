@extends('layouts.master')

@section('title')
  Increment Material
    @endSection

@section('body')
    <br>
    <div class="row">
        <div class="col-md-8">
            <h2>Increment Current Material in Store</h2>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
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

 
    </br>
    <form method="POST" action="{{ route('material.increment') }}"   style="width:500px;">
        @csrf
		
		
		
		 <div id="divmanual">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Material Name</label>
                </div>
                <input disabled value="{{$item->name}}" style="color: black" required type="text" maxlength="35" class="form-control" id="name"
                       aria-describedby="emailHelp" name="name" placeholder="{{$item->name}}">
            </div>
        </div>
		
		   <input hidden value="{{$item->id}}"  id="nameid"
                      name="nameid" >
		
		 <div id="divmanual">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Material Description</label>
                </div>
                <input disabled value="{{$item->description}}" style="color: black" required type="text" maxlength="35" class="form-control" id="description"
                       aria-describedby="emailHelp" name="description" placeholder="{{$item->description}}">
            </div>
        </div>
		
		
      

        <div id="divmanual">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Current Quantity</label>
                </div>
                <input disabled value="{{$item->stock}}" style="color: black" required type="number"  id="stock"  class="form-control" 
                       aria-describedby="emailHelp" name="istock" placeholder="{{$item->stock}}">
            </div>
        </div>
		
		
		<div id="divmanual">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Add Quantity</label>
                </div>
                <input  oninput="totalitem()" style="color: black" required type="number" min="1"  class="form-control" id="istock"
                       aria-describedby="emailHelp" name="istock" placeholder="Current Stock">
            </div>
        </div>
		
		<div id="divmanual">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label style="color:red;" class="input-group-text" for="inputGroupSelect01">Total Quantity</label>
                </div>
                <input  style="color: black"  type="number"  class="form-control" id="tstock"
                       aria-describedby="emailHelp" name="tstock" placeholder="Total Stock">
            </div>
        </div>
		
        <button type="submit" class="btn btn-success">Add Material</button>

        <a class="btn btn-info" href="/home" role="button">Cancel Changes</a>

        </div>
    </form>

    <br>
   <script>
function totalitem() {
  var x = document.getElementById("stock").value;
  var y = document.getElementById("istock").value;
  var z  = parseInt(x) + parseInt(y);
  document.getElementById("tstock").value=z;
  document.getElementById("tstock").innerHTML = z;
}
</script>
	
    @endSection