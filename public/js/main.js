function generatePass(){
	var alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890.@"
	var password = "";
	for (var i = 0; i < 7; i++) {
		password += alphabets.charAt(Math.floor(Math.random() * alphabets.length));
	}

	document.getElementById('pass').value = password;
}

var selecteddep = null;
var selectedsection = null;
function getDepartments(){
	selecteddep = document.getElementById('directorate').value;

    console.log('ID: '+selecteddep);
	$.ajax({
		method: 'GET',
		url: 'departments/',
		data: {id: selecteddep}
	})
	.done(function(msg){
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
function getSections(){
	selectedsection = document.getElementById('department').value;

	$.ajax({
		method: 'GET',
		url: 'sections/',
		data: {id: selectedsection}
	})
	.done(function(msg){
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
        data: {id: selectedLoc}
    })
        .done(function(msg){
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
        data: {id: selectedArea}
    })
        .done(function(msg){
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
        data: {id: selectedBlock}
    })
        .done(function(msg){
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