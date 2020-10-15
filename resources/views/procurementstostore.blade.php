@extends('layouts.master')

@section('title')
Add New Procured Material
    @endSection

@section('body')
<?php use App\workordersection; use App\Material; ?>
<style>
        table {
            width: 100%;
            font: 17px Calibri;
        }
        table, th, td {
            border: solid 1px #DDD;
            border-collapse: collapse;
            padding: 2px 3px;
            text-align: center;
        }
    </style>
<br>
<div class="container" >
  <div class="col-lg-4">
    <h5 style="text-transform: capitalize;" >Add New Procured Materials</h5>
  </div>
  @if(Session::has('message'))
    <br>
    <p class="alert alert-success">{{ Session::get('message') }}</p>
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

<hr>
<div style="margin: 1.5%;">
	<p style="color: red;"> All fields are compulsory</p>
	<div class="row">
<div class="col-sm-2">

</div>
</div>	<br>
<form method="POST" action="{{ url('procuredmaterialsadding') }}" enctype="multipart/form-data" autocomplete="off">
	@csrf
    <div id="cont">

    </div>
    <input id="totalmaterials" type="text" name="totalinputs" value="" hidden>
    <p>
        <div class="row">
            <div class="col">
                <a id="addRow" onclick="addRow()" class="btn btn-outline-info"><i class="fa fa-plus"></i> Add New Row</a>
            </div>
        </div><br>
        <div class="row">

			<div class="col">
				<button id="bt" type="submit" class="btn btn-primary" disabled>Submit</button>&nbsp;<a href="{{ url('ProcurementHistory') }}" class="btn btn-danger">Cancel</a>
			</div>
		</div>
    </p>
</form>
</div>




<script>
    // ARRAY FOR HEADER.
    var arrHead = new Array();
    arrHead = ['','Material ID', 'Description','Type', 'Unit Measure','Total','Price', ];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

    // FIRST CREATE A TABLE STRUCTURE BY ADDING A FEW HEADERS AND
    // ADD THE TABLE TO YOUR WEB PAGE.
    function createTable() {
        var MatForm = document.createElement('table');
        MatForm.setAttribute('id', 'MatForm');            // SET THE TABLE ID.

        var tr = MatForm.insertRow(-1);

        for (var h = 0; h < arrHead.length; h++) {
            var th = document.createElement('th');


            if(h==5){
                	th.setAttribute('style','width:95px;');
                }


                if(h==6){
                	th.setAttribute('style','width:125px;');
                }

                if(h ==3){
                    th.setAttribute('style','width:100px;');
                }

                if(h==4){
                	th.setAttribute('style','width:125px;');
                }

                     // TABLE HEADER.
            th.innerHTML = arrHead[h];
            tr.appendChild(th);
        }

        var div = document.getElementById('cont');
        div.appendChild(MatForm);    // ADD THE TABLE TO YOUR WEB PAGE.

        var empTab = document.getElementById('MatForm');

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
        tr = empTab.insertRow(rowCnt);

        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                 // ADD A BUTTON.
                var button = document.createElement('button');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-danger');
                if(c==0)
                {
                    button.setAttribute('disabled', 'true');

                }
                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);

                var i = document.createElement('i');
                	i.setAttribute('class', 'fa fa-trash');
                	button.appendChild(i);
            }
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
               if(c==3)
                {
                        var ele = document.createElement('select');
                }else
                {
                    var ele = document.createElement('input');
                }
                if(c==1){
                    ele.setAttribute('onClick','reply_click(this.id)');
                }
                if(c==2){
                    ele.setAttribute('onClick','reply_click1(this.id)');
                }

                ele.setAttribute('id',c);
                if(c==5){
                    ele.setAttribute('type', 'number');
                    ele.setAttribute('min', '1');
                    ele.setAttribute('style','width:90px;');
                } else
                 if(c==6){
                    ele.setAttribute('type', 'number');
                    ele.setAttribute('min', '1');
                    ele.setAttribute('style','width:120px;');
                }
                else{
                    ele.setAttribute('type', 'text');
                }



                if(c==3){
                    ele.setAttribute('style','width:100px;');
                }
                if(c==4){
                    ele.setAttribute('style','width:120px;');
                }

                ele.setAttribute('required', '');
                ele.setAttribute('class', 'form-control');
                ele.setAttribute('name',c);
                if(c==2){
                    ele.setAttribute('onClick','reply_click1(this.id)');
                }
                if(c==1){
                    ele.setAttribute('onClick','reply_click(this.id)');
                }
                ele.setAttribute('id',c);



    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('totalmaterials').value = value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }

            ele.setAttribute('value', '');
            ele.setAttribute('name',value);
            ele.setAttribute('id',value);
            td.appendChild(ele);

            if(c==3)
                {
                    var option = document.getElementById(value);

                    <?php $worksections = workordersection::get(); ?>
                    @foreach($worksections as $section)
                    var options = document.createElement('option');
                    options.setAttribute('value','<?php echo $section->section_name; ?>');
                    options.text = "<?php echo $section->section_name; ?>";
                    option.appendChild(options);
                    @endforeach
                }

            }
        }


    }

    // ADD A NEW ROW TO THE TABLE.s
    function addRow() {
        var empTab = document.getElementById('MatForm');

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
        tr = empTab.insertRow(rowCnt);

        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                // ADD A BUTTON.
                var button = document.createElement('button');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-danger');

                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);

                var i = document.createElement('i');
                	i.setAttribute('class', 'fa fa-trash');
                	button.appendChild(i);
            }
           else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
                if(c==3)
                {
                        var ele = document.createElement('select');
                }else
                {
                    var ele = document.createElement('input');
                }
                if(c==1){
                    ele.setAttribute('onClick','reply_click(this.id)');
                }
                if(c==2){
                    ele.setAttribute('onClick','reply_click1(this.id)');
                }

                ele.setAttribute('id',c);
                if(c==5){
                    ele.setAttribute('type', 'number');
                    ele.setAttribute('min', '1');
                    ele.setAttribute('style','width:90px;');
                } else
                 if(c==6){
                    ele.setAttribute('type', 'number');
                    ele.setAttribute('min', '1');
                    ele.setAttribute('style','width:120px;');
                }
                else{
                    ele.setAttribute('type', 'text');
                }



                if(c==3){
                    ele.setAttribute('style','width:100px;');
                }
                if(c==4){
                    ele.setAttribute('style','width:120px;');
                }

                ele.setAttribute('required', '');
                ele.setAttribute('class', 'form-control');
                ele.setAttribute('name',c);
                if(c==2){
                    ele.setAttribute('onClick','reply_click1(this.id)');
                }
                if(c==1){
                    ele.setAttribute('onClick','reply_click(this.id)');
                }
                ele.setAttribute('id',c);



    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('totalmaterials').value = value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }

            ele.setAttribute('value', '');
            ele.setAttribute('name',value);
            ele.setAttribute('id',value);
            td.appendChild(ele);

            if(c==3)
                {
                    var option = document.getElementById(value);

                    <?php $worksections = workordersection::get(); ?>
                    @foreach($worksections as $section)
                    var options = document.createElement('option');
                    options.setAttribute('value','<?php echo $section->section_name; ?>');
                    options.text = "<?php echo $section->section_name; ?>";
                    option.appendChild(options);
                    @endforeach
                }

            }
        }


    }

    // DELETE TABLE ROW.
    function removeRow(oButton) {
        var empTab = document.getElementById('MatForm');
    var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;
    --value; --value; --value; --value; --value; --value;
    document.getElementById('totalmaterials').value = value;
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);

var value = parseInt(document.getElementById('totalmaterials').value, 10);
    value = isNaN(value) ? 0 : value;

    var hide = document.getElementById('bt');
        if (value > 1) {
            hide.disabled = false;
        }
        else {
            hide.disabled = true;
        }
              // BUTTON -> TD -> TR.
    }

    // EXTRACT AND SUBMIT TABLE DATA.
    function submit() {
        var myTab = document.getElementById('MatForm');
        var values = new Array();

        // LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length - 1; row++) {
            for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'text') {
                    values.push("'" + element.childNodes[0].value + "'");
                }
            }
        }

        // SHOW THE RESULT IN THE CONSOLE WINDOW.
        console.log(values);
    }



</script>
<script>
function reply_click(clicked_id)
  {
      var clicked = clicked_id;

function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("style","max-height:120px; overflow:scroll;");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

<?php $materialname = Material::select('name')->distinct()->get(); ?>
/*An array containing all the country names in the world:*/
var materials = [@foreach($materialname as $materialised)"{{ $materialised->name }}",@endforeach];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById(clicked), materials);
}

</script>
<script type="text/javascript">

function reply_click1(clicked_id)
  {
      var clicked = clicked_id;

function autocomplete1(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var x, y, z, bal = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!bal) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      x = document.createElement("DIV");
      x.setAttribute("id", this.id + "autocomplete-list");
      x.setAttribute("style","max-height:120px; overflow:scroll;");
      x.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(x);
      /*for each item in the array...*/
      for (z = 0; z < arr.length; z++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[z].substr(0, bal.length).toUpperCase() == bal.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          y = document.createElement("DIV");
          /*make the matching letters bold:*/
          y.innerHTML = "<strong>" + arr[z].substr(0, bal.length) + "</strong>";
          y.innerHTML += arr[z].substr(bal.length);
          /*insert a input field that will hold the current array item's value:*/
          y.innerHTML += "<input type='hidden' value='" + arr[z] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          y.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          x.appendChild(y);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var s = document.getElementById(this.id + "autocomplete-list");
      if (s) s = s.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(s);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(s);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (s) s[currentFocus].click();
        }
      }
  });
  function addActive(s) {
    /*a function to classify an item as "active":*/
    if (!s) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(s);
    if (currentFocus >= s.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (s.length - 1);
    /*add class "autocomplete-active":*/
    s[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(s) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var z = 0; z < s.length; z++) {
      s[z].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var s = document.getElementsByClassName("autocomplete-items");
    for (var z = 0; z < s.length; z++) {
      if (elmnt != s[z] && elmnt != inp) {
        s[z].parentNode.removeChild(s[z]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

<?php $description = Material::select('description')->distinct()->get(); ?>
/*An array containing all the country names in the world:*/
var items = [@foreach($description as $mater)"{{ $mater->description }}",@endforeach];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete1(document.getElementById(clicked), items);
}
</script>

@endsection
