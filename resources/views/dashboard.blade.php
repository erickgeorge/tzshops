@extends('layouts.master')

@section('title')
Dashboard
@endSection

@section('body')


<style type="text/css">
	.ui-state-disabled {
    display: none;
}</style>

<div class='container'>
</br>
</br>
<div id="tabs">
    <ul>
        <li><a href="#tabs-0">Tab1</a> 
        </li>
        <li><a href="#tabs-1">Tab2</a>

        </li>
        <li><a href="#tabs-2">Tab3</a>

        </li>
        <li><a href="#tabs-3">Tab4</a>

        </li>
    </ul>
    <div id="tabs-0"> <b>Name</b>

        <input type="text" id="name" />
        <br/> <b>Age</b>

        <input type="text" id="age" />
        <br/>
        <input type="submit" value="next" class="submit" />
    </div>
    <div id="tabs-1"> <b>city</b>

        <input type="text" id="name" />
        <br/> <b>state</b>

        <input type="text" id="age" />
        <br/>
        <input type="submit" value="next" class="submit" />
    </div>
    <div id="tabs-2">
        <p>Tab3</p>
    </div>
    <div id="tabs-3">
        <p>Tab4</p>
    </div>
</div>
<input type="checkbox" name="tabs-0" value="0" checked>tabs-1
<input type="checkbox" name="tabs-1" value="1" disabled>tabs-2
<input type="checkbox" name="tabs-2" value="2" disabled>tabs-3
<input type="checkbox" name="tabs-3" value="3" disabled>tabs-4
<br>

<script type="text/javascript">
	
	$(function () {
    $("#tabs").tabs();
    $("#tabs").tabs("option", {
        "selected": 0,
            "disabled": [1, 2, 3]
    });

    $('.submit').click(function () {
        var nexttab = parseInt($(this).parent().next().attr('id').match(/\d+/g), 10);
        $('#tabs').tabs("enable", nexttab).tabs("select", nexttab);
        $('input[name="tabs-'+nexttab+'"]').removeAttr('disabled').prop('checked', true);
    });


    $("input[type=checkbox]").click(function () {
        if ($(this).is(':checked')) {
            $('#tabs').tabs("enable", $(this).val());
            $('#tabs').tabs("select", $(this).val()-1);
        } else {
            $('#tabs').tabs("disable", $(this).val());
            var tab = $(this);
            $(":checked").each(function (index) {
                $('#tabs').tabs("select", $(this).val());
            });
        }
    });
});
</script>



@endSection