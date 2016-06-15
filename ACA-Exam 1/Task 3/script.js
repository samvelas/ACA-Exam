window.updateMonth= function(iMonth, iDay) {
	var el = document.getElementById(iDay);
	el.options.length = 0;
   
	for(var d = new Date(2013,iMonth-1,1); d.getMonth()==iMonth-1; d.setDate(d.getDate()+1)) {
		option = new Option(d.getDate(), d.getDate());
		el.options[d.getDate()-1] = option;
	}; 
		   
}

function validate(){
	var name = document.getElementById('name');
	var surname = document.getElementById('surname');
	var email = document.getElementById('email');
	var year = document.getElementById('year');
	if(name.value.length > 20 || name.value.length == 0){
		name.style.borderColor = "#f0f";
	} else {
		name.style.borderColor = "#ccc";
	}
	if(surname.value.length > 20 || surname.value.length == 0){
		surname.style.borderColor = "#f0f";
	} else {
		surname.style.borderColor = "#ccc";
	}
	if(!check(email.value)){
		email.style.borderColor = "#f0f";
	} else {
		email.style.borderColor = "#ccc";
	}
	if(year.value.length != 4 || isNaN(parseInt(year.value))){
		year.style.borderColor = "#f0f";
	} else {
		year.style.borderColor = "#ccc";
	}
}

function check(value) {
	var valid = true;
	if (value.indexOf('@') == -1) {
		valid = false;
	} else {
		var parts = value.split('@');
		var domain = parts[1];
		if (domain.indexOf('.') == -1) {
			valid = false;
		} else {
			var domainParts = domain.split('.');
			var ext = domainParts[1];
			if (ext.length < 2) {
				valid = false;
			}
		}

	}

	return valid;

};
