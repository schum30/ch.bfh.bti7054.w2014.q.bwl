<?php
	$a = array(
		"Produkt 1" => array("Name" => "Burgdorfer Weizen", "Preis" => "3.25"),
		"Produkt 2" => array("Name" => "Bärni Weizen", "Preis" => "4.00")
	);
	foreach ($a as $value) {
				echo "<li>";
				echo "$expr[name]: " . $value["Name"];
				echo "<br/>";
				echo "$expr[price]: " . $value["Preis"];
				echo "</li>";
	}
?>
