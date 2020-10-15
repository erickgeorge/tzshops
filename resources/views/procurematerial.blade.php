@extends('layouts.master')

@section('title')
Procure Material
@endSection

@section('body')

<script>
var total=2;

</script>
<div class='container'>
</br>
</br>
<?php
$id=$_GET["id"];

//echo $id;
?>

 <?php

 use App\Material;
						$materials= Material::get();
						$mat= Material::get();
						$matvalue= Material::get();
						?>


				          <div id="material_request" class="col-lg-12">
                <form method="POST"  action="{{ route('work.purchasingorder', [$id]) }}" >


                    @csrf

                        <div class="row" style="margin-top: 6%">
                            <div >
                               <h5      >Select Material for Work Order</h5>
                            </div>
                        </div>

						<?php


						$materials= Material::get();

						?>




                        <div class="form-group col-lg-6">

                            <select onchange="stock();" required class="custom-select"  id="mname" name="1">
                                <option   selected value="" >Choose...</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name.' '.$material->description }}</option>
                                @endforeach
                            </select>
                        </div>


						 <p>Quantity <sup style="color: red;">*</sup></p>
                        <div class="form-group col-lg-6">
                            <input type="number" min="1"  style="color: black" name="2" required class="form-control"  rows="5" id="2"></input>
                        </div>


						<div id="newmaterial" >


						</div>
					<input type="hidden" id="totalmaterials" value="2"  name="totalmaterials" ></input>


                        <button  onclick="newmaterial()" class="btn btn-primary">New Material</button>
                        <a href="#" onclick="closeTab()"><button type="button"  class="btn btn-danger">Cancel</button></a>
                         <button type="submit" class="btn btn-primary">Save Material</button>

                </form>


				 </div>
                {{-- end material_request  --}}
@endSection
 <script type="text/javascript" language="javascript">
    var array = new Array();
	 var arrayvalue = new Array();
    <?php foreach($mat as $key){ ?>
        array.push('<?php echo $key->name." ".$key->description ; ?>');
    <?php } ?>


	<?php foreach($mat as $key ){ ?>
        arrayvalue.push('<?php echo $key->id ; ?>');
    <?php } ?>
</script>


<script>

	  function newmaterial(){

		 total=total+1;


		 var myDiv = document.getElementById("newmaterial");


		 var node = document.createElement("label");
  var textnode = document.createTextNode("Material");
  node.appendChild(textnode);
myDiv.appendChild(node);




//Create array of options to be added
//var array = ["Volvo","Saab","Mercades","Audi"];

//Create and append select list
var selectList = document.createElement("select");
 selectList.className = "custom-select";
selectList.required = true;
selectList.name = total;

myDiv.appendChild(selectList);

//Create and append the options
 var option = document.createElement("option");

    option.text = 'Choose ...';
	 option.value = '';
    selectList.appendChild(option);

for (var i = 0; i < array.length; i++) {
    var option = document.createElement("option");
    option.value = arrayvalue[i];
    option.text = array[i];
    selectList.appendChild(option);
}

 var node = document.createElement("label");
  var textnode = document.createTextNode("Quantity");
  node.appendChild(textnode);
myDiv.appendChild(node);


 var input = document.createElement("input");
		 input.setAttribute('type', 'number');
		 input.min=1;
		 input.required = true;

		 total=total+1;

		 input.name = total;
		 input.className = "form-control";
		 var parent = document.getElementById("newmaterial");


		parent.appendChild(input);



		 var node = document.createElement("br");

myDiv.appendChild(node);

document.getElementById("totalmaterials").value=total;


	 }

</script>
