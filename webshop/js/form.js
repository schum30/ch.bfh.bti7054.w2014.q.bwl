function lieferadresse(){
    var value = document.bestellung.shippingaddress.value; 
    if(value == "billingaddress"){
        document.getElementById("shippingaddress").style.display = "none";   
    }
    else{
        document.getElementById("shippingaddress").style.display = "block";
    } 
}
function submitLogin(){
	document.forms["login"].submit();
}
function submitCartForm(productId){
	document.forms["generated-"+productId].submit();
}
function submitAddressChangeForm(addressId){
	form = document.forms["generated-change-"+addressId];
	firstName = form.elements["firstName"].value;
	lastName = form.elements["lastName"].value;
	phone = form.elements["phone"].value;
	street = form.elements["street"].value;
	plz = form.elements["plz"].value;
	city = form.elements["city"].value;	
	params = "street="+street+"&plz="+plz+"&city="+city;
	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "change.php?action=address", true);
	
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			showPopUpAlert("",xmlhttp.responseText);
		}
	}
	
	xmlhttp.send(params);
}
