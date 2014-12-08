function lieferadresse(){ 
    var value = document.bestellung.shippingaddress.value; 
    if(value == "billingaddress"){
        document.getElementById("shippingaddress").style.display = "none";   
    }
    else{
        document.getElementById("shippingaddress").style.display = "block";
    } 
} 
