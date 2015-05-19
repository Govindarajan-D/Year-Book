function reset(){
form = document.getElementsByTagName("form")[0];
form.user.value="";
form.pass.value="";
form.passw.value="";
form.type.value="1";
}
function validate(){
		form = document.getElementsByTagName("form")[0];
		valString = /[A-z.]$/; //Use  /[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/; for email ID
		if(!(valString.test(form.user.value)))
		{	displayBox("Error: Invalid Username");
			return false;
		}
		valString = /[a-zA-Z0-9@*#&]{8,15}$/;
		if(!(valString.test(form.pass.value)))
		{ displayBox("Error: Invalid Password"); return false;}
		var shaObj = new jsSHA(form.pass.value, "TEXT");
		form.passw.value = shaObj.getHash("SHA-512", "HEX");
		form.pass.value = ""; // Done to avoid sending plain text password over the network
		return true;
	}
function signUp(){

		var confPasswd = document.createElement("input");
		confPasswd.className = "form-control";
		confPasswd.type = "password";
		confPasswd.name = "confpassw";
		confPasswd.placeholder = "Type Password Again";
		confPasswd.required = true;
		
		var passElmt = document.getElementsByName("pass")[0];
		passElmt.style.borderBottomRightRadius = 0; 
		passElmt.style.borderBottomLeftRadius = 0;
		
		inputs = document.getElementById("texts");
		inputs.appendChild(confPasswd);
		
		document.getElementsByClassName("form-signin-heading")[0].innerHTML = "Sign Up";
		newBtn();
	}
function newBtn(){
	document.getElementById("signUp").remove();
	document.getElementById("logIn").remove();
	
	var signUp = document.createElement("input");
	signUp.className = "btn btn-lg btn-primary btn-block";
	signUp.id = "newSignUp";
	signUp.value="Register";
	
	form = document.getElementsByTagName("form")[0];
	form.appendChild(signUp);
	
	signUp.onclick = function(){
		document.getElementsByName("type")[0].value = "2";
		if(form.pass.value !== "" && form.confpassw.value !== "" && form.user.value !== "" )
			if(form.pass.value === form.confpassw.value)
			{
				if(validate())
				{
					form.pass.value = form.confpassw.value = ""; //Done to avoid sending plain text password over the network
					form.submit();
				}
			}
			else
				alert("Error: Passwords do not match");
		else
			alert("Error: Field Empty");
	}
}