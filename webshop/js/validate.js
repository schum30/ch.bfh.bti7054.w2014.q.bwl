function validateLoginForm() {
	var username = document.forms["login"]["username"].value;
	var password = document.forms["login"]["password"].value;
	if(username == null || username == ""){
		alert("username must be filled out");
		return false;
	}
	if(password == null || password == ""){
		alert("password must be filled out");
		return false;
	}
}
