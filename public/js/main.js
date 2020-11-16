function generatePass() {
    var alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890.@"
    var password = "";
    for (var i = 0; i < 9; i++) {
        password += alphabets.charAt(Math.floor(Math.random() * alphabets.length));
    }

    document.getElementById('pass').value = password;
}



function printdiv(printpage) {
    var headstr = "<html><head><title></title></head><body><h1> WORK ORDER LIST </h1>";
    var footstr = "</body>";
    var newstr = document.all.item(printpage).innerHTML;
    //var exclude = document.getElementByid('exclude').innerHTML;
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr + newstr + footstr;

    window.print();
    document.body.innerHTML = oldstr;
    return false;
}



$("#divmanual").hide();
$(function() {
    $("#checkdiv").click(function() {
        if ($(this).is(":checked")) {
            $("#location").removeAttr('required');
            $("#area").removeAttr('required');
            $("#block").removeAttr('required');
            $("#room").removeAttr('required');


            $("#manual").attr('required', '');


            $("#divmanual").show();
            $("#locationdiv").hide();
        } else {
            $("#location").attr('required', '');
            $("#area").attr('required', '');
            $("#block").attr('required', '');
            $("#room").attr('required', '');

            $("#manual").removeAttr('required');
            $("#divmanual").hide();
            $("#locationdiv").show();
        }
    });
});


function ShowwHideDiv(checkdiv) {
    var dvPassport = document.getElementById("locationdiv");
    locationdiv.style.display = checkdiv.checked ? "block" : "none";
}


// function inafichwaIfNotDESHere(checkdiv) {
//     var dvPassport = document.getElementById("locationdiv");
//     locationdiv.style.display = checkdiv.checked ? "block" : "none";
// }




var selecteddep = null;
var selectedsection = null;

function getDepartments() {
    selecteddep = document.getElementById('directorate').value;



    var sel = document.getElementById("directorate");
    var text= sel.options[sel.selectedIndex].text;
        var sendSelectedLink = $("#inafichwaIfNotDES");
        console.log(text);
        if(text == '(DES) Directorate of Estates Services' )
        {
          sendSelectedLink.show();

            
        }else
        {
          sendSelectedLink.hide();
            }



    console.log('ID: ' + selecteddep);
    $.ajax({
            method: 'GET',
            url: 'departments/',
            data: { id: selecteddep }
        })
        .done(function(msg) {
            console.log(msg['departments']);
            var object = JSON.parse(JSON.stringify(msg['departments']));
            $('#department').empty();

            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('department').appendChild(option);




            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].description;
                option.value = object[i].id;
                document.getElementById('department').appendChild(option);
            }
        });
}

function getSections() {
    selectedsection = document.getElementById('department').value;

    $.ajax({
            method: 'GET',
            url: 'sections/',
            data: { id: selectedsection }
        })
        .done(function(msg) {
            var object = JSON.parse(JSON.stringify(msg['sections']));
            console.log(object);
            $('#section').empty();
            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('section').appendChild(option);
            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].section_name;
                option.value = object[i].id;
                document.getElementById('section').appendChild(option);
            }
        });
}

var selectedLoc = null;
var selectedArea = null;
var selectedBlock = null;

function getAreas() {
    selectedLoc = document.getElementById('location').value;

    $.ajax({
            method: 'GET',
            url: 'areas/',
            data: { id: selectedLoc }
        })
        .done(function(msg) {
            var object = JSON.parse(JSON.stringify(msg['areas']));
            $('#area').empty();


            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('area').appendChild(option);





            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].name_of_area;
                option.value = object[i].id;
                document.getElementById('area').appendChild(option);
            }
        });
}

function getBlocks() {
    selectedArea = document.getElementById('area').value;

    $.ajax({
            method: 'GET',
            url: 'blocks/',
            data: { id: selectedArea }
        })
        .done(function(msg) {
            var object = JSON.parse(JSON.stringify(msg['blocks']));
            $('#block').empty();



            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('block').appendChild(option);



            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].name_of_block;
                option.value = object[i].id;
                document.getElementById('block').appendChild(option);
            }
        });
}

function getRooms() {
    selectedBlock = document.getElementById('block').value;

    $.ajax({
            method: 'GET',
            url: 'rooms/',
            data: { id: selectedBlock }
        })
        .done(function(msg) {
            var object = JSON.parse(JSON.stringify(msg['rooms']));
            $('#room').empty();



            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('room').appendChild(option);


            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].name_of_room;
                option.value = object[i].id;
                document.getElementById('room').appendChild(option);
            }
        });
}

function openTab(evt, stepName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(stepName).style.display = "block";
    evt.currentTarget.className += " active";
}

function closeTab() {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }





    var selectedzone = null;

    function getinspector() {
        selectedzone = document.getElementById('iowzone').value;

        $.ajax({
                method: 'GET',
                url: 'inspectors/',
                data: { id: selectedzone }
            })
            .done(function(msg) {
                var object = JSON.parse(JSON.stringify(msg['inspectors']));
                $('#iowname').empty();


                var option = document.createElement('option');
                option.innerHTML = 'Choose...';
                option.value = '';
                document.getElementById('iowname').appendChild(option);





                for (var i = 0; i < object.length; i++) {
                    var option = document.createElement('option');
                    option.innerHTML = object[i].zone;
                    option.value = object[i].id;
                    document.getElementById('iowname').appendChild(option);
                }
            });
    }




}


function getRooms() {
    selectedBlock = document.getElementById('block').value;

    $.ajax({
            method: 'GET',
            url: 'rooms/',
            data: { id: selectedBlock }
        })
        .done(function(msg) {
            var object = JSON.parse(JSON.stringify(msg['rooms']));
            $('#room').empty();



            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('room').appendChild(option);


            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].name_of_room;
                option.value = object[i].id;
                document.getElementById('room').appendChild(option);
            }
        });
}


function getlocation1() {
   let selectedtype = document.getElementById('typeselector1').value;

    $.ajax({
        method: 'GET',
        url: 'sendreturnlocation',
        data: { id: selectedtype }
    })
        .done(function(msg) {
            var object = JSON.parse(JSON.stringify(msg['returnlocation']));
            console.log(object);
            $('#locationselector1').empty();



            var option = document.createElement('option');
            option.innerHTML = 'Choose...';
            option.value = '';
            document.getElementById('locationselector1').appendChild(option);


            for (var i = 0; i < object.length; i++) {
                var option = document.createElement('option');
                option.innerHTML = object[i].location;
                option.value = object[i].id;
                document.getElementById('locationselector1').appendChild(option);
            }
        });
}

// function getstatus() {
//     selectedBlock = document.getElementById('block').value;
//
//     $.ajax({
//         method: 'GET',
//         url: 'fetchstatus/',
//         data: { id: selectedBlock }
//     })
//         .done(function(msg) {
//             var object = JSON.parse(JSON.stringify(msg['rooms']));
//             $('#room').empty();
//
//
//
//             var option = document.createElement('option');
//             option.innerHTML = 'Choose...';
//             option.value = '';
//             document.getElementById('room').appendChild(option);
//
//
//             for (var i = 0; i < object.length; i++) {
//                 var option = document.createElement('option');
//                 option.innerHTML = object[i].name_of_room;
//                 option.value = object[i].id;
//                 document.getElementById('room').appendChild(option);
//             }
//         });
// }
