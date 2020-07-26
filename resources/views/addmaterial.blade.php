@extends('layouts.master')

@section('title')
    Add new Material
    @endSection

@section('body')
<?php use App\workordersection; ?>
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
<div class="container" style="margin-top: 6%;">
  <div class="col-lg-4">
    <h5 style="text-transform: capitalize;" >Add new Material</h5>
  </div>
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
    <p style="color: red;">* all fields are compulsory</p>
    <div class="row">
<div class="col-sm-2">

</div>
</div>  <br>
<form method="POST" action="{{ route('material.create') }}" enctype="multipart/form-data">
    @csrf
    <div id="cont"></div>
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
    arrHead = ['','Material Name', 'Description','Type', 'Unit Measure','Total', ];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

    // FIRST CREATE A TABLE STRUCTURE BY ADDING A FEW HEADERS AND
    // ADD THE TABLE TO YOUR WEB PAGE.
    function createTable() {
        var MatForm = document.createElement('table');
        MatForm.setAttribute('id', 'MatForm');            // SET THE TABLE ID.

        var tr = MatForm.insertRow(-1);

        for (var h = 0; h < arrHead.length; h++) {
            var th = document.createElement('th');


            if(h==5){
                    th.setAttribute('style','width:95px;')
                }




                if(h ==3){
                    th.setAttribute('style','width:100px;')
                }

                if(h==4){
                    th.setAttribute('style','width:125px;')
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
                button.setAttribute('class', 'btn btn-danger')

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
                if(c==5){
                    ele.setAttribute('type', 'number');
                    ele.setAttribute('style','width:90px;')
                }
                else{
                    ele.setAttribute('type', 'text');
                }


                if(c==3){
                    ele.setAttribute('style','width:100px;')
                }
                if(c==4){
                    ele.setAttribute('style','width:120px;')
                }

                ele.setAttribute('required', '');
                ele.setAttribute('class', 'form-control');
                ele.setAttribute('name',c);



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
                button.setAttribute('class', 'btn btn-danger')

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
                if(c==5){
                    ele.setAttribute('type', 'number');
                    ele.setAttribute('style','width:90px;')
                }
                else{
                    ele.setAttribute('type', 'text');
                }



                if(c==3){
                    ele.setAttribute('style','width:100px;')
                }
                if(c==4){
                    ele.setAttribute('style','width:120px;')
                }

                ele.setAttribute('required', '');
                ele.setAttribute('class', 'form-control');
                ele.setAttribute('name',c);



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
    --value; --value; --value; --value; --value;
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

@endsection
