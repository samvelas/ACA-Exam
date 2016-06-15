function count(){
				var num1 = parseInt(document.getElementById('first').value);
				var num2 = parseInt(document.getElementById('second').value);
				var opt = document.getElementById('opt');
				if (isNaN(num1) || isNaN(num2)){
					alert("Enter valid numbers!");
					return;
				}
				if(opt.options[opt.selectedIndex].text == ""){
					alert("Select option!");
					return;
				}
				answer.innerHTML = smth(num1, opt.options[opt.selectedIndex].text, num2) + "";
			}
			
			function smth(num_1, move, num_2){
				if(move == "+"){
					return num_1 + num_2;
				}
				else if(move == "-"){
					return num_1 - num_2;
				}
				else if(move == "/"){
					return num_1 / num_2;
				}
				else if(move == "*"){
					return num_1 * num_2;
				}
			}