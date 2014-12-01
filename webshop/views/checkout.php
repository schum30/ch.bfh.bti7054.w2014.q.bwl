<div id="checkout">
	<form name="bestellung" action="checkout.php" method="post">
		<h1>Bestellung</h1>
		<div id="billingaddress">
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
		</div>

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
</div>
