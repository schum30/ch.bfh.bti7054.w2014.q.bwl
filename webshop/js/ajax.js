function showResult(str) {
	selected = document.getElementById("selected");
	if(selected != null){
		selected.className = "";
	}
	if (str.length==0) {
		location.reload();
		return;
	}
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("products").outerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","search.php?query="+str,true);
	xmlhttp.send();
}

function addItemToCart(id, option, amount) {
	if(id == null){
		return;
	}
	xmlhttp= new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("basket").outerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "cart.php?action=add&id="+id+"&option="+option+"&amount="+amount,true);
	xmlhttp.send();
}

function removeItemFromCart(id, option, amount) {
	if(id == null){
		return;
	}
	xmlhttp= new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("basket").outerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "cart.php?action=remove&id="+id+"&option="+option+"&amount="+amount,true);
	xmlhttp.send();
}
function changeAddress(id, street, plz, city, title, text){
	if(id == null || street == null || plz == null || city == null){
		return;
	}
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		showPopUpAlert(title, text)
	}
}
