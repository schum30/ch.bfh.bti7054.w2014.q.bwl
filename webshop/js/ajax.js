function showResult(str) {
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
		document.getElementById("cart").innerHTML=xmlhttp.responseText;
	}
	xmlhttp.open("GET", "cart.php?action=add&id="+id+"?option="+option,true);
	xmlhttp.send();
}

function removeItemFromCart(id, option, amount) {
	if(id == null){
		return;
	}
	xmlhttp= new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		document.getElementById("cart").innerHTML=xmlhttp.responseText;
	}
	xmlhttp.open("GET", "cart.php?action=remove&id="+id,true);
	xmlhttp.send();
}
