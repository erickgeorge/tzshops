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

	$.ajax({
		method: 'GET',
		url: 'departments/',
		data: {id: selecteddep}
	})
	.done(function(msg){
		var object = JSON.parse(JSON.stringify(msg['departments']));
		$('#department').empty();
		for (var i = 0; i < object.length; i++) {
			var option = document.createElement('option');
			option.innerHTML = object[i].name;
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
		for (var i = 0; i < object.length; i++) {
			var option = document.createElement('option');
			option.innerHTML = object[i].section_name;
			option.value = object[i].id;
			document.getElementById('section').appendChild(option);
		}
	});
}