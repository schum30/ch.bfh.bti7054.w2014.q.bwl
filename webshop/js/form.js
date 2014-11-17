function lieferadresse(){ 
    var value = document.bestellung.shippingaddress.value; 
    if(value == "billingaddress"){
        document.getElementById("shippingaddress").style.visibility = "hidden";   
    }
    else{
        document.getElementById("shippingaddress").style.visibility = "visible";
    } 
} 
