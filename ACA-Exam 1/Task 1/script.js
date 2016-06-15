var div1 = document.getElementById('div_1');
var div2 = document.getElementById('div_2');
var div3 = document.getElementById('div_3');
var div4 = document.getElementById('div_4');
function draw(){
	var value1 = parseInt(document.getElementById('input_1').value);
	var value2 = parseInt(document.getElementById('input_2').value);
	var value3 = parseInt(document.getElementById('input_3').value);
	var value4 = parseInt(document.getElementById('input_4').value);
	if(value1 > 400 || value2 > 400 || value3 > 400 || value4 > 400){
		alert("Maximum is 400px");
		return;
	} else {
		div1.style.height = value1 + "px";
		div2.style.height = value2 + "px";
		div3.style.height = value3 + "px";
		div4.style.height = value4 + "px";
	}
}