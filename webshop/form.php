<?php 
    if(isset($_POST["submitted"])){
        $first = $_POST['billing_firstname']; 
        $last = $_POST['billing_lastname']; 
        $address = $_POST['billing_address'];
        $postal = $_POST['billing_postalcode'];
        $city = $_POST['billing_city'];  
        
        switch ($_POST['billing_country']){
            case 'de':
                $country = "Deutschland";
                break;

            case 'ch':
                $country = "Schweiz";
                break;
        }  

        switch ($_POST['shippingaddress']){
            case 'billingaddress':
                $shippingaddress = "gleich wie rechnungsadresse";
                break;

            case 'shippingaddress':
                $shippingaddress = "Lieferadresse";
                break;
        }
        
        switch ($_POST['paymentmethod']){
            case 'pal':
                $paymentmethod = "Paypal";
                break;

            case 'bill':
                $paymentmethod = "Rechnung";
                break;
        }
        
        echo "Vorname:$first<br />Nachname$last<br />Adresse:$address<br />Postleitzahl:$postal<br />Ort:$city<br />Land:$country<br />Lieferadresse:$shippingaddress<br    />Zahlungsmethode:$paymentmethod";
        /*
        $nachricht="test";
        mail('meine_mailbox@gmx.ch', 'Bestellung', $nachricht);

             $_POST['firstname'], $_POST['lastname']);
        */
    }
?>

<html>
    <head>
        <script type="text/javascript" src="js/form.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="css/form.css">
    </head>
    <body>
        <form name="bestellung" action="form.php" method="post">
            <h1>Bestellung</h1>
            
            <h2>1. Rechnungsadresse</h2>
            Vorname:<input type="text" name="billing_firstname" /><br /> 
            Nachname:<input type="text" name="billing_lastname" /><br /> 
            Strasse und Hausnummer:<input type="text" name="billing_address" /><br />
            PLZ:<input type="text" name="billing_postalcode" /><br />
            Ort:<input type="text" name="billing_city" /><br />
            Land:<select name ="billing_country" size="1"> 
                <option value="de">Deutschland</option> 
                <option value="ch" selected>Schweiz</option> 
            </select>
            
            <h2>2. Lieferadresse</h2>
            <input type="radio" name="shippingaddress" value="billingaddress" onclick="lieferadresse()" checked>Gleich wie Rechnungsadresse</input><br />
            <input type="radio" name="shippingaddress" value="shippingaddress" onclick="lieferadresse()">Lieferadresse</input><br />
            <div id="shippingaddress" style="display: none;">
                Vorname:<input type="text" name="shipping_firstname" /><br /> 
                Nachname:<input type="text" name="shipping_lastname" /><br /> 
                Strasse und Hausnummer:<input type="text" name="shipping_address" /><br />
                PLZ:<input type="text" name="shipping_postalcode" /><br />
                Ort:<input type="text" name="shipping_city" /><br />
                Land:<select name ="shipping_country" size="1"> 
                    <option value="de">Deutschland</option> 
                    <option value="ch" selected>Schweiz</option> 
                </select>
            </div>
    
            <h2>3. Zahlungsmittel</h2>
            <select name ="paymentmethod" size="1"> 
                <option value="pal">PayPal</option> 
                <option value="bill" selected>Rechnung</option> 
            </select><br />
    
            <input type="submit" name="submitted" value="Submit"/>
    
         </form>
    </body>
</html>
